<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\ArticleDataService;
use frame\Html;

/**
 * 
 */
class ArticleController extends Controller
{
	public function __construct(ArticleService $service, ArticleDataService $dataService)
	{
		$this->baseService = $service;
		$this->dataService = $dataService;
		$this->tabs = ['index'=>'文章列表', 'info' => '文章详情'];
		parent::_initialize();
		Html::addCss('article');
	}

	public function index()
	{
		Html::addJs('article/list');
		$page = iget('page', 1);
		$size = iget('size', 30);
		$artId = iget('art_id', '');
		$keyword = iget('keyword', '');
		$cateId = iget('cate_id', '');
		$lanId = iget('lan_id', '');

		$where = [];

		if (!empty($artId))
			$where['art_id'] = (int) $artId;
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
		$categoryService = \App::make('App/Services/ArticleCategoryService');
		$cateList = $categoryService->getList();
		//语言列表
		$languageService = \App::make('App/Services/LanguageService');
		$lanList = $languageService->getList();

		$pageBar = paginator(false)->make($size, $total);

		$this->assign('cateList', $cateList);
		$this->assign('lanList', $lanList);
		$this->assign('total', $total);
		$this->assign('list', $list ?? []);
		$this->assign('size', $size);
		$this->assign('art_id', $artId);
		$this->assign('keyword', $keyword);
		$this->assign('cate_id', $cateId);
		$this->assign('lan_id', $lanId);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function info()
	{
		Html::addJs('article/info');
		Html::addJs('ueditor/ueditor.config', true);
		Html::addJs('ueditor/ueditor.all', true);
		Html::addJs('ueditor/lang/zh-cn/zh-cn', true);

		$artId = (int) iget('art_id', 0);
		$lanId = (int) iget('lan_id', 0);

		//分类列表
		$categoryService = \App::make('App/Services/ArticleCategoryService');
		$cateList = $categoryService->getList();
		//语言列表
		$languageService = \App::make('App/Services/LanguageService');
		$lanList = $languageService->getList();

		$info = $this->baseService->getInfo($artId, $lanId);

		$this->assign('cateList', $cateList);
		$this->assign('lanList', $lanList);
		$this->assign('info', $info);

		return view();
	}

	public function save()
	{
		$artId = (int) ipost('art_id', 0);
		$lanId = (int) ipost('lan_id', 0);
		$cateId = (int) ipost('cate_id', 0);
		$status = (int) ipost('status', 0);
		$isHot = (int) ipost('is_hot', 0);
		$name = ipost('name');
		$name_en = ipost('name_en');
		$image = ipost('image');
		$no = ipost('no');
		$desc = ipost('desc');
		$content = ipost('content');
		$fujian = ipost('fujian');
		$link = ipost('link');

		if (empty($lanId))
			return $this->result(10000, false, ['未选择语言']);

		$data = ['status' => $status, 'is_hot' => $isHot, 'fujian' => $fujian, 'link'=>$link];

		if (!empty($name))
			$data['name'] = $name;

		if (!empty($name_en))
			$data['name_en'] = $name_en;

		if (!empty($no))
			$data['no'] = $no;

		if (!empty($cateId))
			$data['cate_id'] = $cateId;

		if (!empty($image))
			$data['image'] = $image;

		if (!empty($desc))
			$data['desc'] = $desc;

		if (empty($data))
			return $this->result(10000, false, ['参数不正确']);

		if (empty($artId)) {
			$data['lan_id'] = $lanId;
			$data['create_at'] = time();
			$artId = $this->baseService->insertGetId($data);
			if ($artId)
				$result = true;
		} else {
			$result = $this->baseService->updateData($artId, $lanId, $data);
		}

		if ($result && !empty($content)) {
			$result = $this->dataService->updateArticleData($artId, $lanId, ['content' => $content]);
		}

		if (!empty($image)) {
			$attchService = \App::make('App/Services/AttachmentService');
			$attchService->addNotExist($artId, $attchService::constant('TYPE_ARTICLE'), $image);
		}

		if ($result) {
			$this->baseService->clearCache($artId, $lanId);
			return $this->result(200, ['url' => adminUrl('article/info', ['art_id' => $artId, 'lan_id' => $lanId])], ['保存成功']);
		} else {
			return $this->result(10000, $result, ['保存失败']);
		}
	}

	public function modify()
	{
		$artId = (int) ipost('art_id', 0);
		$status = (int) ipost('status', 0);
		if (empty($artId)) {
			$this->result(10000, false, ['参数不正确']);
		}
		$result = $this->baseService->updateDataById($artId, ['status'=>$status]);
		if ($result) {
			$this->result(200, $result, ['修改成功']);
		} else {
			$this->result(10000, $result, ['修改失败']);
		}
	}

	public function delete()
	{
		$artId = (int) ipost('art_id', 0);
		$lanId = (int) ipost('lan_id', 0);
		if (empty($artId) || empty($lanId)) {
			$this->result(10000, false, ['参数不正确']);
		}
		$result = $this->baseService->deleteArticle($artId, $lanId);
		if ($result) {
			$this->result(200, $result, ['删除成功']);
		} else {
			$this->result(10000, $result, ['删除失败']);
		}
	}
}