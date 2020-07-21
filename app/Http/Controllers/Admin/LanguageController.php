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
		}

		if ($result) {
			return $this->result(200, true, ['message' => '设置成功']);
		} else {
			return $this->result(10000, false, ['message' => '设置失败']);
		}
	}
}