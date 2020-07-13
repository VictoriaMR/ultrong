<?php 

namespace frame;

class Html
{
	public static $_CSS = [];
	public static $_JS = [];

	public static function addCss($name = '', $public = false)
	{
		if (empty($name)) return false;

		if (is_array($name)) {
			foreach ($name as $value) {
				self::$_CSS[] = Env('APP_DOMAIN') . 'css/' . (IS_MOBILE ? 'mobile/' : 'computer/') . ($public ? '' : strtolower(\Router::getFunc('Class')).'/') . $value . '.css';
			}
		} else {
			self::$_CSS[] = Env('APP_DOMAIN') . 'css/' . (IS_MOBILE ? 'mobile/' : 'computer/') . ($public ? '' : strtolower(\Router::getFunc('Class')).'/') . $name . '.css';
		}
		return true;
	}

	public static function addJs($name = '', $public = false)
	{
		if (empty($name)) return false;

		if (is_array($name)) {
			foreach ($name as $value) {
				self::$_JS[] = Env('APP_DOMAIN') . 'js/' . (IS_MOBILE ? 'mobile/' : 'computer/') . $value . '.js';
			}
		} else {
			self::$_JS[] = Env('APP_DOMAIN') . 'js/' . (IS_MOBILE ? 'mobile/' : 'computer/') . $name . '.js';
		}
		return true;
	}

	public static function getCss()
	{
		if (empty(self::$_CSS)) return [];

		return array_unique(self::$_CSS);
	}

	public static function getJs()
	{
		if (empty(self::$_JS)) return [];

		return array_unique(self::$_JS);
	}
}