<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Site;

class SiteService extends BaseService
{
    const CACHE_KEY = 'SITE_INFO_CACHE';

	public function __construct(Site $site)
    {
        $this->baseModel = $site;
    }

    /**
     * @method 获取站点详情
     * @author LiaoMingRong
     * @date   2020-07-13
     * @param  [type]     $data [description]
     * @return array
     */
    public function getInfo($where = [])
    {
    	$info = Redis()->get(self::constant('CACHE_KEY'));
    	if (empty($info)) {
    		$info = $this->baseModel->find();
    		Redis()->set(self::constant('CACHE_KEY'), $info, -1);
    	}

    	return $info;
    }

    public function clearCache()
    {
        return Redis()->del(self::constant('CACHE_KEY'));
    }

    public function deleteCache()
    {
        return Redis()->flushall();
    }

    public function sitemap()
    {
        $xmlDom = new \DomDocument('1.0', 'utf-8');
        //创建根节点
        $xmlRoot = $xmlDom->createElement('urlset');
        $xmlns = $xmlDom->createAttribute('xmlns');
        $xmlnsUrl = $xmlDom->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9');
        $xmlns->appendChild($xmlnsUrl);
        $xmlRoot->appendchild($xmlns);

        //首页
        $tempData = [
            'loc' => Env('APP_DOMAIN'),
            'lastmod' => date('Y-m-d', time()),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];
        $res = $this->createSingleXml($xmlDom, 'url', $tempData);
        $xmlRoot->appendchild($res);

        $cateService = \App::make('App/Services/CategoryService');
        $productService = \App::make('App/Services/ProductService');
        $articleCategoryService = \App::make('App/Services/ArticleCategoryService');
        $articleService = \App::make('App/Services/ArticleService');

        //商品分列-列表
        $cateList = $cateService->getList(['status'=>1]);
        foreach ($cateList as $key => $value) {
            $tempData = [
                'loc' => url('productList', ['cate_id' => $value['cate_id']]),
                'lastmod' => date('Y-m-d', time()),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];
            $res = $this->createSingleXml($xmlDom, 'url', $tempData);
            $xmlRoot->appendchild($res);
            //分类下产品列表
            $where = [
                'is_deleted' => 0, 
                'cate_id'=>$value['cate_id'],
            ];
            $productList = $productService->getList($where, 1, 9999);
            foreach ($productList as $pk => $pv) {
                $tempData = [
                    'loc' => url('product', ['pro_id' => $pv['pro_id'], 'lan_id' => $pv['lan_id']]),
                    'lastmod' => date('Y-m-d', time()),
                    'changefreq' => 'weekly',
                    'priority' => '0.8',
                ];
                $res = $this->createSingleXml($xmlDom, 'url', $tempData);
                $xmlRoot->appendchild($res);
            }
        }
        //文章分类列表
        $articleList = $articleCategoryService->getList();
        foreach ($articleList as $key => $value) {
            if (!empty($value['son'])) {
                foreach ($value['son'] as $ak => $av) {
                    $tempData = [
                        'loc' => url('articleList', ['cate_id' => $av['cate_id']]),
                        'lastmod' => date('Y-m-d', time()),
                        'changefreq' => 'weekly',
                        'priority' => '0.7',
                    ];
                    $res = $this->createSingleXml($xmlDom, 'url', $tempData);
                    $xmlRoot->appendchild($res);
                    $list = $articleService->getListFormat(['cate_id' => $av['cate_id']]);
                    foreach ($list as $aak => $aav) {
                        $tempData = [
                            'loc' => url('article', ['art_id' => $aav['art_id'], 'lan_id' => $aav['lan_id']]),
                            'lastmod' => date('Y-m-d', time()),
                            'changefreq' => 'weekly',
                            'priority' => '0.6',
                        ];
                        $res = $this->createSingleXml($xmlDom, 'url', $tempData);
                        $xmlRoot->appendchild($res);
                    }
                }
            } else {
                $tempData = [
                    'loc' => url('articleList', ['cate_id' => $value['cate_id']]),
                    'lastmod' => date('Y-m-d', time()),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
                $res = $this->createSingleXml($xmlDom, 'url', $tempData);
                $xmlRoot->appendchild($res);
                $list = $articleService->getListFormat(['cate_id' => $value['cate_id']]);
                foreach ($list as $ak => $av) {
                    $tempData = [
                        'loc' => url('article', ['art_id' => $av['art_id'], 'lan_id' => $av['lan_id']]),
                        'lastmod' => date('Y-m-d', time()),
                        'changefreq' => 'weekly',
                        'priority' => '0.6',
                    ];
                    $res = $this->createSingleXml($xmlDom, 'url', $tempData);
                    $xmlRoot->appendchild($res);
                }
            }
        }
        $saveFile = ROOT_PATH.'public/';
        if (!is_dir($saveFile)) {
            mkdir($saveFile, 0777, true);
        }
        $saveFile .= 'sitemap.xml';
        $xmlDom->appendchild($xmlRoot);
        $res = $xmlDom->save($saveFile);
        return $res;
    }

    public function sendSitemap()
    {
        $data[] = Env('APP_DOMAIN');
        $cateService = \App::make('App/Services/CategoryService');
        $productService = \App::make('App/Services/ProductService');
        $articleCategoryService = \App::make('App/Services/ArticleCategoryService');
        $articleService = \App::make('App/Services/ArticleService');

        $cateList = $cateService->getList(['status'=>1]);
        foreach ($cateList as $key => $value) {
            $data[] = url('productList', ['cate_id' => $value['cate_id']]);
            //分类下产品列表
            $where = [
                'is_deleted' => 0, 
                'cate_id'=>$value['cate_id'],
            ];
            $productList = $productService->getList($where, 1, 9999);
            foreach ($productList as $pk => $pv) {
                $data[] = url('product', ['pro_id' => $pv['pro_id'], 'lan_id' => $pv['lan_id']]);
            }
        }
        //文章分类列表
        $articleList = $articleCategoryService->getList();
        foreach ($articleList as $key => $value) {
            if (!empty($value['son'])) {
                foreach ($value['son'] as $ak => $av) {
                    $data[] = url('articleList', ['cate_id' => $av['cate_id']]);
                    $list = $articleService->getListFormat(['cate_id' => $av['cate_id']]);
                    foreach ($list as $aak => $aav) {
                        $data[] = url('article', ['art_id' => $aav['art_id'], 'lan_id' => $aav['lan_id']]);
                    }
                }
            } else {
                $data[] = url('articleList', ['cate_id' => $value['cate_id']]);
                $list = $articleService->getListFormat(['cate_id' => $value['cate_id']]);
                foreach ($list as $ak => $av) {
                    $data[] = url('article', ['art_id' => $av['art_id'], 'lan_id' => $av['lan_id']]);
                }
            }
        }
        $res = \frame\Http::post('http://data.zz.baidu.com/urls?site=ultrong3d.com&token=DJ60rSA90Rpvqr3W',  implode(PHP_EOL, $data));
        $res = json_decode($res, true);
        return $res ?? [];
    }

    protected function createSingleXml($xmlDom, $type, $data)
    {
        if (is_null($xmlDom)) return false;
        if (empty($data) || !is_array($data)) return false;
        $type = $xmlDom->createElement($type);
        if (!$type) return false;
        //转义字符
        $trans = [
            '&' => '&amp;',
            "'" => '&apos;',
            '"' => '&quot;',
            '>' => '&gt;',
            '<' => '&lt;',
        ];
        foreach ($data as $key => $value) {
            //网址实体转义
            if ($key == 'loc') $value = strtr($value, $trans);;
            $temp = $xmlDom->createElement($key, $value);
            $res = $type->appendchild($temp);
            if (!$res) return false;
        }
        //插入根节点中
        return $type;
    }
}