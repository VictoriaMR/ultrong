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
			$this->baseService->hitCountAdd($proId, $lanId);
			$this->assign('_title2', $info['name']);
			$this->assign('_description', $info['desc']);
		}

		//相关推荐
		$where = [
			'is_deleted' => 0,
		];

		if (!empty($info['lan_id'])) {
			$where['lan_id'] = $info['lan_id'];
		}
		$where['pro_id'] = [ '<>', $proId];
		$recommend = $this->baseService->getList($where, 1, 4, [['is_hot', 'desc'], ['hit_count', 'desc']]);

		$this->assign('cateList', $cateList);
		$this->assign('info', $info);
		$this->assign('recommend', $recommend);

		return view();
	}
}