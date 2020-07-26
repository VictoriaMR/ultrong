<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class ProductData extends BaseModel
{
	//表名
    public $table = 'product_data';

    public function getInfo($proId, $lanId)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($lanId) || empty($lanId)) return [];

        return $this->where('pro_id', $proId)
                    ->where('lan_id', $lanId)
                    ->find();
    }
}