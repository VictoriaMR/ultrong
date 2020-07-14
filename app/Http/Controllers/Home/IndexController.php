<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 前站入口控制器
 */

class IndexController extends Controller
{
	protected $serivces = null;

	public function index()
	{	
		Html::addCss('index');

		return view();
	}
}