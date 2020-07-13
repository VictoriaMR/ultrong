<?php

/*
 * 全局函数
 */

//是否是手机
function isMobile()
{
	if (isset($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")) {
        return true;
    } 
    if (isset($_SERVER['HTTP_ACCEPT']) && strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML")) {
        return true;
    } 
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
        return true;
    } 
    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    }

    return false;
}

function dd($data = '') 
{
    print_r($data);
    exit();
}

//数据库函数
function DB($db = null)
{
	return \frame\DB::getInstance($db);
}

/*
 * 视图助手函数 display
 */
function view($template = '')
{
	return View::getInstance()->display($template);
}

/*
 * 视图助手函数 fetch
 */
function fetch($template = '')
{
	return View::getInstance()->fetch($template);
}

/*
 * 视图助手函数 assign
 */
function assign($name, $value = null)
{
	return View::getInstance()->assign($name, $value);
}

/*
 * 跳转助手函数 home.index.login
 */
function go($func = '')
{
	$func = explode('.', $func);

	Router::reload($func);

	App::instance()->send();
}

function load($func = '')
{
    go($func);
}

/**
 * 是否运行在命令行下
 * @return bool
 */
function runningInConsole()
{
    return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
}

function ipost($name = '', $default = '') 
{
    if (empty($name)) return $_POST;
    
    if (isset($_POST[$name]))
        return  $_POST[$name];

    return $default;
}

function iget($name = '', $default = '') 
{
    if (empty($name)) return $_GET;
    
    if (isset($_GET[$name]))
        return  $_GET[$name];

    return $default;
}

function input()
{
    return array_merge($_GET, $_POST);
}

function url($url = '') 
{
    return Env('APP_DOMAIN').$url;
}

function media($url = '', $type='') 
{
    switch ($type) {
        case 'product':
            if (empty($url)) {
                $url = 'image/img/no_img.jpg';
                $site = Env('APP_DOMAIN');
            }
            break;
        default:
            $url = 'image/img/no_img.jpg';
            $site = Env('FILE_CENTER');
            break;
    }

    if (strpos($url, 'http') === false && strpos($url, 'https') === false) {
        return $site.$url;
    }
    return $url;
}

function Redis($db = 0) 
{
    return \frame\Redis::getInstance($db);
}

function Config($name = '') 
{
    if (empty($name)) return $GLOBALS;
    return $GLOBALS[$name] ?? [];
}

function Env($name = '', $replace = '')
{
    if (empty($name)) return Config('ENV');
    return Config('ENV')[$name] ?? $replace;
}

function DbConfig($db = 'default')
{
    if (empty(Config('database'))) {
        throw new Exception("数据库配置文件不存在", 1);
        exit();
    }
    return Config('database')[$db] ?? [];
}

/**
 * 转换翻译文本
 */
function dist($name = '')
{
    return $name;
    $translateService = \App::make('App/Services/TranslateService');
    return $translateService->getText($name);
}