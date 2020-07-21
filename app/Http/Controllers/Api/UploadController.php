<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileService;

/**
 *  上传文件控制器
 */
class UploadController extends Controller
{
	public function __construct(FileService $service)
	{
		$this->baseService = $service;
	}

	public function index()
	{
		$site = ipost('site', '');
		$file = ifile('file', []);

		if (empty($site) || empty($file))
			return $this->result(10000, false, ['message'=>'上传文件参数不正确!']);

		$result = $this->baseService->upload($file, $site);

		if (empty($result))
			return $this->result(10000, $result, ['message'=>'上传失败!']);

		return $this->result(200, $result, ['message'=>'上传成功!']);
	}
}