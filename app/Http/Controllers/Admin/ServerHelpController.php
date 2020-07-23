<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 *  产品分类控制器
 */
class ServerHelpController extends Controller
{
	public function __construct()
	{
		$this->tabs = ['index'=>'组件运行状态', 'phppage' => 'PHPINFO信息'];
		parent::_initialize();
	}

	public function index()
	{
		return view();
	}

	public function phppage()
	{
		return view();
	}
}