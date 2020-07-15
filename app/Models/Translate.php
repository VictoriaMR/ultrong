<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	翻译文本 model
 */
class Translate extends BaseModel
{
	//表名
    public $table = 'translate';

    public function getList($where = [], $page = 1, $size = 20)
    {
        return $this->where($where)
        			->offset(($page - 1) * $size)
                    ->limit($size)
                    ->get();

    }
}