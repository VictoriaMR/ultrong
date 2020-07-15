<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MemberService;
use frame\Html;

/**
 *  登陆控制器
 */
class LoginController extends Controller
{
	
	function __construct(MemberService $service)
	{
		$this->baseService = $service;
	}

	public function index()
	{
		Html::addCss('login');
		Html::addJs('login');
		
		return view();
	}

	public function logout()
	{
		\frame\Session::set('admin');

		go('login.index');
	}
}