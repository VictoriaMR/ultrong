<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MemberService;
use frame\Html;
use frame\Session;

/**
 *  个人中心信息栏
 */
class ProfileController extends Controller
{
	public function __construct(MemberService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'个人信息', 'modifyPassword' => '修改密码'];
		parent::_initialize();
		Html::addJs('profile/index');
	}

	public function index()
	{	
		$userId = Session::get('admin_mem_id');
		$info = $this->baseService->loadData($userId);

		$info = array_merge($info, Session::get('admin'));

		$this->assign('info', $info);

		return view();
	}

	/**
	 * @method 更新头像
	 * @author LiaoMingRong
	 * @date   2020-07-21
	 */
	public function updateAvatar()
	{
		$attchid = (int)ipost('attchid', 0);
		if (empty($attchid))
			return $this->result(10000, false, ['message' => '文件ID缺失']);

		$attachmentService = \App::make('App\Services\AttachmentService');
		$info = $attachmentService->getAttachmentById($attchid);

		if (empty($info))
			return $this->result(10000, false, ['message' => '文件不存在']);

		$userId = Session::get('admin_mem_id');

		$result = $attachmentService->updateData($userId, $attachmentService::constant('TYPE_ADMIN_LOGIN_BACKGROUD'), $attchid);

		if ($result) {
			Session::set('admin_avatar', $info['url']);
			$this->baseService->updateDataById($userId, ['avatar' => $info['path'].'/'.$info['name'].'.'.$info['type']]);
			return $this->result(200, true, ['message' => '更新成功']);
		} else {
			return $this->result(10000, false, ['message' => '更新失败']);
		}
	}
}