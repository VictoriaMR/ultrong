<?php

return [
	'default' => [
		'db_host'	  => Env('DB_HOST', '127.0.0.1'), 	//地址
		'db_port'	  => Env('DB_PORT', '3306'),        //端口
		'db_database' => Env('DB_DATABASE', 'ultrong'), //数据库名称
		'db_username' => Env('DB_USERNAME', 'root'),    //用户
		'db_password' => Env('DB_PASSWORD', 'root'),  	//密码
		'db_charset'  => Env('DB_CHARSET', 'utf8'),     //字符集
	],
	'static' => [
		'db_host'	  => Env('STATIC_DB_HOST', '127.0.0.1'), 			//地址
		'db_port'	  => Env('STATIC_DB_PORT', '3306'),        			//端口
		'db_database' => Env('STATIC_DB_DATABASE', 'ultrong_static'), 	//数据库名称
		'db_username' => Env('STATIC_DB_USERNAME', 'root'),    			//用户
		'db_password' => Env('STATIC_DB_PASSWORD', 'root'),  			//密码
		'db_charset'  => Env('STATIC_DB_CHARSET', 'utf8'),     			//字符集
	],
];