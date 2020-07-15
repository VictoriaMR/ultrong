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
        $info = \Router::getFunc();

        $controller = strtolower($info['ClassPath']);
        $func = strtolower($info['Func']);

        $this->assign('controller', $controller);
        $this->assign('func', $func);

        $this->assign('tabs', $this->tabs);

    }
}
