<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LanguageService;
use frame\Html;

/**
 *  站点语言控制器
 */
class LanguageController extends Controller
{
	public function __construct(LanguageService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'语言管理'];
		parent::_initialize();
	}

	public function index()
	{
		Html::addJs('language/index');
		$list = $this->baseService->getList();

		$this->assign('list', $list);

		return view();
	}

	public function modify()
	{
		$lanId = (int) ipost('lan_id');
		$isDefault = (int) ipost('is_default');
		$status = ipost('status');

		if (!empty($lanId)) {
			if (!empty($isDefault)) {
				$this->baseService->update(['is_default'=>0]);
				$result = $this->baseService->updateDataById($lanId, ['is_default'=> 1]);
			}

			if ($status !== null) {
				$result = $this->baseService->updateDataById($lanId, ['status'=> (int) $status]);
			}
		}

		if ($result) {
			$this->baseService->clearCache();
			return $this->result(200, true, ['message' => '设置成功']);
		} else {
			return $this->result(10000, false, ['message' => '设置失败']);
		}
	}

	public function update()
	{
		$lanId = (int) ipost('lan_id');
		$isDefault = ipost('is_default');
		$status = ipost('status');
		$name = ipost('name', '');
		$value = ipost('value', '');

		if (empty($name) || empty($value))
			return $this->result(10000, false, ['message' => '参数不正确']);

		$data = [
			'name' => $name,
			'value' => $value,
		];

		if ($status !== null) {
			$data['status'] = (int) $status;
		}
		if ($isDefault !== null) {
			$data['is_default'] = (int) $isDefault;
		}

		if ($this->baseService->existLanguage($value, $lanId))
			return $this->result(10000, false, ['message' => '语言设置重复']);

		if (empty($lanId)) {
			$lanId = $this->baseService->insertGetId($data);
			$result = $lanId > 0;
		} else {
			$result = $this->baseService->updateDataById($lanId, $data);
		}

		if ($result) {
			if (!empty($isDefault)) {
				$this->baseService->where('lan_id', '<>', $lanId)->update(['is_default'=>0]);
			}
			$this->baseService->clearCache();
			return $this->result(200, $result, ['message' => '保存成功']);
		} else {
			return $this->result(10000, false, ['message' => '保存失败']);
		}

	}
}