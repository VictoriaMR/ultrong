<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleCategoryService;
use frame\Html;

/**
 * 
 */
class ArticleCategoryController extends Controller
{
	public function __construct(ArticleCategoryService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'文章分类配置'];
		parent::_initialize();
	}

	public function index()
	{
		$list = $this->baseService->getList();
		dd($list);
		return view();
	}
}