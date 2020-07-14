<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use frame\Session;

/**
 *  首页控制器
 */
class IndexController extends Controller
{
	/**
	 * @method 设置站点语言
 	 * @author LiaoMingRong
	 * @date   2020-07-14
	 */
	public function setSiteLanguage() 
	{
		$type = iget('type', '');
		if (empty($type)) 
			return $this->result(10000, false, ['message' => '参数不正确!']);

		$languageService = \App::make('App/Services/LanguageService');
		$list = $languageService->getList();
		$list = array_column($list, null, 'value');
		if (empty($list[$type]))
			return $this->result(10000, false, ['message' => '数据有误, 语言未配置!']);

		Session::set('site_language', $type);

		return $this->result(200, true, ['message' => '设置成功!']);
	}
}