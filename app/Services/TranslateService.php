<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Translate;
use App\Models\TranslateConfig;
use frame\Session;

class TranslateService extends BaseService
{
    const CACHE_KEY = 'SITE_TRANSLATE_TEXT_';

	public function __construct(Translate $translate, TranslateConfig $config)
    {
        $this->baseModel = $translate;
        $this->transModel = $config;
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

        $language = Session::get('site_language_name');

        if ($language == 'cn') return $name;

        $cacheKey = self::constant('CACHE_KEY').strtoupper($language);

        //获取缓存中对应的翻译文本
    	$info = Redis(1)->hget($cacheKey, $name);

    	if (empty($info)) {
            //检查文本
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

    public function getList($where = [], $page = 1, $size = 20)
    {
        $list = $this->baseModel->getList($where, $page, $size);
        if (!empty($list)) {
            $languageService = \App::make('App/Services/LanguageService');
            $langList = $languageService->getList();
            $langList = array_column($langList, null, 'value');

            foreach ($list as $key => $value) {
                $value['type_name'] = $langList[$value['type']]['name'] ?? '';

                $list[$key] = $value;
            }
        }

        return $list;
    }

    public function getListTotal($where = [])
    {
        return $this->baseModel->where($where)->count();
    }

    public function getInterfaceList($where = [], $page = 1, $size = 20)
    {
        $list = $this->transModel->getInterfaceList($where, $page, $size);
        return $list;
    }

    public function getInterfaceListTotal($where = [])
    {
        return $this->transModel->where($where)->count();
    }

    public function updateConfigById($id, $data)
    {
        if (empty($id) || empty($data)) return false;

        return $this->transModel->updateDataById($id, $data);
    }

    public function addConfig($data)
    {
        if (empty($data)) return false;

        return $this->transModel->insert($data);
    }

    public function modifyConfig($id, $data)
    {
        if (empty($id) || empty($data)) return false;
        return $this->transModel->updateDataById($id, $data);
    }

    public function checkConfig($id)
    {
        if (empty($id)) return false;

        $result = \frame\Http::get('1231');

        if ($result['error']) return false;

        return $this->transModel->updateDataById($id, ['checked'=>1]);
    }

    public function reloadCache()
    {
        $languageService = \App::make('App/Services/LanguageService');
        $list = $languageService->getList();

        foreach ($list as $key => $value) {
            $cacheKey = self::CACHE_KEY.strtoupper($value['value']);
            Redis(1)->del($cacheKey);
        }

        $data = $this->baseModel->where('value', '<>', '')->get();

        if (empty($data))
            return true;

        $tempData = [];

        foreach ($data as $key => $value) {
            if (!isset($tempData[$value['type']]))
                $tempData[$value['type']] = [];

            $tempData[$value['type']][$value['name']] = $value['value'];
        }

        foreach ($tempData as $key => $value) {
            $cacheKey = self::CACHE_KEY.strtoupper($key);
            Redis(1)->hmset($cacheKey, $value);
        }

        return true;
    }

    public function updateCache($name, $type, $value)
    {
        if (empty($name) || empty($type) || empty($value)) return false;

        $cacheKey = self::CACHE_KEY.strtoupper($type);
        return Redis(1)->hset($cacheKey, $name, $value);
    }
}