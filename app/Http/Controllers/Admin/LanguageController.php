<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LanguageService;
use frame\Html;

/**
 *  站点语言控制器
 */
class LanguageController extends Controller
{
	public function __construct(LanguageService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'语言管理'];
	}

	public function index()
	{
		return view();
	}
}