<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\Session;

/**
 * 前站公共控制器
 */

class CommonController extends Controller
{
	public function baseHeader()
	{	
		//站点信息
		// $siteService = \App::make('App/Services/SiteService');
		// $siteInfo = $siteService->getInfo();

		// $languageService = \App::make('App/Services/LanguageService');
		// $list = $languageService->getList();

		// Session::set('site_language', empty($defaultLanguage['value']) ? 'en' : $defaultLanguage['value']);

		// //设置默认语言
		// if (empty(Session::getInfo('site_language'))) {
		// 	$defaultLanguage = array_column($list, 'is_default')[1] ?? [];
		// 	Session::set('site_language', empty($defaultLanguage['value']) ? 'cn' : $defaultLanguage['value']);
		// }

		// $this->assign('language_list', $list);
		// $this->assign($siteInfo);

		return view();
	}
}