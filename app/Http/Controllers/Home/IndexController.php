<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 前站入口控制器
 */

class IndexController extends Controller
{
	public function index()
	{	
		Html::addJs('swiper');
		Html::addCss('swiper');
		Html::addCss('index');

		$this->assign('index', 'index');

		return view();
	}
}