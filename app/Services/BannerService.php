<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Banner;

class BannerService extends BaseService
{
    const CACHE_KEY = 'BANNER_INFO_CACHE_';

	public function __construct(Banner $site)
    {
        $this->baseModel = $site;
    }

    public function updateData($lanId, $data) 
    {
        $lanId = (int) $lanId;
        if (empty($lanId) || empty($data)) return false;

        $this->clearCache($lanId);

        if ($this->isExist($lanId)) {
            return $this->baseModel->updateDataById($lanId, $data);
        } else {
            $data['lan_id'] = $lanId;
            return $this->baseModel->insert($data);
        }
    }

    public function isExist($lanId)
    {
        if (empty($lanId)) return false;

        return $this->baseModel->where('lan_id', $lanId)->count() > 0;
    }

    /**
     * @method 获取站点详情
     * @author LiaoMingRong
     * @date   2020-07-13
     * @param  [type]     $data [description]
     * @return array
     */
    public function getInfo($lanId)
    {
        $cacheKey = self::constant('CACHE_KEY').$lanId;
    	$info = Redis()->get($cacheKey);
    	if (empty($info)) {
    		$info = $this->baseModel->loadData($lanId);
            $info['content'] = json_decode($info['content'], true);
            if (!empty($info['content'])) {
                $attachmentService = \App::make('App/Services/AttachmentService');
                $bannerArr = $attachmentService->getAttachmentListById(array_column($info['content'], 'attach_id'));
                $bannerArr = array_column($bannerArr, null, 'attach_id');
                foreach ($info['content'] as $k => $v) {
                    $info['content'][$k] = array_merge($v, $bannerArr[$v['attach_id']] ?? []);
                }
            }
    		Redis()->set($cacheKey, $info, -1);
    	}

    	return $info;
    }

    public function getList()
    {
        $list = $this->baseModel->get();
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

    public function clearCache($lanId)
    {
        return Redis()->del(self::constant('CACHE_KEY').$lanId);
    }
}