<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use frame\html;

/**
 * 新闻入口控制器
 */

class ArticleController extends Controller
{
	public function __construct(ArticleService $service)
	{
		$this->baseService = $service;
		parent::_init();
	}

	public function index()
	{	
		return view();
	}
}