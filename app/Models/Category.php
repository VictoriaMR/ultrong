<?php

namespace App\Models;

use App\Models\Base as BaseModel;

class Category extends BaseModel
{
	//表名
    protected $table = 'product_category';

    //主键
    protected $primaryKey = 'cate_id';
}