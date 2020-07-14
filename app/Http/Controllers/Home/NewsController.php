<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 新闻入口控制器
 */

class NewsController extends Controller
{
	protected $serivces = null;

	public function index()
	{	
		dd('NewsController');

		return view();
	}
}