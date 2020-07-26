<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class Banner extends BaseModel
{
	//表名
    public $table = 'banner';

    //主键
    protected $primaryKey = 'lan_id';
}