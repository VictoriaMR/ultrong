<?php

class Router
{	
	public static $_route = []; //路由
	public static $_param = []; //参数
	const CONTROLER_TYPE = ['p', 'pl', 'a', 'al'];

	/**
     * @method 解析网址 解析路由 返回控制器执行路径 
     *         可自己定义控制器路径
     * @return array
     */
    public static function analyze_func()
	{
        $pathInfo = trim(str_replace('.html', '', $_SERVER['REQUEST_URI'] ?? ''), '/');

		if (strpos($_SERVER['REQUEST_URI'], '.html') !== false) {
			self::analyzeParam($pathInfo);
			$pathInfo = $temp[0] ?? '';
		} else {
	        $pathInfo = explode('?', $pathInfo)[0] ?? '';

			/* 对Url网址进行拆分 */
			$pathInfoArr = explode( '/', $pathInfo );

			/* 进行网址解析 */
			if (!empty($GLOBALS['route'])) {
				if (!in_array(strtolower($pathInfoArr[0] ?? ''), $GLOBALS['route'])) {
					//压入默认站点到路由数组
					array_unshift($pathInfoArr, $GLOBALS['route'][0]);
				}
			}

			/* 去除路由中间空格 */
			$pathInfoArr = array_map('trim', $pathInfoArr);

	        /* 类名 */
	        $Class 	   = array_shift($pathInfoArr);

			if (count($pathInfoArr) > 1) {
		        /* 方法名 */
		        $Func 	   = array_pop($pathInfoArr);
		        /* 中间路径 */
		        $ClassPath = $pathInfoArr;
			} else {
				/* 方法名 */
		        $ClassPath 	   = array_pop($pathInfoArr);
		        /* 中间路径 */
		        $Func = $pathInfoArr;
			}

	        $funcArr = [
				'Class'     => !empty($Class) ? $Class : 'Home',
				'ClassPath' => !empty($ClassPath) ? $ClassPath : 'Index',
				'Func'      => !empty($Func) ? $Func : 'index',
			];
			self::$_route = self::realFunc($funcArr);
		}
	}

	protected static function analyzeParam($data) {
		if (empty($data)) return false;
		$temp = explode('-', $data);
		$temp = array_reverse($temp);
		$param = [];
		$controler = '';
		foreach ($temp as $value) {
			if (in_array($value, self::CONTROLER_TYPE)) {
				$controler = $value;
				break;
			}
			$param[] = $value;
		}
		$param = array_reverse($param);
		switch (strtolower($controler)) {
			case 'p':
				$ClassPath = 'product';
				$_GET['pro_id'] = $param[0] ?? 0;
				$_GET['lan_id'] = $param[1] ?? 0;
				break;
			case 'a':
				$ClassPath = 'article';
				$_GET['art_id'] = $param[0] ?? 0;
				$_GET['lan_id'] = $param[1] ?? 0;
				break;
			case 'pl':
				$ClassPath = 'productList';
				$_GET['cate_id'] = $param[0] ?? 0;
				$_GET['page'] = $param[1] ?? 1;
				break;
			case 'al':
				$ClassPath = 'articleList';
				$_GET['cate_id'] = $param[0] ?? 0;
				$_GET['page'] = $param[1] ?? 1;
				break;
		}

		$funcArr = [
			'Class'     => 'Home',
			'ClassPath' => !empty($ClassPath) ? $ClassPath : 'Index',
			'Func'      => !empty($Func) ? $Func : 'index',
		];

		self::$_route = self::realFunc($funcArr);
		return true;
	}

	public static function getFunc($name = '')
	{
		if (empty($name)) return self::$_route;
		return self::$_route[$name] ?? '';
	}

	public static function realFunc($funcArr)
	{
		if (!empty($funcArr)) {
			$count = count($funcArr);
			$i = 1;
			foreach ($funcArr as $key => $value) {
				if (empty($value)) continue;
				if ($count == $i) {
					//方法名小写
					$funcArr[$key] = strtolower(substr($value, 0, 1)) . substr($value, 1);
				} else {
					if (is_array($value)) {
						foreach ($value as $k => $v) {
							$value[$k] = strtoupper(substr($v, 0, 1)) . substr($v, 1);
						}
						$funcArr[$key] = implode('\\', $value);
					} else {
						$funcArr[$key] = strtoupper(substr($value, 0, 1)) . substr($value, 1);
					}
					$i ++;
				}
			}
		}
		return $funcArr;
	}

