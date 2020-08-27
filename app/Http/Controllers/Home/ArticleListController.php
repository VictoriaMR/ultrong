<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\ArticleCategoryService;
use App\Services\ArticleService;
use frame\Html;

/**
 * 新闻入口控制器
 */

class ArticleListController extends Controller
{
	public function __construct(ArticleCategoryService $service, ArticleService $article)
	{
		$this->baseService = $service;
		$this->articleService = $article;
		parent::_init();
	}

	public function index()
	{	
		Html::addCss('article');
		$cateId = iget('cate_id', 0);
		$page = iget('page', 1);
		$size = iget('size', 10);

		//是父分类且没有子分类, 拿第一篇文章
		if ($this->baseService->isParent($cateId)) {
			$cateList = $this->baseService->getList();
			$cateList = array_column($cateList, null, 'cate_id');
			if (empty($cateList[$cateId]['son'])) {
				$list = $this->articleService->getListFormat(['cate_id' => $cateId, 'lan_id' => \frame\Session::get('site_language_id')]);
				$info = $this->articleService->getInfoCache($list[0]['art_id'] ?? 0, $list[0]['lan_id'] ?? 0);
				//相关文章
				$recommend = $this->articleService->getList(['lan_id' => \frame\Session::get('site_language_id'), 'art_id'=>['<>', $info['art_id']]], 1, 12, [['is_hot', 'desc']]);
				
				$this->assign('recommend', $recommend);
			} else {
				$cateId = $cateList[$cateId]['son'][0]['cate_id'];
			}
		}

		if (empty($info)) {
			$where = ['cate_id' => $cateId, 'lan_id' => \frame\Session::get('site_language_id')];
			$total = $this->articleService->getTotal($where); 
			if ($total > 0) {
				$list = $this->articleService->getList($where, $page, $size); 
			}
			if ($total > $size) {
				$pageBar = paginator()->make($size, $total);
			}
		}

		$this->assign('pageBar', $pageBar ?? '');
		$this->assign('list', $list ?? []);
		$this->assign('info', $info ?? []);

		return view();
	}
}