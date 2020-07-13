<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
// use App\Services\ProductService;
use frame\html;

/**
 * 前站入口控制器
 */

class IndexController extends Controller
{
	protected $serivces = null;

	public function __construct()
    {
    	// $this->serivces = $serivces;
    	$this->assign('title', '广州市奥创三维科技有限公司-首页');
    }

	public function index()
	{	
		Html::addCss('index');
		// $this->assign('title', '广州市奥创三维科技有限公司-首页');
		// 
		$this->assign('index_welcome', 'WELCOME TO ZONGHENG INTELLIGENCE 3D PRINTER TECHNOLOGY.CO.,LTD');
		return view();
	}
}