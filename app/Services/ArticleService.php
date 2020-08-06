<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Article;
use App\Models\ArticleData;

class ArticleService extends BaseService
{
	public function __construct(Article $model, ArticleData $dataModel)
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
            $categoryService = \App::make('App/Services/ArticleCategoryService');
            $languageService = \App::make('App/Services/LanguageService');
            $attchService = \App::make('App/Services/AttachmentService');

            $cateList = $categoryService->getList();
            $cateList = array_column($cateList, null, 'cate_id');
            //语言列表
            $lanList = $languageService->getList();
            $lanList = array_column($lanList, null, 'cate_id');
            foreach ($list as $key => $value) {
                $value['cate_name'] = $cateList[$value['cate_id']]['name'] ?? '';
                $value['language_name'] = $lanList[$value['lan_id']]['name'] ?? '';

                if (!empty($value['image'])) {
                    $data = $attchService->getAttachmentById(explode(',', $value['image'])[0]);
                    $value['image'] = $data['url'];
                }
                $list[$key] = $value;
            }
        }
         
        return $list;
    }

    public function getInfo($artId, $lanId)
    {
        $artId = (int) $artId;
        $lanId = (int) $lanId;
        if (empty($lanId) || empty($lanId)) return [];

        $cacheKey = 'ARTICLE_INFO_CACHE_'.$proId.'_'.$lanId;

        $info = Redis()->get($cacheKey);

        if (empty($info)) {
            $info = $this->baseModel->where('art_id', $artId)
                                    ->where('lan_id', $lanId)
                                    ->find();

            if (!empty($info)) {
                //商品详情
                $data = $this->dataModel->getInfo($artId, $lanId);

                $info = array_merge($info, $data);

                //文章图片
                if (!empty($info['image'])) {
                    $attchService = \App::make('App/Services/AttachmentService');
                    $imageList = $attchService->getAttachmentListById($info['image']);
                }
                $info['image_list'] = $imageList ?? [];

                Redis()->set($cacheKey, $info, -1);
            }
        }

        return $info;
    }

    public function clearCache($proId, $lanId)
    {
        $cacheKey = 'ARTICLE_INFO_CACHE_'.$proId.'_'.$lanId;

        return Redis()->del($cacheKey);
    }
}