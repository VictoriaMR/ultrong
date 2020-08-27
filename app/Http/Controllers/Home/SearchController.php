<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\Html;

/**
 * 搜索入口控制器
 */

class SearchController extends Controller
{
	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{	
		Html::addCss('article');
		$keyword = iget('keyword', '');
		$size = empty($keyword) ? 10 : 999;
		
		//获取热门的产品和文章
		$articleService = \App::make('App/Services/ArticleService');
		$productService = \App::make('App/Services/ProductService');
		$baseWhere = ['lan_id' => \frame\Session::get('site_language_id')];
		if (!empty($keyword)) {
			$baseWhere['name, desc'] = ['like', '%'.$keyword.'%'];
		}
		$product = $productService->getList($baseWhere, 1, $size, [['is_hot', 'desc']], $keyword);

		$article = $articleService->getList($baseWhere, 1, $size, [['is_hot', 'desc']], $keyword);

		$this->assign('product', $product);
		$this->assign('article', $article);

		return view();
	}
}