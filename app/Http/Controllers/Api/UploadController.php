<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileService;

/**
 *  上传文件控制器
 */
class UploadController extends Controller
{
	public function __construct(FileService $service)
	{
		$this->baseService = $service;
	}

	public function index2()
	{
		$site = ipost('site', '');
		$file = ifile('file', []);

		if (empty($site) || empty($file))
			return $this->result(10000, false, ['message'=>'上传文件参数不正确!']);

		$result = $this->baseService->upload($file, $site);

		if (empty($result))
			return $this->result(10000, $result, ['message'=>'上传失败!']);

		return $this->result(200, $result, ['message'=>'上传成功!']);
	}

	public function index()
	{
		$file = ifile('file'); //长传文件
        $site = ipost('site', 'product'); //类型
        $action = input('action');
        $page = input('start', 1);
        $size = input('size', 20);

        switch ($action) {
            case 'config':
                $this->getUEditorConfig();
                break;
            case 'listimage':
                $attachmemtService = \App::make('App/Services/AttachmentService');
                $list = $attachmemtService->getFileList($attachmemtService::constant('TYPE_PRODUCT'), $page, $size);
                $temp = [
                    'state' => 'SUCCESS',
                    'start' => $page,
                ];
               	return $this->result(200, true, array_merge($list, $temp));
                break;
            
            default:
                # code...
                break;
        }

        $result = $this->baseService->upload($file, $site);

        if (!empty($action)) {

            $temp = [
                'state' => $result ? 'SUCCESS' : 'FAILED',
                'url' => $result['url'] ?? '',
            ];
        }

        if (empty($result))
			return $this->result(10000, $result, array_merge(['message'=>'上传失败!'], $temp ?? []));

		return $this->result(200, $result, array_merge(['message'=>'上传成功!'], $temp ?? []));
    }

    public function getUEditorConfig()
    {
        $config = preg_replace('/\/\*[\s\S]+?\*\//', '', file_get_contents(ROOT_PATH.'public/js/computer/ueditor/config.json'));
        echo $config;
        exit();
    }
}