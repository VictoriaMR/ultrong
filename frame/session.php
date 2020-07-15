<?php 

namespace frame;

class Session
{
	public static function login($type = 'home')
	{
		return !empty($_SESSION[$type] ?? []);
	}

	public static function set($key, $data = [])
	{
		if (empty($key)) return false;

		$key = explode('_', $key);
		if (count($key) > 1) {
			$_SESSION[$key[0]][$key[1]] = $data;
		} else {
			$_SESSION[$key[0]] = $data;
		}

		return true;
	}

	public static function get($name = '') 
	{
		if (empty($name)) return $_SESSION;

		$name = explode('_', $name);

		$data = $_SESSION[$name[0]] ?? [];

		if (count($key) > 1) {
			return $data[$name[1]] ?? [];
		} else {
			return $data;
		}
	}
}