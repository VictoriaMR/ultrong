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
		Html::addJs('transfer/index');

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
		Html::addJs('transfer/interface');

		$page = (int) iget('page', 1);
		$size = (int) iget('size', 20);

		$where = ['is_deleted'=>0];

		$total = $this->baseService->getInterfaceListTotal($where);

		if ($total > 0) {
			$list = $this->baseService->getInterfaceList($where, $page, $size);
		}

		$list = $this->baseService->getPaginationList($total, $list ?? [], $page, $size);

		$pageBar = paginator()->make($size, $total);

		$this->assign('list', $list);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function saveConfig()
	{
		$name = ipost('name', '');
		$appid = ipost('app_id', '');
		$appkey = ipost('app_key', '');
		$status = ipost('status', null);
		$tcId = (int) ipost('tc_id', 0);

		if (empty($name))
			return $this->result(10000, false, ['message' => '请将名称填写完整']);

		if (empty($appid))
			return $this->result(10000, false, ['message' => '请将APPID填写完整']);

		if (empty($appkey))
			return $this->result(10000, false, ['message' => '请将APPKEY填写完整']);

		$data = [
			'name' => $name,
			'app_id' => $appid,
			'app_key' => $appkey,
		];

		if ($status !== null) $data['status'] = (int) $status;

		if (!empty($tcId)) {
			$result = $this->baseService->updateConfigById($tcId, $data);
		} else {
			$result = $this->baseService->addConfig($data);
		}

		if ($result)
			return $this->result(200, $result, ['message' => '保存成功']);
		else
			return $this->result(10000, $result, ['message' => '保存失败']);
	}

	public function modifyConfig()
	{
		$tcId = (int) ipost('tc_id', 0);
		$status = ipost('status', null);
		$isDeleted = ipost('is_deleted', null);

		$data = [];
		if ($status != null) {
			$data['status'] = (int) $status;
		}
		if ($isDeleted != null) {
			$data['is_deleted'] = (int) $isDeleted;
		}

		if (empty($tcId) || empty($data))
			return $this->result(10000, false, ['message' => '参数不正确']);

		$result = $this->baseService->modifyConfig($tcId, $data);

		if ($result)
			return $this->result(200, $result, ['message' => '保存成功']);
		else
			return $this->result(10000, $result, ['message' => '保存失败']);
	}

	public function checkConfig()
	{
		$tcId = (int) ipost('tc_id', 0);

		if (empty($tcId))
			return $this->result(10000, false, ['message' => '参数不正确']);

		$result = $this->baseService->checkConfig($tcId, $data);

		if ($result)
			return $this->result(200, $result, ['message' => '检查通过']);
		else
			return $this->result(10000, $result, ['message' => '检查不通过']);
	}
}