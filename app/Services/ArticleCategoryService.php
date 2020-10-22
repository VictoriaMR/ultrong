<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\ArticleCategory;

class ArticleCategoryService extends BaseService
{
	const CACHE_KEY = 'ARTICLE_CATEGORY_LIST_CACHE';
    const CACHE_INFO_KEY = 'ARTICLE_CATEGORY_CACHE_INFO';

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
            $list = $this->baseModel->get();
    		Redis()->set(self::CACHE_KEY, $list, -1);
    	}
    	return $list;
    }

    public function getListFormat()
    {
    	$list = $this->getList();
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
                $value['type_text'] = $this->getTypeText($value['type']);
	    		$returnData[] = $value;
    		}
    	}
    	return $returnData;
    }

    protected function getTypeText($type)
    {
        $arr = [
            '普通文章',
            '列表文件',
            '详细文件',
        ];
        return $arr[$type] ?? '';
    }

    public function cleanCache()
    {
        Redis()->del(self::CACHE_KEY);
        Redis()->del(self::CACHE_INFO_KEY);
        return true;
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

    public function hasChildren($cateId)
    {
        $cateId = (int) $cateId;
        if (empty($cateId)) return 0;

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

    public function modifyIndoByParentId($parentId, $data)
    {
        $parentId = (int) $parentId;
        if (empty($parentId)) return false;

        return $this->baseModel->where('parent_id', $parentId)
                               ->update($data);
    }

    public function getInfoCache($cateId)
    {
        $cateId = (int) $cateId;
        if (empty($cateId)) return [];
        $info = Redis()->hGet(self::CACHE_INFO_KEY, $cateId);
        if (empty($info)) {
            $info = $this->baseModel->loadData($cateId);
            Redis()->hSet(self::CACHE_INFO_KEY, $cateId, $info);
        }
        return $info;
    }

    public function getCategoryName($cateId)
    {
        $cateId = (int) $cateId;
        if (empty($cateId)) return '';
        $info = $this->getInfoCache($cateId);
        $str = '';
        if (!empty($info)) {
            if (!empty($info['parent_id'])) {
                $temp = $this->getInfoCache($info['parent_id']);
                $str .= $temp['name_en'].'-';
            }
            $str .= $info['name_en'];
        }

        return $str;
    }
}