<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MemberService;
use frame\Html;

/**
 *  登陆控制器
 */
class LoginController extends Controller
{
	
	function __construct(MemberService $service)
	{
		$this->baseService = $service;
	}

	public function login() 
	{
		$phone = ipost('phone', '');
		$code = ipost('code', '');
		$password = ipost('password', '');

		if (empty($phone) || (empty($code || $password))) {
			return $this->result(10000, [], ['message' => '输入错误!']);
		}

		$result = $this->baseService->login($phone, $password, false, true);

		if ($result) {
			$data[] = [
	            'user_id' => (int) \frame\Session::get('admin_mem_id'),
	            'path' => implode('/', $info),
	            'param' => json_encode(input(), JSON_UNESCAPED_UNICODE),
	            'ip' => getIp(),
	            'create_at' => time(),
	        ];

	        $logService = \App::make('App\Services\LogService');
	        $logService->handleLog($data);
			return $this->result(200, ['url' => url('admin')], ['message' => '登录成功!']);
		} else {
			return $this->result(10000, $result, ['message' => '账号不匹配!']);
		}

	}
}