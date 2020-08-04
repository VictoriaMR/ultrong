<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class ArticleCategory extends BaseModel
{
	const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;
    
	//表名
    public $table = 'article_category';

    //主键
    protected $primaryKey = 'cate_id';
}