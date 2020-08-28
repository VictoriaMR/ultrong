<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MemberService;
use frame\Html;
use frame\Session;

/**
 *  管理员列表控制器
 */
class AdminMemberController extends Controller
{
	protected $is_super = 0;
	protected $self_id = 0;

	public function __construct(MemberService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'管理员列表'];
		parent::_initialize();
		$this->is_super = Session::get('admin_is_super');
		$this->self_id = Session::get('admin_mem_id');
	}

	public function index()
	{
		Html::addJs('member/index');

		$page = (int) input('page', 1);
		$size = (int) input('size', 20);
		$keyword = input('keyword', '');

		$where = [];
		if (!empty($keyword)) {
			$where['keyword'] = $keyword;
		}

		$total = $this->baseService->getTotal($where);
		if ($total > 0) {
			$list = $this->baseService->getList($where, $page, $size);
		}

		$list = $this->baseService->getPaginationList($total, $list ?? [], $page, $size);

		$pageBar = paginator(false)->make($size, $total);

		$this->assign('self_id', $this->self_id);
		$this->assign('is_super', $this->is_super);
		$this->assign('keyword', $keyword);
		$this->assign('list', $list);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function add()
	{
		if (!$this->is_super)
			return $this->result(10000, false, ['message'=>'无权限操作']);

		$memId = ipost('mem_id', 0);
		$name = ipost('name', '');
		$nickname = ipost('nickname');
		$mobile = ipost('mobile');
		$password = ipost('password');
		$status = (int) ipost('status');
		$isSuper = (int) ipost('is_super');

		if (empty($name) || empty($nickname) || empty($mobile)) {
			return $this->result(10000, false, ['message'=>'参数不正确']);
		}

		if (empty($memId) && empty($password)) {
			return $this->result(10000, false, ['message'=>'初始密码不能为空']);
		}

		$total = $this->baseService->where('name', $name)
								   ->where($memId ? ['mem_id', '<>', $memId] : [])
								   ->count();
		if ($total) {
			return $this->result(10000, false, ['message'=>'名称已被使用']);
		}

		$total = $this->baseService->where('mobile', $mobile)
								   ->where($memId ? ['mem_id', '<>', $memId] : [])
								   ->count();
		if ($total) {
			return $this->result(10000, false, ['message'=>'电话已被使用']);
		}

		$data = [
			'name' => $name,
			'nickname' => $nickname,
			'mobile' => $mobile,
			'status' => $status,
			'is_super' => $isSuper,
			'password' => $password,
		];

		if (empty($memId)) {
			$memId = $this->baseService->create($data);
			if ($memId) $result = true;
		} else {
			$result = $this->baseService->updateById($memId, $data);
		}

		if ($result) 
			return $this->result(200, $memId, ['message' => '保存成功']);
		else
			return $this->result(10000, $memId, ['message' => '保存失败']);
	}

	public function modify()
	{
		$memId = (int) ipost('mem_id', 0);
		$status = ipost('status');
		$isSuper = ipost('is_super');

		$data = [];

		if (!is_null($status))
			$data['status'] = $status;

		if (!is_null($isSuper))
			$data['is_super'] = $isSuper;

		if (empty($memId) || empty($data))
			return $this->result(10000, false, ['参数不正确']);

		$result = $this->baseService->updateDataById($memId, $data);

		if ($result) 
			return $this->result(200, $memId, ['message' => '设置成功']);
		else
			return $this->result(10000, $memId, ['message' => '设置失败']);
	}
}