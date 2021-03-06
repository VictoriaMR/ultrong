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

        $controller = $info['ClassPath'];
        $func = $info['Func'];

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
        if (IS_AJAX) return false;
        \frame\Html::addCss('common');
        \frame\Html::addJs('common');

        $info = \Router::getFunc();
        $controller = strtolower($info['ClassPath']);
        
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
        
        $articleList = $articleCategoryService->getListFormat();
        $tempData = [];
        if (!empty($articleList)) {
            $cateParentArr = [];
            foreach ($articleList as $key => $value) {
                //获取挂靠在分类下的文章
                if (empty($value['son'])) {
                    $value['son'] = $articleService->getListFormat(['cate_id' => $value['cate_id'], 'lan_id' => \frame\Session::get('site_language_id')]);
                    $cate_id = 0;
                    if (!empty($value['son'])) {
                        foreach ($value['son'] as $sk => $sv) {
                            $value['son'][$sk]['url'] = url('article', ['art_id'=>$sv['art_id'], 'lan_id'=>$sv['lan_id']]);
                            if ($sv['art_id'] == iget('art_id') && $sv['lan_id'] == iget('lan_id')) {
                                $value['son'][$sk]['selected'] = 1;
                                $cate_id = $sv['cate_id'];
                            } else {
                                $value['son'][$sk]['selected'] = 0;
                            }
                        }
                        if (empty(iget('art_id')) && empty(iget('lan_id'))) {
                            $value['son'][0]['selected'] = 1;
                        }
                        $value['url'] = url('articleList', ['cate_id'=>$value['cate_id']]);
                    }
                    //取对应子分类
                    if ($controller == 'articlelist') {
                        $value['selected'] = strpos($controller, 'product') === false && iget('cate_id') == $value['cate_id'] ? 1 : 0;
                    } else {
                        $value['selected'] = strpos($controller, 'product') === false && $cate_id == $value['cate_id'] ? 1 : 0;
                    }
                } else {
                    foreach ($value['son'] as $sk => $sv) {
                        $value['son'][$sk]['name'] = dist($sv['name']);
                        $value['son'][$sk]['url'] = url('articleList', ['cate_id'=>$sv['cate_id']]);
                        $value['son'][$sk]['selected'] = iget('cate_id') == $sv['cate_id'] ? 1 : 0;
                    }
                    $value['url'] = url('articleList', ['cate_id'=>$value['cate_id']]);
                    if ($controller == 'articlelist') {
                        $value['selected'] = strpos($controller, 'product') === false && (iget('cate_id') == $value['cate_id'] || in_array(iget('cate_id'), array_column($value['son'], 'cate_id'))) ? 1 : 0;
                        if (!in_array(iget('cate_id'), array_column($value['son'], 'cate_id')) && !isMobile()) {
                            $value['son'][0]['selected'] = 1;
                        }
                    } else {

                    }
                }
                $tempData[] = [
                    'selected' => $value['selected'] ?? 0,
                    'name' => dist($value['name']),
                    'url' => $value['url'] ?? 'javascript:;',
                    'son' => $value['son'],
                    'id' => $value['cate_id'],
                ];
                if ($key == 0) {
                    //获取产品分类
                    $son = $cateService->getList(['status'=>1]);
                    foreach ($son as $k => $v) {
                        $son[$k]['name'] = dist($v['name']);
                        $son[$k]['url'] = url('productList', ['cate_id' => $v['cate_id']]);
                    }
                    $tempData[] = [
                        'name' => dist('产品中心'),
                        'selected' => strpos($controller, 'product') !== false ? 1 : 0,
                        'url' => url('productList'),
                        'son' => $son,
                        'id' => $value['cate_id'],
                    ];
                }
            }
        } else {
            $son = $cateService->getList(['status'=>1]);
            foreach ($son as $k => $v) {
                $son[$k]['name'] = dist($v['name']);
                $son[$k]['url'] = url('productList', ['cate_id' => $v['cate_id']]);
            }
            $tempData[] = [
                'name' => dist('产品中心'),
                'selected' => strpos($controller, 'product') !== false ? 1 : 0,
                'url' => url('productList'),
                'controller' => 'product',
                'son' => $son,
                'id' => 0,
            ];
        }
        $selectedNav = [];
        foreach ($tempData as $key => $value) {
            if ($value['selected']) {
                $selectedNav = $value;
                break;
            }
        }
        // dd($tempData);
        // dd($selectedNav);
        $this->assign('controller', $controller);
        $this->assign('selectedNav', $selectedNav);
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
