<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class Logger extends BaseModel
{
	//表名
    public $table = 'visitor_log';

    //主键
    protected $primaryKey = 'log_id';

    //链接库
    protected $connect = 'static';
}