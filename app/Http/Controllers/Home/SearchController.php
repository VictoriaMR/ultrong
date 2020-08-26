<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\Html;

/**
 * 搜索入口控制器
 */

class SearchController extends Controller
{
	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{	
		dd('功能开发中');

		return view();
	}
}