<?php 

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Category;

/**
 * 
 */
class CategoryService extends BaseService
{
	const CACHE_KEY = 'PRODUCT_CATEGORY_CACHE_LIST';
	const CACHE_INFO_KEY = 'PRODUCT_CATEGORY_CACHE_INFO';

	public function __construct(Category $model)
    {
        $this->baseModel = $model;
    }

	public function getList($where = [])
	{
		$list = Redis()->get(self::constant('CACHE_KEY'));
		if (empty($list)) {
			$list = $this->baseModel->where($where)->get();
			if (!empty($list))
				Redis()->set(self::constant('CACHE_KEY'), $list, -1);
		}
		return $list;
	}

	public function clearCache($cateId = 0)
	{
		if (empty($cateId))
			Redis()->del(self::constant('CACHE_KEY'));
		else
			Redis()->hDel(self::constant('CACHE_INFO_KEY'), $cateId);
		return true;
	}

	public function create($data)
	{
		if (empty($data['name'])) return false;
		$insert = [];
		$insert['name'] = $data['name'];
	}

	public function hasChildren($cateId)
	{
		$cateId = (int) $cateId;
		if (empty($cateId)) return false;

		return $this->baseModel->where('parent_id', $cateId)->count() > 0;
	}

	public function hasProduct($cateId)
	{
		$cateId = (int) $cateId;
		if (empty($cateId)) return false;

		$productService = \App::make('App/Services/ProductService');

		return $productService->where('cate_id', $cateId)->count() > 0;
	}

	public function getInfoCache($cateId)
	{
		$cateId = (int) $cateId;
		if (empty($cateId)) return [];
		$info = Redis()->hGet(self::constant('CACHE_INFO_KEY'), $cateId);
		if (empty($info)) {
			$info = $this->baseModel->loadData($cateId);
			Redis()->hSet(self::constant('CACHE_INFO_KEY'), $cateId, $info);
		}
		return $info;
	}
}