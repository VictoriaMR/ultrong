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
				];
			}
		}
		
		$this->assign('iconList', $iconList);
		$this->assign('list', $list);

		return view();
	}

	public function controller()
	{
		return view();
	}
}