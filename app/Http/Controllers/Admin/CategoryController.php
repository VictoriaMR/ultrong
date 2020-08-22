<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use frame\Html;

/**
 *  产品分类控制器
 */
class CategoryController extends Controller
{
	public function __construct(CategoryService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'分类管理'];
		parent::_initialize();
	}

	public function index()
	{
		Html::addJs('category/index');

		$list = $this->baseService->getList();

		$this->assign('list', $list);

		return view();
	}

	public function modify()
	{
		$cateId = (int)ipost('cate_id');
		$name = ipost('name');
		$name_en = ipost('name_en');
		$status = ipost('status');
		$isIndex = ipost('is_index');
		$remark = ipost('remark');

		$data = [];

		if (!empty($name))
			$data['name'] = $name;
		if (!empty($name_en))
			$data['name_en'] = $name_en;
		if ($status !== null)
			$data['status'] = (int) $status;
		if ($isIndex !== null)
			$data['is_index'] = (int) $isIndex;
		if (!empty($remark))
			$data['remark'] = $remark;

		if (empty($data))
			return $this->result(10000, false, ['参数不正确']);

		if (!empty($cateId)) {
			$result = $this->baseService->updateDataById($cateId, $data);
		} else {
			if (empty($data['name']))
				return $this->result(10000, false, ['分类名称不能为空']);
			$result = $this->baseService->insertGetId($data);
		}

		if ($result) {
			$this->baseService->clearCache();
			return $this->result(200, $result, ['message' => '保存成功']);
		} else {
			return $this->result(10000, $result, ['message' => '保存失败']);
		}
	}

	public function delete()
	{
		$cateId = (int)ipost('cate_id');
		if (empty($cateId))
			return $this->result(10000, false, ['参数不正确']);

		if ($this->baseService->hasChildren($cateId))
			return $this->result(10000, false, ['有子分类, 不能删除']);

		if ($this->baseService->hasProduct($cateId))
			return $this->result(10000, false, ['分类下有关联商品, 不能删除']);

		$result = $this->baseService->deleteById($cateId);

		if ($result) {
			$this->baseService->clearCache();
			return $this->result(200, $result, ['message' => '删除成功']);
		} else {
			return $this->result(10000, $result, ['message' => '删除失败']);
		}
	}
}