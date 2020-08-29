<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Logger;
use App\Models\HandleLogger;

class LogService extends BaseService
{
	const PATH_FORMAT = [
		'Home/Index/index' => '首页',
		'Home/ProductList/index' => '产品列表',
		'Home/Product/index' => '产品详情',
        'Home/Search/index' => '搜索页',
        'Home/ArticleList/index' => '文章列表',
        'Home/Article/index' => '文章详情',
	];

	public function __construct(Logger $logger, HandleLogger $handle)
    {
        $this->baseModel = $logger;
        $this->handleModel = $handle;
    }

    public function create($data)
    {
    	return $this->baseModel->insert($data);
    }

    /**
     * @method 获取浏览总数
     * @author LiaoMingRong
     * @date   2020-08-17
     */
    public function getTotal($where = [])
    {
    	return $this->baseModel->where($where)->groupBy('ip')->sum();
    }

    /**
     * @method 按月统计
     * @author LiaoMingRong
     * @date   2020-08-17
     * @return [type]     [description]
     */
    public function monthList()
    {
    	$list = $this->baseModel->select(['COUNT(*) AS count', "FROM_UNIXTIME(create_at,'%Y-%m') months"])
    							->groupBy('ip, months')
    							->get();
    	$returnData = [];
    	foreach ($list as $key => $value) {
    		$returnData[$value['months']] = ($returnData[$value['months']] ?? 0) +1;
    	}

    	return $returnData;
    }

    public function getListTotal($where = [])
    {
    	return $this->baseModel->where($where)->count();
    }		

    public function getList($where = [], $page = 1, $size = 40)
    {
    	$list = $this->baseModel->where($where)
    							->offset(($page - 1) * $size)
                    			->limit($size)
                    			->orderBy('create_at', 'desc')
                    			->get();

        foreach ($list as $key => $value) {
        	$list[$key]['path'] = $this->getPath($value['path']);
        	$list[$key]['user_agent'] = $this->getBrowser($value['user_agent']);
        }

        return $list;
    }

    public function getPath($path)
    {
    	if (empty(self::PATH_FORMAT[$path])) return $path;
    	return self::PATH_FORMAT[$path];
    }

    protected function getBrowser($br)
    {
    	if(!empty($br)) {
    		if (preg_match('/MSIE/i', $br)) {
    			$br = 'MSIE';
    		} elseif (preg_match('/Firefox/i', $br)) { 
    			$br = 'Firefox';
    		} elseif (preg_match('/Chrome/i', $br)) {
    			$br = 'Chrome';
    		} elseif (preg_match('/Safari/i', $br)) {
    			$br = 'Safari';
    		} elseif (preg_match('/Opera/i', $br)) {
    			$br = 'Opera';
    		} else {
    			$br = 'Other';
    		}
    		return $br;
    	} else {
    		return '未知设备';
		}
	}

    public function handleLog($data)
    {
        return $this->handleModel->insert($data);
    }

}