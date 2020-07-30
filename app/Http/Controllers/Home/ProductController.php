<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use frame\html;

/**
 * 商品入口控制器
 */

class ProductController extends Controller
{
	public function __construct(ProductService $service)
	{
		$this->baseService = $service;
		parent::_init();
	}

	public function index()
	{	
		Html::addCss('product');
		Html::addJs('product');

		$proId = iget('pro_id', 0);
		$lanId = iget('lan_id', 0);

		//分类
		$cateService = \App::make('App/Services/CategoryService');
		$cateList = $cateService->getList(['status'=>1]);

		$info = $this->baseService->getInfo($proId, $lanId);
		if (!empty($info)) {
			$this->assign('_title2', $info['name']);
			$this->assign('_description', $info['desc']);
		}

		// print_r($info);

		$this->assign('cateList', $cateList);
		$this->assign('info', $info);

		return view();
	}
}