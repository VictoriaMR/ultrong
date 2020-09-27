<?php

namespace App\Models;

use App\Models\Base as BaseModel;

/**
 * 	背景颜色类
 */
class ArticleData extends BaseModel
{ 
	//表名
    public $table = 'article_data';
    protected $primaryKey = 'art_id';

    public function getInfo($artId, $lanId)
    {
        $artId = (int) $artId;
        $lanId = (int) $lanId;
        if (empty($lanId) || empty($lanId)) return [];

        return $this->where('art_id', $artId)
                    ->where('lan_id', $lanId)
                    ->find();
    }
}