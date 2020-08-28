<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\ProductDataService;
use frame\Html;

/**
 * 
 */
class ProductController extends Controller
{
	
	function __construct(ProductService $service, ProductDataService $dataService)
	{
		$this->baseService = $service;
		$this->dataService = $dataService;
		$this->tabs = ['index'=>'SPU列表', 'info' => 'SPU详情'];
		parent::_initialize();
		Html::addCss('product');
	}

	public function index()
	{
		Html::addJs('product/index');

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

		$pageBar = paginator(false)->make($size, $total);

		$this->assign('cateList', $cateList);
		$this->assign('lanList', $lanList);
		$this->assign('total', $total);
		$this->assign('list', $list ?? []);
		$this->assign('size', $size);
		$this->assign('spu_id', $spuId);
		$this->assign('keyword', $keyword);
		$this->assign('cate_id', $cateId);
		$this->assign('lan_id', $lanId);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function info()
	{
		Html::addJs('product/info');
		Html::addJs('ueditor/ueditor.config', true);
		Html::addJs('ueditor/ueditor.all', true);
		Html::addJs('ueditor/lang/zh-cn/zh-cn', true);

		$proId = (int) iget('pro_id', 0);
		$lanId = (int) iget('lan_id', 0);

		//分类列表
		$categoryService = \App::make('App/Services/CategoryService');
		$cateList = $categoryService->getList();
		//语言列表
		$languageService = \App::make('App/Services/LanguageService');
		$lanList = $languageService->getList();

		$info = $this->baseService->getInfo($proId, $lanId);

		$this->assign('cateList', $cateList);
		$this->assign('lanList', $lanList);
		$this->assign('info', $info);
		// dd($info);
		return view();
	}

	public function save()
	{
		$proId = (int) ipost('pro_id', 0);
		$lanId = (int) ipost('lan_id', 0);
		$cateId = (int) ipost('cate_id', 0);
		$status = (int) ipost('status', 0);
		$isHot = (int) ipost('is_hot', 0);
		$name = ipost('name');
		$image = ipost('image');
		$no = ipost('no', '');
		$price = (int)ipost('price', 0);
		$desc = ipost('desc');
		$content = ipost('content');

		if (empty($lanId))
			return $this->result(10000, false, ['未选择语言']);

		$data = ['status' => $status, 'is_hot' => $isHot];

		if (!empty($name))
			$data['name'] = $name;

		$data['no'] = $no;
		$data['sale_price'] = $price;

		if (!empty($cateId))
			$data['cate_id'] = $cateId;

		if (!empty($image))
			$data['image'] = $image;

		if (!empty($desc))
			$data['desc'] = $desc;

		if (empty($data))
			return $this->result(10000, false, ['参数不正确']);

		if (empty($proId)) {
			$data['lan_id'] = $lanId;
			$data['create_at'] = time();
			$proId = $this->baseService->insertGetId($data);
			if ($proId)
				$result = true;
		} else {
			$result = $this->baseService->updateData($proId, $lanId, $data);
		}

		if ($result && !empty($content)) {
			$result = $this->dataService->updateProductData($proId, $lanId, ['content' => $content]);
		}

		if (!empty($image)) {
			$attchService = \App::make('App/Services/AttachmentService');
			$attchService->addNotExist($proId, $attchService::constant('TYPE_PRODUCT'), $image);
		}

		if ($result) {
			$this->baseService->clearCache($proId, $lanId);
			return $this->result(200, ['url' => adminUrl('product/info', ['pro_id' => $proId, 'lan_id' => $lanId])], ['保存成功']);
		} else {
			return $this->result(10000, $result, ['保存失败']);
		}
	}

	public function delete()
	{
		$proId = (int) ipost('pro_id', 0);
		$lanId = (int) ipost('lan_id', 0);

		if (empty($proId) || empty($lanId))
			return $this->result(10000, false, ['参数不正确']);

		$result = $this->baseService->delete($proId, $lanId);

		if ($result) {
			return $this->result(200, $result, ['删除成功']);
		} else {
			return $this->result(10000, $result, ['删除失败']);
		}
	}
}