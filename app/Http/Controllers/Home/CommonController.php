<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\Session;
use frame\Html;

/**
 * 前站公共控制器
 */

class CommonController extends Controller
{
	public function baseHeader()
	{	
		Html::addCss('common');
		Html::addJs('common');
		
		//站点信息
		$siteService = \App::make('App/Services/SiteService');
		$siteInfo = $siteService->getInfo();

		$languageService = \App::make('App/Services/LanguageService');
		$list = $languageService->getListCache();
		$list = array_column($list, null, 'value');

		//设置默认语言
		$site_language = Session::get('site_language_name');
		if (empty($site_language)) {
			$defaultLanguage = array_column($list, null,'is_default')[1] ?? [];
			Session::set('site', ['language_name' => $defaultLanguage['value'] ?? '', 'language_id' => $defaultLanguage['lan_id'] ?? 0]);
		}
		
		$this->assign('site_language', $site_language);
		$this->assign('language_list', $list);
		$this->assign($siteInfo);

		return view();
	}
}