<?php 

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Product;
use App\Models\ProductData;

/**
 * 
 */
class ProductService extends BaseService
{
	public function __construct(Product $model, ProductData $dataModel)
    {
        $this->baseModel = $model;
        $this->dataModel = $dataModel;
    }

    public function getTotal($where = [])
    {
        return $this->baseModel->where($where)->count();
    }

    public function getList($where = [], $page = 1, $size = 10, $orderBy = [])
    {
        $list = $this->baseModel->getList($where, $page, $size, $orderBy);

        if (!empty($list)) {
            $categoryService = \App::make('App/Services/CategoryService');
            $languageService = \App::make('App/Services/LanguageService');
            $attchService = \App::make('App/Services/AttachmentService');

            $cateList = $categoryService->getList();
            $cateList = array_column($cateList, null, 'cate_id');
            //语言列表
            $lanList = $languageService->getList();
            $lanList = array_column($lanList, null, 'lan_id');
            foreach ($list as $key => $value) {
                $value['cate_name'] = $cateList[$value['cate_id']]['name'] ?? '';
                $value['language_name'] = $lanList[$value['lan_id']]['name'] ?? '';
                $value['url'] = url('product', ['pro_id'=>$value['pro_id'], 'lan_id' => $value['lan_id']]);

                if (!empty($value['image'])) {
                    $data = $attchService->getAttachmentById(explode(',', $value['image'])[0]);
                    $value['image'] = $this->pathUrl($data['url'], '300x300');
                }
                $list[$key] = $value;
            }
        }

        return $list;
    }

    public function updateData($proId, $lanId, $data)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($proId) || empty($lanId) || empty($data)) return false;

        return $this->baseModel->where('pro_id', $proId)
                               ->where('lan_id', $lanId)
                               ->update($data);
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

    public function getInfoCache($proId, $lanId)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($proId) || empty($lanId)) return [];

        $cacheKey = 'PRODUCT_INFO_CACHE_'.$proId.'_'.$lanId;

        $info = Redis()->get($cacheKey);

        if (empty($info)) {
            $info = $this->getInfo($proId, $lanId);
            Redis()->set($cacheKey, $info, -1);
        }

        return $info;
    }

    public function getInfo($proId, $lanId)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($proId) || empty($lanId)) return [];
        $info = $this->baseModel->where('pro_id', $proId)
                                ->where('lan_id', $lanId)
                                ->find();
        if (!empty($info)) {
            //商品详情
            $data = $this->dataModel->getInfo($proId, $lanId);
            $info = array_merge($info, $data);

            //商品图片
            if (!empty($info['image'])) {
                $attchService = \App::make('App/Services/AttachmentService');
                $imageList = $attchService->getAttachmentListById($info['image']);
                foreach ($imageList as $key => $value) {
                    $imageList[$key]['url'] = $this->pathUrl($value['url'], '300x300');
                }
            }
            $info['image_list'] = $imageList ?? [];
        }
        return $info;
    }

    public function clearCache($proId, $lanId)
    {
        $cacheKey = 'PRODUCT_INFO_CACHE_'.$proId.'_'.$lanId;

        return Redis()->del($cacheKey);
    }

    public function delete($proId, $lanId)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($proId) || empty($lanId)) return false;

        $result = $this->baseModel->where('pro_id', $proId)
                                  ->where('lan_id', $lanId)
                                  ->delete();
        if ($result) {
            $result = $this->dataModel->where('pro_id', $proId)
                                      ->where('lan_id', $lanId)
                                      ->delete();

            $result = $this->clearCache($proId, $lanId);
        }

        return $result;
    }

    public function hitCountAdd($proId, $lanId)
    {
        $proId = (int) $proId;
        $lanId = (int) $lanId;
        if (empty($proId) || empty($lanId)) return false;

        return $this->baseModel->where('pro_id', $proId)
                               ->where('lan_id', $lanId)
                               ->increment('hit_count');
    }
}