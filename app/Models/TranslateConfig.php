<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	翻译文本 model
 */
class TranslateConfig extends BaseModel
{
	//表名
    public $table = 'trans_config';

    //主键
    protected $primaryKey = 'tc_id';

    public function getInterfaceList($where = [], $page = 1, $size = 20)
    {
        return $this->where($where)
        			->offset(($page - 1) * $size)
                    ->limit($size)
                    ->get();

    }
}