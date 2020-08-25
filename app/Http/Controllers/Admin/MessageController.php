<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MessageService;
use frame\Session;
use frame\Html;

/**
 *  登陆控制器
 */
class MessageController extends Controller
{
	function __construct(MessageService $service)
	{
		$this->tabs = ['index'=>'消息列表', 'group' => '咨询分组', 'groupInfo' => '详情'];
		parent::_initialize();
		$this->baseService = $service;
	}

	public function index()
	{
		Html::addJs('message/index');
		$page = iget('page', 1);
		$size = iget('size', 20);
		$where = [];
		$userId = Session::get('admin_mem_id');
		if (!Session::get('admin_is_super')) {
			$groupkeyArr = $this->baseService->getUserGroupkey($userId);
			$where['group_key'] = ['in', $groupkeyArr];
		}
		$list = $this->baseService->getMessageList($where, $page, $size);
		foreach ($list['list'] as $key => $value) {
			$value['can_replay'] = $this->baseService->isExistMember($value['group_key'], $userId) ? 1 : 0;
			$list['list'][$key] = $value;
		}

		$pageBar = paginator()->make($size, $list['total']);

		$this->assign('list', $list['list']);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function group()
	{
		Html::addJs('message/index');
		$page = iget('page', 1);
		$size = iget('size', 20);
		$where = [];
		$userId = Session::get('admin_mem_id');
		if (!Session::get('admin_is_super')) {
			$groupkeyArr = $this->baseService->getUserGroupkey($userId);
			$where['group_key'] = ['in', $groupkeyArr];
		}
		$list = $this->baseService->getGroupList($where, $page, $size);
		foreach ($list['list'] as $key => $value) {
			$value['can_change'] = Session::get('admin_is_super') ? 1 : 0;
			$temp = array_column($value['member_list'], 'user_id');
			rsort($temp);
			$value['follow'] = $temp[0] ?? 0;
			$list['list'][$key] = $value;
		}

		$pageBar = paginator()->make($size, $list['total']);

		$memberService = \App::make('App\Services\Admin\MemberService');
		$member_list = $memberService->getList([], 1, 9999);
		$this->assign('list', $list['list']);
		$this->assign('member_list', $member_list);
		$this->assign('pageBar', $pageBar);

		return view();
	}

	public function groupInfo()
	{
		Html::addJs('message/index');
		$groupkey = iget('group_key', '');
		$groupMember = $this->baseService->getMemberListByGroupkey($groupkey);

		$list = $this->baseService->getListByGroupkey($groupkey, Session::get('admin_mem_id'));

		$can_replay = $this->baseService->isExistMember($value['group_key'], Session::get('admin_mem_id')) ? 1 : 0;

		$this->assign('list', $list);
		$this->assign('member', $groupMember);
		$this->assign('can_replay', $can_replay);
		
		return view();
	}

	public function sendMessage()
	{
		$groupkey = ipost('group_key', '');
		$content = ipost('replay', '');
		if (empty($groupkey))
			return $this->result(10000, false, '参数错误');
		
		$res = $this->baseService->sendMessageByKey($groupkey, $content, Session::get('admin_mem_id'));
		if ($res)
			return $this->result(200, $res, ['message' => dist('发送成功')]);
		else
			return $this->result(10000, $res, ['message' => dist('发送失败')]);
	}

	public function changge()
	{
		$groupKey = ipost('group_key');
		$from = ipost('follow');
		$to = ipost('to');
		if (empty($groupKey) || empty($from) || empty($to))
			return $this->result(10000, $res, ['message' => dist('参数错误')]);

		$total = $this->baseService->changeUser($groupKey, $from, $to);
		return $this->result(200, $total);
	}

	public function getUnread()
	{
		$total = $this->baseService->getUnreadByUserId(Session::get('admin_mem_id'));
		return $this->result(200, $total);
	}
}