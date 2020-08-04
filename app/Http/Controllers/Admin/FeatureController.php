<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ControllerService;
use frame\Html;

/**
 * 
 */
class FeatureController extends Controller
{
	public function __construct(ControllerService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'系统功能配置'];
		parent::_initialize();
	}

	public function index()
	{
		Html::addJs('feature/index');

		$list = $this->baseService->getListFormat();

		$iconList = [];
		foreach (scandir(ROOT_PATH . 'public/image/computer/icon/feature') as $value) {
			if ($value == '.' || $value == '..') continue;
			$temp = explode('.', $value);
			if (substr($temp[0], 0, 1) == '5') {
				$iconList[] = [
					'name' => $temp[0],
					'type' => $temp[1],
					'value' => $value,
					'url' => siteUrl('image/computer/icon/feature/'.$value),
				];
			}
		}
		
		$this->assign('iconList', $iconList);
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
		$conId = (int) ipost('con_id');
		$parentId = (int) ipost('parent_id', 0);
		$status = ipost('status', null);
		$name = ipost('name', '');
		$nameEn = ipost('name_en', '');
		$icon = ipost('icon', '');
		$remark = ipost('remark', '');

		$data = [];

		if ($status !== null) {
			$data['status'] = (int) $status;
		}

		if (!empty($name))
			$data['name'] = $name;
		if (!empty($nameEn))
			$data['name_en'] = $nameEn;
		if (!empty($icon))
			$data['icon'] = $icon;
		if (!empty($remark))
			$data['remark'] = $remark;

		if (empty($data))
			return $this->result(10000, false, ['message'=>'参数不正确']);

		if (!empty($conId)) {
			$result = $this->baseService->updateDataById($conId, $data);

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

		if ($result)
			return $this->result(200, $result, ['message' => '保存成功']);
		else
			return $this->result(10000, $result, ['message' => '保存失败']);
	}

	public function delete()
	{
		$conId = (int) ipost('con_id');
		if (empty($conId))
			return $this->result(10000, false, ['message'=>'缺失ID']);

		//先删除子类 再删除 主类
		if ($this->baseService->isParent($conId)) {
			$this->baseService->deleteByParentId($conId);
		}

		$result = $this->baseService->deleteById($conId);

		if ($result)
			return $this->result(200, $result, ['message' => '删除成功']);
		else
			return $this->result(10000, $result, ['message' => '删除失败']);
	}
}