<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Banner;

class BannerService extends BaseService
{
    const CACHE_KEY = 'BANNER_INFO_CACHE_';

	public function __construct(Banner $model)
    {
        $this->baseModel = $model;
    }

    public function updateData($lanId, $type, $data) 
    {
        $lanId = (int) $lanId;
        if (empty($lanId) || empty($data)) return false;

        $this->clearCache($lanId, $type);

        if ($this->isExist($lanId, $type)) {
            return $this->baseModel->where('lan_id', $lanId)
                                   ->where('type', $type)
                                   ->update($data);
        } else {
            $data['lan_id'] = $lanId;
            $data['type'] = $type;
            return $this->baseModel->insert($data);
        }
    }

    public function isExist($lanId, $type)
    {
        if (empty($lanId)) return false;

        return $this->baseModel->where('lan_id', $lanId)->where('type', $type)->count() > 0;
    }

    /**
     * @method 获取站点详情
     * @author LiaoMingRong
     * @date   2020-07-13
     * @param  [type]     $data [description]
     * @return array
     */
    public function getInfo($lanId, $type = 0)
    {
        $lanId = (int) $lanId;
        $type = (int) $type;
        $cacheKey = self::constant('CACHE_KEY').$lanId.'_'.$type;
    	$info = Redis()->get($cacheKey);
    	if (empty($info)) {
    		$info = $this->baseModel->loadData($lanId);
            $info['content'] = json_decode($info['content'], true);
            if (!empty($info['content'])) {
                $attachmentService = \App::make('App/Services/AttachmentService');
                $bannerArr = $attachmentService->getAttachmentListById(array_column($info['content'], 'attach_id'));
                foreach ($bannerArr as $key => $value) {
                    $bannerArr[$key]['url'] = $this->pathUrl($value['url'], '_thumb');
                }
                $bannerArr = array_column($bannerArr, null, 'attach_id');
                foreach ($info['content'] as $k => $v) {
                    $info['content'][$k] = array_merge($v, $bannerArr[$v['attach_id']] ?? []);
                }
            }
    		Redis()->set($cacheKey, $info, -1);
    	}

    	return $info;
    }

    public function getList($where = [])
    {
        $list = $this->baseModel->where($where)->get();
        $attachmentService = \App::make('App/Services/AttachmentService');

        foreach ($list as $key => $value) {
            if (!empty($value['content'])) {
                $value['content'] = json_decode($value['content'], true);
                $bannerArr = $attachmentService->getAttachmentListById(array_column($value['content'], 'attach_id'));
                $bannerArr = array_column($bannerArr, null, 'attach_id');
                foreach ($value['content'] as $k => $v) {
                    $value['content'][$k] = array_merge($v, $bannerArr[$v['attach_id']] ?? []);
                }
            } else {
                $value['content'] = [];
            }
            $list[$key] = $value;
        }

        $list = array_column($list, null, 'lan_id');

        return $list;
    }

    public function clearCache($lanId, $type = 0)
    {
        $lanId = (int) $lanId;
        $type = (int) $type;
        return Redis()->del(self::constant('CACHE_KEY').$lanId.'_'.$type);
    }
}