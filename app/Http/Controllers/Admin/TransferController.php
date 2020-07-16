<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TranslateService;
use frame\Html;

/**
 *  登陆控制器
 */
class TransferController extends Controller
{
	
	function __construct(TranslateService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'翻译列表', 'interface'=>'翻译接口'];
		parent::_initialize();
	}

	public function index()
	{
		$page = (int) iget('page', 1);
		$size = (int) iget('size', 20);
		$type = iget('type', '');
		$filter = iget('filter', 0);
		$keyword = iget('keyword', '');

		$where = [];
		if (!empty($type)) 
			$where[] = ['type', '=', $type];

		if (!empty($filter)) 
			$where[] = ['value', $filter == 1 ? '=' : '<>' , ''];
		
		if (!empty($keyword))
			$where[] = ['name', 'like' , '%'.$keyword.'%'];

		$total = $this->baseService->getListTotal($where);

		if ($total > 0) {
			$list = $this->baseService->getList($where, $page, $size);
		}

		$list = $this->baseService->getPaginationList($total, $list ?? [], $page, $size);

		$pageBar = paginator()->make($size, $total);

		$this->assign('list', $list);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function interface()
	{
		return view();
	}
}