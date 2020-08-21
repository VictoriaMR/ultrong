<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleCategoryService;
use frame\Html;

/**
 * 
 */
class ArticleCategoryController extends Controller
{
	public function __construct(ArticleCategoryService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'文章分类配置'];
		parent::_initialize();
	}

	public function index()
	{
		Html::addJs('article/index');
		$list = $this->baseService->getList();

		$this->assign('list', $list);
		return view();
	}

	/**
	 * @method 修改配置
	 * @author LiaoMingRong
	 * @date   2020-07-21
	 * @return [type]     [description]
	 */
	public function modify()
	{
		$cateId = (int) ipost('cate_id');
		$parentId = (int) ipost('parent_id', 0);
		$name = ipost('name', '');
		$name_en = ipost('name_en', '');
		$status = ipost('status', null);
		$data = [];

		if ($status !== null) {
			$data['status'] = (int) $status;
		}

		if (!empty($name))
			$data['name'] = $name;
		if (!empty($name_en))
			$data['name_en'] = $name_en;

		if (empty($data))
			return $this->result(10000, false, ['message'=>'参数不正确']);

		if (!empty($cateId)) {
			$result = $this->baseService->updateDataById($cateId, $data);

			if ($result) {
				if ($status == $this->baseService::constant('STATUS_CLOSE')) {
					if ($this->baseService->isParent($conId)) {
						$result = $this->baseService->modifyIndoByParentId($conId, ['status' => $status]);
					}
				}
			}
		} else {
			if (!empty($parentId))
				$data['parent_id'] = $parentId;

			$result = $this->baseService->insert($data);
		}

		if ($result) {
			$this->baseService->cleanCache();
			return $this->result(200, $result, ['message' => '保存成功']);
		} else {
			return $this->result(10000, $result, ['message' => '保存失败']);
		}
	}

	public function delete()
	{
		$cateId = (int) ipost('cate_id');
		if (empty($cateId))
			return $this->result(10000, false, ['message'=>'缺失ID']);

		//先删除子类 再删除 主类
		if ($this->baseService->isParent($cateId)) {
			$this->baseService->deleteByParentId($cateId);
		}

		$result = $this->baseService->deleteById($cateId);

		if ($result) {
			$this->baseService->cleanCache();
			return $this->result(200, $result, ['message' => '删除成功']);
		}
		else
			return $this->result(10000, $result, ['message' => '删除失败']);
	}
}