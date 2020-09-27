<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class Article extends BaseModel
{
	//表名
    public $table = 'article';
    protected $primaryKey = 'art_id';

    /**
     * @method 获取列表
     * @author Victoria
     * @date   2020-06-10
     * @return array
     */
    public function getList($where = [], $page, $size, $orderBy = [])
    {
        return $this->where($where)
                    ->offset(($page - 1) * $size)
                    ->limit($size)
                    ->orderBy($orderBy)
                    ->get();
    }
}