<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Language;

class LanguageService extends BaseService
{
	public function __construct(Language $language)
    {
        $this->baseModel = $language;
    }

    /**
     * @method 获取语言列表
     * @author LiaoMingRong
     * @date   2020-07-13
     * @param  [type]     $data [description]
     * @return array
     */
    public function getList($where = [])
    {
    	$cacheKey = 'LANGUAGE_LIST_CACHE';
    	$list = Redis()->get($cacheKey);
    	if (empty($list)) {
    		$list = $this->baseModel->get();
    		$list = json_encode($list, JSON_UNESCAPED_UNICODE);
    		Redis()->set($cacheKey, $list);
    	}

    	return !empty($list) ? json_decode($list, true) : [];
    }
}