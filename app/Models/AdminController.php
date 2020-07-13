<?php

namespace App\Models;

use App\Models\Base as BaseModel;

class AdminController extends BaseModel
{
    //表名
    public $table = 'admin_controller';

    //主键
    protected $primaryKey = 'con_id';

    const EXPIRE_TIME = 60 * 60 * 24;

    public function getList()
    {
    	return $this->get();
    }
}