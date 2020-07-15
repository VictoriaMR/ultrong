<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use frame\Html;

/**
 * 
 */
class SettingController extends Controller
{
	public function __construct()
	{
		$this->tabs = ['index'=>'站点管理', 'controller'=>'功能管理'];
		parent::_initialize();
	}

	public function index()
	{
		return view();
	}

	public function controller()
	{
		return view();
	}
}