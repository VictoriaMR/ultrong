<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Site;

class SiteService extends BaseService
{
    const CACHE_KEY = 'SITE_INFO_CACHE';

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
    	$info = Redis()->get(self::constant('CACHE_KEY'));
    	if (empty($info)) {
    		$info = $this->baseModel->find();
    		Redis()->set(self::constant('CACHE_KEY'), $info, -1);
    	}

    	return $info;
    }

    public function clearCache()
    {
        return Redis()->del(self::constant('CACHE_KEY'));
    }
}