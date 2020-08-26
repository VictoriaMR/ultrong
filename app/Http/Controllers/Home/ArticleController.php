<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use frame\Html;

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
		Html::addCss('article');
		$artId = iget('art_id', 0);
		$lanId = iget('lan_id', 0);

		$info = $this->baseService->getInfoCache($artId, $lanId);

		if (!empty($info)) {
			//分类名称
			$cateId = $info['cate_id'];
			$cateService = \App::make('App/Services/ArticleCategoryService');
			$cateList = $cateService->getList();
			$cateList = array_column($cateList, null, 'cate_id');
			$this->baseService->hitCountAdd($artId, $lanId);
			//挂靠在首级分类
			$navArr = [];
			if (!empty($cateList[$cateId])) {
				$navArr = $this->baseService->getListFormat(['cate_id' => $cateId, 'lan_id' => \frame\Session::get('site_language_id')]);
				foreach ($navArr as $key => $value) {
					$value['url'] = url('article', ['art_id'=>$value['art_id'], 'lan_id'=>$value['lan_id']]);
					if ($value['art_id'] == $artId && $value['lan_id']) {
						$value['selected'] = 1;
					}
					$navArr[$key] = $value;
				}
			} else {
				foreach ($cateList as $key => $value) {
					if (empty($value['son'])) continue;
					foreach ($value['son'] as $k => $v) {
						if ($v['cate_id'] == $cateId) {
							$navArr = $cateList[$key]['son'];
							break;
						}
					}
					if (!empty($navArr)) break;
				}
				foreach ($navArr as $key => $value) {
					$value['url'] = url('articleList', ['cate_id'=>$value['cate_id']]);
					if ($value['cate_id'] == $cateId) {
						$value['selected'] = 1;
					}
					$navArr[$key] = $value;
				}
			}

			$this->assign('_title2', $info['name']);
			$this->assign('_description', $info['desc']);
		}

		//相关文章
		$recommend = $this->baseService->getList(['lan_id' => \frame\Session::get('site_language_id'), 'art_id'=>['<>', $artId]], 1, 12, [['is_hot', 'desc']]);
		
		$this->assign('recommend', $recommend);
		$this->assign('info', $info);
		$this->assign('navArr', $navArr);

		return view();
	}
}