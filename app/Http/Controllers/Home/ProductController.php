<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 商品入口控制器
 */

class ProductController extends Controller
{
	protected $serivces = null;

	public function index()
	{	
		dd('ProductController');

		return view();
	}
}