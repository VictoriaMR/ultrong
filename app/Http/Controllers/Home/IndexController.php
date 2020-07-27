<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;
use frame\Session;

/**
 * 前站入口控制器
 */

class IndexController extends Controller
{
	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{	
		Html::addCss('swiper');
		Html::addJs('swiper', true);
		$bannerService = \App::make('App/Services/BannerService');
		$banner = $bannerService->getInfo(Session::get('site_language_id'), isMobile());

		// print_r($banner);

		$this->assign('banner', $banner);
		return view();
	}

	/**
	 * @method 设置站点语言
 	 * @author LiaoMingRong
	 * @date   2020-07-14
	 */
	public function setSiteLanguage() 
	{
		$id = (int) iget('lan_id', '');
		if (empty($id)) 
			return $this->result(10000, false, ['message' => '参数不正确!']);

		$languageService = \App::make('App/Services/LanguageService');
		$list = $languageService->getList();
		$list = array_column($list, null, 'lan_id');
		if (empty($list[$id]))
			return $this->result(10000, false, ['message' => '数据有误, 语言未配置!']);

		Session::set('site', ['language_name' => $list[$id]['value'] ?? '', 'language_id' => $list[$id]['lan_id'] ?? 0]);

		return $this->result(200, true, ['message' => '设置成功!']);
	}
}