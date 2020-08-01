<?php

namespace App\Models;

use App\Models\Base;

class AttachmentEntity extends Base
{
    //表名
    protected $table = 'attachment_entity';

    //文件类型
    const TYPE_INDEX_BANNER = 1; //首页banner
    const TYPE_PRODUCT = 2; //产品图片
    const TYPE_ADMINER_AVATAR = 3; //管理员logo

    public function getListByType($type = 0)
    {
        return $this->where('type', (int) $type)->get();
    }

    public function getListByTypeOne($type = 0)
    {
        return $this->where('type', (int) $type)->find();
    }
}
