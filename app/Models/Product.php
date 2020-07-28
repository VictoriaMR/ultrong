<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class Product extends BaseModel
{
	//表名
    public $table = 'product_spu';

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

    /**
     * @method getListTotal
     * @author Victoria
     * @date   2020-07-02
     * @return [type]       [description]
     */
    public function getListTotal($where = [])
    {
        if (!empty($where))
            $this->where($where);

        return $this->count();
    }
}