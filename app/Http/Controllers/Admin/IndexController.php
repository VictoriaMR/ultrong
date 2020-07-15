<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use frame\Html;
use frame\Session;

/**
 * 
 */
class IndexController extends Controller
{
	public function index() 
	{
		Html::addCss('index');
		Html::addJs('index');

		//获取颜色
		$colorService = \App::make('App\Services\Admin\ColorService');
		$colorList = $colorService->getList();

		//获取控制器列表
		$controllerService = \App::make('App\Services\Admin\ControllerService');
		$controllerList = $controllerService->getListFormat();

		//网站信息
		$siteService = \App::make('App/Services/SiteService');
		$siteInfo = $siteService->getInfo();

		//基本信息
		$info = Session::get('admin');

		// $this->assign('site_info', $siteInfo);
		$this->assign('info', $info);
		$this->assign('list', $controllerList);

		return view();
	}

	public function show() 
	{
		return view();
	}
}