<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Translate;
use frame\Session;

class TranslateService extends BaseService
{
	public function __construct(Translate $translate)
    {
        $this->baseModel = $translate;
    }

    /**
     * @method 获取对应站点的翻译文本
     * @author LiaoMingRong
     * @date   2020-07-13
     * @param  string   $name 
     * @return array
     */
    public function getText($name = '')
    {
        if (empty($name)) return '';

        $language = Session::getInfo('site_language');

        if ($language == 'cn') return $name;

        $cacheKey = 'SITE_TRANSLATE_TEXT_'.strtoupper($language);

        //获取缓存中对应的翻译文本
    	$info = Redis(1)->hget($cacheKey, $name);

    	if (empty($info)) {
            //检查默认的中文文本是否存在
            $this->setNotExist($name, 'cn', $name);
            $this->setNotExist($name, $language);

            $info = $name;	
    	}

    	return $info;
    }

    public function setNotExist($name, $type, $value = '')
    {
        if ($this->isExistName($name, $type)) return true;

        $data = [
            'name' => $name,
            'type' => $type, 
        ];
        if (!empty($value))
            $data['value'] = $value;

        return $this->baseModel->insert($data);
    }

    /**
     * @method 是否存在名称
     * @date   2020-07-13
     * @param  [type]     $name 名称
     * @param  [type]     $type 语言类型
     * @return boolean    
     */
    public function isExistName($name, $type)
    {
        return $this->baseModel->where('name', $name)
                               ->where('type', $type)
                               ->count() > 0;
    }
}