	public static function reload($funcArr = [])
	{
		if (empty($funcArr))
			return false;

		$funcArr = self::realFunc($funcArr);

		switch (count($funcArr)) {
			case 1:
				self::$_route['Func'] = $funcArr[0] ?? 'index';
				break;
			case 2:
				self::$_route['Func'] = $funcArr[1] ?? 'index';
				self::$_route['ClassPath'] = $funcArr[0] ?? 'Index';
				break;
			default:
				self::$_route['Class'] = array_shift($funcArr);
                self::$_route['Func'] = array_pop($funcArr);
                self::$_route['ClassPath'] = implode('\\', $funcArr);
				break;
		}
		return true;
	}

	/**
	 * @method 生成路由
	 * @author LiaoMingRong
	 * @date   2020-08-21
	 * @param  string     $url  
	 * @param  array      $param
	 * @return string
	 */
	public static function bindUrl($url = '', $param = []) 
	{
		$url = trim(trim($url), '/');
		if (empty($url)) return Env('APP_DOMAIN');
		switch (strtolower($url)) {
			//产品列表
			case 'productlist':
				$url = strtolower($url);
				$cid = $param['cate_id'] ?? 0;
				if (!empty($cid)) {
					$url = '';
					$categoryService = \App::make('App\Services\CategoryService');
					$info = $categoryService->getInfoCache($cid);
					$url = self::specialChar($info['name_en'] ?? '');
					$url .= '-pl-'.$param['cate_id'];
				} else {
					$url .= '-pl-';
				}
				if (!empty($param['page']))
					$url .= '-'.$param['page'];
				$url = trim($url, '-');
				$url .= '.html';
				break;
			//产品详情
			case 'product':
				$url = strtolower($url);
				$proId = $param['pro_id'] ?? 0;
				$lanId = $param['lan_id'] ?? 0;
				$url = '';
				if (!empty($proId) && !empty($lanId)) {
					$productService = \App::make('App\Services\ProductService');
					$info = $productService->getInfoCache($proId, $lanId);
					if (!empty($info['cate_id'])) {
						$categoryService = \App::make('App\Services\CategoryService');
						$temp = $categoryService->getInfoCache($info['cate_id']);
						$url .= ($temp['name_en'] ?? '').'-';
					}
					$url .= $info['name_en'] ?? '';
					$url = self::specialChar($url);
					$url .= '-p-'.$proId.'-'.$lanId.'.html';
				}
				break;
			//文章详情
			case 'article':
				$url = strtolower($url);
				$artId = $param['art_id'] ?? 0;
				$lanId = $param['lan_id'] ?? 0;
				$cateId = $param['cate_id'] ?? 0;
				$url = '';
				if (!empty($artId) && !empty($lanId)) {
        			$articleService = \App::make('App/Services/ArticleService');
        			$info = $articleService->getInfoCache($artId, $lanId);
        			// dd($info);
        			if (!empty($info['cate_id'])) {
						$articleCategoryService = \App::make('App/Services/ArticleCategoryService');
						$temp = $articleCategoryService->getCategoryName($info['cate_id']);
						$url .= $temp.'-';
					}
					$url .= $info['name_en'] ?? '';
					$url = self::specialChar($url);
					$url .= '-a-'.$artId.'-'.$lanId.'.html';
				}
				break;
			//文章列表
			case 'articlelist':
				$url = strtolower($url);
				$cateId = $param['cate_id'] ?? 0;
				$url = '';
				if (!empty($cateId)) {
					$articleCategoryService = \App::make('App/Services/ArticleCategoryService');
					$temp = $articleCategoryService->getCategoryName($cateId);
					$url .= $temp.'-';
					$url = self::specialChar($url);
					$url .= '-al-'.$cateId;
				} else {
					$url .= '-al-';
				}
				if (!empty($param['page']))
					$url .= '-'.$param['page'];
				$url = trim($url, '-');
				$url .= '.html';
				break;
			default: 
				if (!empty($param)) {
			        $url .= '?'. http_build_query($param);
			    }
				break;
		}

		return Env('APP_DOMAIN').$url;
	}

	protected static function specialChar($str)
	{
		if (empty($str)) return '';
		$str = trim($str);
		$trans = [
            '&' => '-',
            "'" => '-',
            '"' => '-',
            '>' => '-',
            '<' => '-',
            ' ' => '-',
        ];
		$str = strtr($str, $trans);
		$str = preg_replace('/-{2,}/', '\\1', trim($str, '-'));
		return strtolower($str);
	}
}