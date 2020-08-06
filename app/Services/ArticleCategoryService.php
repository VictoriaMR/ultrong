<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\ArticleCategory;

class ArticleCategoryService extends BaseService
{
	const CACHE_KEY = 'ARTICLE_CATEGORY_LIST_CACHE';

	protected static $constantMap = [
        'base' => ArticleCategory::class,
    ];

	public function __construct(ArticleCategory $model)
    {
        $this->baseModel = $model;
    }

    public function getList()
    {
    	$list = Redis()->get(self::CACHE_KEY);
    	if (empty($list)) {
    		$list = $this->getListFormat();
    		Redis()->set(self::CACHE_KEY, $list, -1);
    	}
    	return $list;
    }

    protected function getListFormat()
    {
    	$list = $this->baseModel->get();
    	if (!empty($list)) {
    		$list = $this->listFormat($list);
    	}
    	return $list;
    }

    /**
     * @method 分类递归函数
     * @author LiaoMingRong
     * @date   2020-08-03
     * @param  array      $list     数据列表
     * @param  integer    $parentId 层级父ID
     * @return array
     */
    protected function listFormat($list, $parentId = 0) 
    {
    	$returnData = [];
    	foreach ($list as $value) {
    		if ($value['parent_id'] == $parentId) {
    			$temp = $this->listFormat($list, $value['cate_id']);
    			if (!empty($temp)) {
	    			$value['son'] = $temp;
    			}
	    		$returnData[] = $value;
    		}
    	}
    	return $returnData;
    }

    public function cleanCache()
    {
        return Redis()->del(self::CACHE_KEY);
    }


    /**
     * @method 检查是否为父类
     * @author LiaoMingRong
     * @date   2020-07-21
     * @return boolean 
     */
    public function isParent($cateId)
    {
        $cateId = (int) $cateId;
        if (empty($cateId)) return false;

        return $this->baseModel->where('cate_id', $cateId)
                               ->where('parent_id', 0)
                               ->count() > 0;
    }

    /**
     * @method 根据父ID删除
     * @author LiaoMingRong
     * @date   2020-07-21
     * @return boolean
     */
    public function deleteByParentId($parentId)
    {
        $parentId = (int) $parentId;
        if (empty($parentId)) return false;

        return $this->baseModel->where('parent_id', $parentId)
                               ->delete();
    }
}