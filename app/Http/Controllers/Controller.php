<?php

namespace App\Http\Controllers;

use MaxMind\Db\Reader;

class Controller 
{
    protected $tabs = [];

	/**
     * @method api 接口返回数据
     * @author LiaoMingRong
     * @date   2020-07-15
     */
    protected function result($code, $data=[], $options=[])
    {
       $data = [
            'code' => $code,
            'data' => $data
        ];

        if (!empty($options)) {
            if (!is_array($options)) {
                $options = ['message' => $options];
            } else if (!empty($options[0])) {
                $options['message'] = $options[0];
                unset($options[0]);
            }
        }

        $data = array_merge($data, $options);
        
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * @method 变量赋值
     * @author LiaoMingRong
     * @date   2020-07-15
     */
    protected function assign($name = '', $value = '')
    {
        return \View::getInstance()->assign($name, $value);
    }

    /**
     * @method 初始化方法
     * @author LiaoMingRong
     * @date   2020-07-15
     */
    protected function _initialize()
    {
        if (IS_AJAX) return false;
        $info = \Router::getFunc();
        $controllerService = \App::make('App\Services\Admin\ControllerService');
        $data = $controllerService->getInfoByNameEn(strtolower($info['ClassPath']));
        if (!empty($data['name'])) 
            $navArr[] = $data['name'];

        $data = $controllerService->loadData($data['parent_id'] ?? 0);
        if (!empty($data['name'])) {
            $navArr[] = $data['name'];
        }

        $controller = strtolower($info['ClassPath']);
        $func = strtolower($info['Func']);

        if (!empty($navArr))
            krsort($navArr);

        \frame\Html::addCss('common');
        \frame\Html::addJs('common');

        $this->assign('navArr', $navArr);
        $this->assign('controller', $controller);
        $this->assign('func', $func);
        $this->assign('tabs', $this->tabs);
    }

    protected function _init()
    {
        \frame\Html::addCss('common');
        \frame\Html::addJs('common');

        $info = \Router::getFunc();
        $controller = strtolower($info['ClassPath']);
        if (!empty(iget('cate_id')))
            $controller .= '_'.iget('cate_id');
        
        //站点信息
        $siteService = \App::make('App/Services/SiteService');
        $siteInfo = $siteService->getInfo();

        if (!empty($siteInfo['domain'])) {
            $GLOBALS['ENV']['APP_DOMAIN'] = trim($siteInfo['domain'], '/').'/';
        }

        $languageService = \App::make('App/Services/LanguageService');
        $list = $languageService->getListCache();
        $list = array_column($list, null, 'value');

        //设置默认语言
        $site_language = \frame\Session::get('site_language_name');
        if (empty($site_language)) {

            $defaultLanguage = array_column($list, null,'is_default')[1] ?? [];
            $code = $defaultLanguage['value'];

            //获取ip地址区域
            $ip = getIp();
            $file = ROOT_PATH.'public/other/GeoLite2-Country.mmdb';
            if (is_file($file)) {
                $reader = new Reader($file);
                $record = $reader->get($ip);
                if (!empty($record)) {
                    if (!empty($record['country']['iso_code']) && $record['country']['iso_code'] != 'CN')
                        $code = 'en';
                }
            }

            \frame\Session::set('site', ['language_name' => $list[$code]['value'] ?? '', 'language_id' => $list[$code]['lan_id'] ?? 0]);
        }

        //头部导航列表
        $articleCategoryService = \App::make('App/Services/ArticleCategoryService');
        $articleService = \App::make('App/Services/ArticleService');
        $cateService = \App::make('App/Services/CategoryService');
        
        $articleList = $articleCategoryService->getList();
        // dd($articleList);
        $tempData = [];
        if (!empty($articleList)) {
            foreach ($articleList as $key => $value) {
                if (empty($value['son'])) {
                    $value['son'] = $articleService->getListFormat(['cate_id' => $value['cate_id'], 'lan_id' => \frame\Session::get('site_language_id')]);
                } else {
                    foreach ($value['son'] as $k => $v) {
                        $value['son'][$k]['name'] = dist($v['name']);
                    }
                }
                foreach ($value['son'] as $k => $v) {
                    $value['son'][$k]['url'] = url('article', ['cate_id'=>$value['cate_id'], 'list_id'=>$v['cate_id']]);
                }

                $tempData[] = [
                    'name' => dist($value['name']),
                    'name_en' => 'article_'.$value['cate_id'],
                    'url' => url('article', ['cate_id'=>$value['cate_id']]),
                    'son' => $value['son'],
                ];
                if ($key == 0) {
                    //获取产品分类
                    $son = $cateService->getList(['status'=>1]);
                    foreach ($son as $k => $v) {
                        $son[$k]['url'] = url('productlist', ['cate_id' => $v['cate_id']]);
                    }
                    $tempData[] = [
                        'name' => dist('产品中心'),
                        'name_en' => 'productlist',
                        'url' => url('productList'),
                        'son' => $son,
                    ];
                }
            }
        } else {
            $son = $cateService->getList(['status'=>1]);
            foreach ($son as $k => $v) {
                $son[$k]['url'] = url('productlist', ['cate_id' => $v['cate_id']]);
            }
            $tempData[] = [
                'name' => dist('产品中心'),
                'name_en' => 'productlist',
                'url' => url('productList'),
                'son' => $son,
            ];
        }
        
        $this->assign('controller', $controller);
        $this->assign('site_language', $site_language);
        $this->assign('language_list', $list);
        $this->assign('nav_list', $tempData);
        $this->assign('site', $siteInfo);
        $this->assign('_title', dist($siteInfo['title']));
        $this->assign('_name', dist($siteInfo['name']));
        $this->assign('_site_name', dist($siteInfo['site_name']));
        $this->assign('_seo', dist($siteInfo['seo']));
        $this->assign('_description', dist($siteInfo['description']));
    }
}
