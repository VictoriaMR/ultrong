<?php

namespace frame;

class Redis
{
	private static $_instance = null;
    private static $_link = null;
    private static $_db = 0;
    const DEFAULT_EXT_TIME = 60;
    const DEFAULT_CONNECT_TIME = 5;
    const DEFAULT_DB = 0;
    const SET_DB = 1;
    const LIST_DB = 3;

	public static function getInstance($db = 0) 
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();

            try {
                self::$_link = new \Redis();
                self::connect();
            } catch (\Exception $e) {
                self::$_link = null;
            }

        }

        if (!is_null(self::$_link)) {
            if (!self::$_link->ping()) {
                self::connect();
            }
            self::$_db = $db;
            self::$_link->select($db);//选择数据库
        }

        return self::$_instance;
    }

    private static function connect() 
    {
        // if (is_null(self::$_link)) return false;
        self::$_link->connect(Env('REDIS_HOST', '127.0.0.1'), Env('REDIS_PORT', '6379'), self::DEFAULT_CONNECT_TIME);
        if (!empty(Env('REDIS_PASSWORD'))) {
            self::$_link->auth(Env('REDIS_PASSWORD'));
        }
        return true;
    }

    private function selectDbByFunc($func) 
    {
        return true;
    }

    public function get($key)
    {
        if (is_null(self::$_link)) return false;
        $data = self::$_link->get($key);
        $temp = json_decode($data, true);
        if (is_array($temp))
            return $temp;
        else
            return $data;
    }

    public function set($key, $value, $ext=null) 
    {
        if (is_null(self::$_link)) return false;
        self::$_instance->selectDbByFunc('set');
        if (empty($key)) return false;
        $ext = (int)($ext ?? self::DEFAULT_EXT_TIME);

        if (is_array($value))
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);

        if ($ext > 0)
            return self::$_link->set($key, $value, $ext);
        else
            return self::$_link->set($key, $value);
    }

    public function __call($func, $arg)
    {
        if (is_null(self::$_link)) return false;
        self::$_instance->selectDbByFunc($func);
        return self::$_link->$func(...$arg);
    }
}