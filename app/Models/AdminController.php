<?php

namespace App\Models;

use App\Models\Base as BaseModel;

class AdminController extends BaseModel
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSE = 0;
    const EXPIRE_TIME = 60 * 60 * 24;
    
    //表名
    public $table = 'admin_controller';

    //主键
    protected $primaryKey = 'con_id';

}