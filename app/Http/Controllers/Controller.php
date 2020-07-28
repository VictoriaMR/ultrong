<?php

namespace App\Http\Controllers;

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
     * @method 变量复制
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
        
        //站点信息
        $siteService = \App::make('App/Services/SiteService');
        $siteInfo = $siteService->getInfo();

        $languageService = \App::make('App/Services/LanguageService');
        $list = $languageService->getListCache();
        $list = array_column($list, null, 'value');

        //设置默认语言
        $site_language = \frame\Session::get('site_language_name');
        if (empty($site_language)) {
            $defaultLanguage = array_column($list, null,'is_default')[1] ?? [];
            \frame\Session::set('site', ['language_name' => $defaultLanguage['value'] ?? '', 'language_id' => $defaultLanguage['lan_id'] ?? 0]);
        }
        
        $this->assign('site_language', $site_language);
        $this->assign('language_list', $list);
        $this->assign($siteInfo);
    }
}
