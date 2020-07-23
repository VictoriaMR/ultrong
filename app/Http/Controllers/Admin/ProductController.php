<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use frame\Html;

/**
 * 
 */
class ProductController extends Controller
{
	
	function __construct(ProductService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'SPU列表'];
		parent::_initialize();
	}

	public function index()
	{
		$page = iget('page', 1);
		$size = iget('size', 30);
		$spuId = iget('spu_id', '');
		$keyword = iget('keyword', '');
		$cateId = iget('cate_id', '');
		$lanId = iget('lan_id', '');

		$where = [];

		if (!empty($spuId))
			$where['pro_id'] = (int) $spuId;
		if (!empty($lanId))
			$where['lan_id'] = (int) $lanId;
		if (!empty($cateId))
			$where['cate_id'] = (int) $cateId;
		if (!empty($keyword))
			$where[] = ['name', 'like', '%'.$keyword.'%'];

		$total = $this->baseService->getTotal($where);

		if ($total > 0) {
			$list = $this->baseService->getList($where, $page, $size);
		}

		//分类列表
		$categoryService = \App::make('App/Services/CategoryService');
		$cateList = $categoryService->getList();
		//语言列表
		$languageService = \App::make('App/Services/LanguageService');
		$lanList = $languageService->getList();

		$this->assign('cateList', $cateList);
		$this->assign('lanList', $lanList);
		$this->assign('total', $total);
		$this->assign('list', $list ?? []);
		$this->assign('size', $size);
		$this->assign('spu_id', $spuId);
		$this->assign('keyword', $keyword);
		$this->assign('cate_id', $cateId);
		$this->assign('lan_id', $lanId);

		return view();
	}

	public function list() 
	{
		$page = iget('page', 1);
		$size = iget('size', 30);

		$list = $this->baseService->getList([], $page, $size);

		assign(['list' => $list]);

		view();
	}
}