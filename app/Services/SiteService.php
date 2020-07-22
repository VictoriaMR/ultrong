<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Site;

class SiteService extends BaseService
{
	public function __construct(Site $site)
    {
        $this->baseModel = $site;
    }

    /**
     * @method 获取站点详情
     * @author LiaoMingRong
     * @date   2020-07-13
     * @param  [type]     $data [description]
     * @return array
     */
    public function getInfo($where = [])
    {
    	$cacheKey = 'SITE_INFO_CACHE';
    	$info = Redis()->get($cacheKey);
    	if (empty($info)) {
    		$info = $this->baseModel->find();
    		Redis()->set($cacheKey, $info, -1);
    	}

    	return $info;
    }
}