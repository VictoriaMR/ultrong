<?php 

namespace App\Services;

use App\Models\ProductData;

/**
 * 
 */
class ProductDataService
{
	public function __construct(ProductData $model)
    {
        $this->baseModel = $model;
    }

    public function updateProductData($proId, $lanId, $data)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($proId) || empty($lanId) || empty($data)) return false;

        if ($this->isExist($proId, $lanId)) {
            $result = $this->baseModel->where('pro_id', $proId)
                                      ->where('lan_id', $lanId)
                                      ->update($data);
        } else {
            $data['pro_id'] = $proId;
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
    public function isExist($proId, $lanId)
    {
        return $this->baseModel->where('pro_id', $proId)
                               ->where('lan_id', $lanId)
                               ->count() > 0;
    }

    public function getInfo($proId, $lanId)
    {
        return $this->baseModel->getInfo($proId, $lanId);
    }
}