<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LogService;
use frame\Html;

/**
 * 
 */
class ShowController extends Controller
{
	public function __construct(LogService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'概览', 'logList'=>'访客记录'];
		parent::_initialize();
		Html::addCss('show');
	}

	public function index() 
	{
		//访客总数
		$total = $this->baseService->getTotal();
		//本月访客人数
		$monthTotal = $this->baseService->getTotal(['create_at', '>', strtotime(date("Y-m-d H:i:s", mktime(0, 0, 0, date('m', time()), 1, date('Y', time()))))]);
		//今日访客人数
		$dateTotal = $this->baseService->getTotal(['create_at', '>', strtotime(date('Y-m-d', time()))]);

		//访客人数按月统计
		$monthList = $this->baseService->monthList();
		
		$this->assign('total', $total);
		$this->assign('monthTotal', $monthTotal);
		$this->assign('monthList', $monthList);
		$this->assign('dateTotal', $dateTotal);

		return view();
	}

	public function logList()
	{
		$page = iget('page', 1);
		$size = iget('size', 40);
		$date = iget('date');

		$total = $this->baseService->getListTotal($where);
		if ($total > 0) {
			$list = $this->baseService->getList($where, $page, $size);
		}

		$pageBar = paginator()->make($size, $total);
		$this->assign('list', $list ?? []);
		$this->assign('pageBar', $pageBar);

		return view();
	}
}