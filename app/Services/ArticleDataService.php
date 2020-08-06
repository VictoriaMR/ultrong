<?php 

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\ArticleData;

/**
 * 
 */
class ArticleDataService extends BaseService
{
	public function __construct(ArticleData $model)
    {
        $this->baseModel = $model;
    }

    public function updateArticleData($artId, $lanId, $data)
    {
        $artId = (int) $artId;
        $lanId = (int) $lanId;
        if (empty($artId) || empty($lanId) || empty($data)) return false;

        if ($this->isExist($artId, $lanId)) {
            $result = $this->baseModel->where('art_id', $artId)
                                      ->where('lan_id', $lanId)
                                      ->update($data);
        } else {
            $data['art_id'] = $artId;
            $data['lan_id'] = $lanId;
            $result = $this->baseModel->insert($data);
        }
        return $result;
    }

    /**
     * @method 是否存在数据
     * @author Victoria
     * @date   2020-04-25
     * @return boolean  
     */
    public function isExist($artId, $lanId)
    {
        return $this->baseModel->where('art_id', $artId)
                               ->where('lan_id', $lanId)
                               ->count() > 0;
    }

    public function getInfo($artId, $lanId)
    {
        return $this->baseModel->getInfo($artId, $lanId);
    }
}