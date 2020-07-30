<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use frame\html;
use frame\Session;

/**
 * 商品入口控制器
 */

class ProductListController extends Controller
{
	public function __construct(ProductService $service)
	{
		$this->baseService = $service;
		parent::_init();
	}

	public function index()
	{	
		Html::addCss('product');

		$cateId = (int) iget('cate_id', 0);
		$page = (int) iget('page', 1);

		//分类
		$cateService = \App::make('App/Services/CategoryService');
		$cateList = $cateService->getList(['status'=>1]);

		if (empty($cateId)) $cateId = $cateList[0]['cate_id'];

		$where = [
			'is_deleted' => 0, 
			'cate_id' => $cateId,
			// 'lan_id'=>Session::get('site_language_id'),
		];
		$total = $this->baseService->getTotal($where);

		if ($total > 0) {
			$list = $this->baseService->getList($where, $page, 20, [['hit_count', 'desc']]);
		}

		$this->assign('cate_id', $cateId);
		$this->assign('list', $list ?? []);
		$this->assign('cateList', $cateList);

		return view();
	}
}