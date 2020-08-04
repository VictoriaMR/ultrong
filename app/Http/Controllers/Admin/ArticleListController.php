<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleListService;
use frame\Html;

/**
 * 
 */
class ArticleListController extends Controller
{
	public function __construct(ArticleListService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'文章分类配置'];
		parent::_initialize();
	}

	public function index()
	{
		Html::addJs('article/index');
		$list = $this->baseService->getList();

		$this->assign('list', $list);
		return view();
	}
}