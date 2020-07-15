<?php 

namespace App\Services\Admin;

use App\Services\Base as BaseService;
use App\Models\AdminController;

/**
 * 	admin 控制器类
 */
class ControllerService extends BaseService
{	
	protected static $constantMap = [
        'base' => AdminController::class,
    ];

	public function __construct(AdminController $model)
    {
        $this->baseModel =  $model;
    }

    public function getList() 
    {
    	$cacheKey = 'ADMIN_CONTROLLER_LIST';
    	$list = Redis()->get($cacheKey);
    	if (empty($list)) {
    		$list = $this->baseModel->getList();
    		// Redis()->set($cacheKey, json_encode($list, JSON_UNESCAPED_UNICODE), self::constant('EXPIRE_TIME'));
    	}

    	if (!empty($list) && !is_array($list)) {
    		$list = json_decode($list, true);
    	}

    	return $list;
    }

    public function getListFormat() 
    {
    	$list = $this->getList();

    	$list = $this->listFormat($list);

    	return $list;
    }

    protected function listFormat($list, $parentId = 0) 
    {
    	$returnData = [];
    	foreach ($list as $value) {
    		if ($value['parent_id'] == $parentId) {
    			$temp = $this->listFormat($list, $value['con_id']);
    			if (!empty($temp)) {
	    			$value['son'] = $temp;
    			}
	    		$returnData[] = $value;
    		}
    	}

    	return $returnData;
    }

    public function getInfoByName($name, $isPerent = false)
    {
        if (empty($name)) return [];
        $query = $this->baseModel->where('name_en', $name);
        if ($isPerent) 
            $query->where('parent_id', 0);
        else 
            $query->where('parent_id', '<>', 0);

        return $query->find();
    }
}