<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 关于入口控制器
 */

class AboutController extends Controller
{
	protected $serivces = null;

	public function index()
	{	
		dd('AboutController');

		return view();
	}
}