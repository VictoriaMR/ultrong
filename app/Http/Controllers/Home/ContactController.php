<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;

/**
 * 联系入口控制器
 */

class ContactController extends Controller
{
	protected $serivces = null;

	public function index()
	{	
		dd('ContactController');

		return view();
	}
}