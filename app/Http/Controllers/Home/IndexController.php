<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use frame\html;
use frame\Session;

/**
 * 前站入口控制器
 */

class IndexController extends Controller
{
	public function __construct()
	{
		parent::_init();
	}

	public function index()
	{	
		Html::addCss('index');
		Html::addJs('index');
		$bannerService = \App::make('App/Services/BannerService');
		$banner = $bannerService->getInfo(Session::get('site_language_id'), isMobile() ? 1 : 0);

		//展示产品分类
		$cateService = \App::make('App/Services/CategoryService');
		$cateList = $cateService->getList(['status'=>1, 'is_index'=>1]);

		//获取分类下商品
		$productService = \App::make('App/Services/ProductService');

		$where = [
			'is_deleted' => 0, 
			// 'lan_id'=>Session::get('site_language_id'),
		];
		foreach ($cateList as $key => $value) {
			$where['cate_id'] = $value['cate_id'];
			$cateList[$key]['product'] = $productService->getList($where, 1, 20, [['is_hot', 'desc'], ['hit_count', 'desc']]);
			if (empty($cateList[$key]['product'])) unset($cateList[$key]);
		}
		
		$this->assign('cateList', $cateList);
		$this->assign('banner', $banner);

		return view();
	}

	/**
	 * @method 设置站点语言
 	 * @author LiaoMingRong
	 * @date   2020-07-14
	 */
	public function setSiteLanguage() 
	{
		$id = (int) iget('lan_id', '');
		if (empty($id)) 
			return $this->result(10000, false, ['message' => dist('参数不正确')]);

		$languageService = \App::make('App/Services/LanguageService');
		$list = $languageService->getList();
		$list = array_column($list, null, 'lan_id');
		if (empty($list[$id]))
			return $this->result(10000, false, ['message' => dist('数据有误, 语言未配置')]);

		Session::set('site', ['language_name' => $list[$id]['value'] ?? '', 'language_id' => $list[$id]['lan_id'] ?? 0]);

		return $this->result(200, true, ['message' => dist('设置成功')]);
	}

	public function contact()
	{
		$data = [
			'name' => dist('姓名'),
			'tel' => dist('电话'),
			'qq' => dist('QQ'),
			'address' => dist('地址'),
			'content' => dist('需求'),
		];

		$tempData = [];
		foreach ($data as $key => $value) {
			if (empty(ipost($key)))
				$this->result(10000, false, $value.dist('不能为空'));
			$tempData[] = $key.' ('.$value.'): '.ipost($key);
		}

		$message = \App::make('App/Services/MessageService');
		// dd(implode(PHP_EOL, $tempData));
		$result = $message->sendMessage(ipUserId(), 500000001, implode(PHP_EOL, $tempData));
		if ($result)
			return $this->result(200, $result, ['message' => dist('发送成功')]);
		else
			return $this->result(10000, $result, ['message' => dist('发送失败')]);
	}

	public function createContact()
	{
		$message = \App::make('App/Services/MessageService');
		$key = $message->createGroup(ipUserId(), 0, 500000002);
		if ($key)
			return $this->result(200, $key, ['message' => dist('创建成功')]);
		else
			return $this->result(10000, $key, ['message' => dist('创建失败')]);
	}

	public function contactList()
	{
		$groupKey = ipost('group_key');
		$lastId = ipost('last_id', 0);
		if (empty($groupKey)) return $this->result(10000, false, ['message' => dist('参数错误')]);

		$message = \App::make('App/Services/MessageService');
		$list = $message->getListByGroupkey($groupKey, ipUserId(), $lastId);

		return $this->result(200, $list);
	}

	public function sendContact()
	{
		$groupKey = ipost('group_key');
		$content = ipost('content');
		if (empty($groupKey) || empty($content)) return $this->result(10000, false, ['message' => dist('参数错误')]);
		$message = \App::make('App/Services/MessageService');
		$res = $message->sendMessageByKey($groupKey, $content, ipUserId());
		if ($res)
			return $this->result(200, $res, ['message' => dist('发送成功')]);
		else
			return $this->result(10000, $res, ['message' => dist('发送失败')]);
	}
}