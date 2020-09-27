<?php

namespace App\Services;

use App\Services\Base as BaseService;

class FileService extends BaseService
{
    const FILE_TYPE = ['temp', 'avatar', 'product', 'banner', 'file', 'article', 'fujian'];
    const FILE_ACCEPT = ['jpg', 'jpeg', 'png', 'ico', 'gif', 'mp4', 'flv', 'mp3', 'rmvb', 'zip', 'arr'];
    const FILE_COMPERSS = ['jpg', 'jpeg', 'png'];
    const MAX_OFFSET = 1200;

    /**
     * 通过文件路径上传
     *
     * @param string $filePath 待上传文件路径
     * @param string $module 图片业务类别（可不传）,比如头像 avatar 商品 product
     * @return mix 失败返回 false
     */
    public function upload($file, $cate = 'temp', $prev='', $ext = '')
    {
        if (!in_array($cate, self::FILE_TYPE)) return false;
        $tmpname = explode('.', $file['name']);
        $extension = $tmpname[1] ?? ''; //后缀
        $tmpFile = $file['tmp_name']; //上传文件路径

        if (!in_array($extension, self::constant('FILE_ACCEPT')))
            return false;

        $imageService = \App::make('App/Services/ImageService');

        if ($cate == 'file') {
            if (!empty($ext))
                $extension = $ext;

            $saveUrl = ROOT_PATH.'public/image/'.$prev.'.'.$extension;
            $result = move_uploaded_file($tmpFile, $saveUrl);
            if ($result) {
                //压缩icon
                if ($extension == 'ico') {
                    $imageService->thumbImage($saveUrl, $saveUrl, 32, 32);
                } else {
                    $imageService->compressImg($saveUrl);
                }
                $returnData = [
                    'url' => str_replace(ROOT_PATH.'public/', Env('APP_DOMAIN'), $saveUrl).'?v='.time(),
                ];
            }
        } else {

            $hash = hash_file('md5', $tmpFile); //生成文件hash值
            $attachmentService = \App::make('App\Services\AttachmentService');

            $returnData = [];
            if ($attachmentService->isExitsHash($hash)) { 
                //文件已存在
                $returnData = $attachmentService->getAttachmentByHash($hash);
            } else {

                $insert = [
                    'name' => $hash,
                    'type' => $extension,
                    'cate' => $cate,
                    'source_name' => $this->utf8_unicode(substr($tmpname[0], strrpos($tmpname[0], '/') + 1)),
                    'size' => $file['size'] ?? filesize($file['name']),
                ];

                //保存文件地址
                $saveUrl = $cate;

                if (!empty($prev))
                	$saveUrl .= '/'.$prev;

                //中间路径
                $insert['path'] = $saveUrl;

                $saveUrl .= '/'.$hash.'.'.$extension;

                $saveUrl = ROOT_PATH.'public/file_center/'.$saveUrl;

                $savePath = pathinfo($saveUrl, PATHINFO_DIRNAME);

                //创建目录
                if (!is_dir($savePath)) {
                    mkdir($savePath, 0777, true);
                }

                $result = move_uploaded_file($tmpFile, $saveUrl);

                if ($result) {
                    //压缩文件
                    if (in_array($cate, ['banner'])) {
                        $imageService->compressImg($saveUrl, $this->pathUrl($saveUrl, '_thumb'));
                        $saveUrl = $this->pathUrl($saveUrl, '_thumb');
                    } elseif (in_array($cate, ['avatar', 'product', 'article'])) {
                        $imageService->thumbImage($saveUrl, $this->pathUrl($saveUrl, '800x800'), 800, 800);
                        $imageService->thumbImage($saveUrl, $this->pathUrl($saveUrl, '600x600'), 600, 600);
                        $imageService->thumbImage($saveUrl, $this->pathUrl($saveUrl, '300x300'), 300, 300);
                        $saveUrl = $this->pathUrl($saveUrl, '800x800');
                    }
                    //新增文件记录
                    $attachmentId = $attachmentService->addAttactment($insert);
                    if (!$attachmentId) return false;
                    $insert['attach_id'] = $attachmentId;
                    $insert['url'] = str_replace(ROOT_PATH.'public/', Env('APP_DOMAIN'), $saveUrl);
                }
                $returnData = $insert;
            }
        }

        return $returnData;
    }

    //在代码中隐藏utf8格式的字符串
    protected function utf8_unicode($str) 
    {
        $encode = mb_detect_encoding($str, array('CP936', 'ASCII','GB2312','GBK','UTF-8','BIG5'));
        if ($encode == 'UTF-8') {
            return $str;
        } elseif ($encode == 'CP936') {
            return iconv('utf-8', 'latin1//IGNORE', $str);
        } else {
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }
}
