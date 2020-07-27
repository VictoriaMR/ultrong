<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SiteService;
use frame\Html;
/**
 *  站点控制器
 */
class SiteController extends Controller
{
	protected $is_super = 0;
	protected $self_id = 0;

	public function __construct(SiteService $service)
	{
		$this->baseService = $service;
		$this->tabs = ['index'=>'站点信息管理', 'banner' => '首页banner图'];
		parent::_initialize();
	}

	public function index()
	{
		//提交的表单
		if (imethod('post')) {
			$siteId = (int) ipost('site_id');
			if (!empty($siteId)) {
				$data = [
					'name' => ipost('name', ''),
					'site_name' => ipost('site_name', ''),
					'seo' => ipost('seo', ''),
					'description' => ipost('description', ''),
					'title' => ipost('title', ''),
					'address' => ipost('address', ''),
				];

				$result = $this->baseService->updateDataById($siteId, $data);
				if ($result)
					$this->baseService->clearCache();
			}
		} 
		//网站信息
		$siteInfo = $this->baseService->getInfo();

		$name = [
			'name' => '公司名称',
			'site_name' => '公司简称',
			'seo' => 'SEO关键字',
			'description' => 'SEO描述',
			'title' => '网页Title',
			'address' => '公司地址',
		];

		$this->assign('name', $name);
		$this->assign('siteInfo', $siteInfo);

		return view();
	}

	public function banner()
	{
		$type = iget('type', 0);

		Html::addCss('banner');
		Html::addJs('banner/index');

		$bannerService = \App::make('App/Services/BannerService');
		$bannerList = $bannerService->getList(['type'=>$type]);

		//获取开启的语言列表
		$languageService = \App::make('App/Services/LanguageService');
		$list = $languageService->getListCache();

		$this->assign('bannerList', $bannerList);
		$this->assign('list', $list);
		$this->assign('type', $type);

		return view();
	}

	/**
	 * @method 保存banner
	 * @author Victoria
	 * @date   2020-07-24
	 */
	public function saveBanner()
	{
		$lanId = (int) ipost('lan_id', 0);
		$type = (int) ipost('type', 0);
		$image = ipost('image', '');
		$href = ipost('href');
		$background = ipost('background');

		if (empty($lanId) || empty($image))
			return $this->result(10000, false, ['参数错误']);

		$data = [];

		$image = array_unique(explode(',', $image));

		if (!empty($image)) {
			$temp = [];
			foreach ($image as $key => $value) {
				$temp[] = [
					'attach_id' => $value,
					'href' => $href[$key] ?? '',
					'background' => $background[$key] ?? '',
				];
			}
			$data['content'] = json_encode($temp, JSON_UNESCAPED_UNICODE);
		}

		$bannerService = \App::make('App/Services/BannerService');
		$result = $bannerService->updateData($lanId, $type, $data);

		$attachmentService = \App::make('App/Services/AttachmentService');
		$result = $attachmentService->updateData($lanId, $attachmentService::constant('TYPE_INDEX_BANNER'), $image);

		if ($result)
			return $this->result(200, $result, ['保存成功']);
		else
			return $this->result(10000, $result, ['保存失败']);
	}
}