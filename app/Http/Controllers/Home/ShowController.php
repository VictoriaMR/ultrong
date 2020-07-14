<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 应用展示入口控制器
 */

class ShowController extends Controller
{
	protected $serivces = null;

	public function index()
	{	
		dd('ShowController');

		return view();
	}
}