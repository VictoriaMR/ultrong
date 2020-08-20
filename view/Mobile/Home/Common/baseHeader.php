<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_title ?? '';?><?php echo !empty($_title2) ? '-'.$_title2 : '';?></title>
    <meta name="apple-mobile-web-app-title" content="<?php echo $_name ?? '';?>" />
    <meta name="keywords" content="<?php echo $_seo ?? '';?>" />
    <meta name="description" content="<?php echo $_description ?? '';?>" />
    <link rel="shortcut icon" href="image/favicon.ico" />
    <?php foreach (\frame\Html::getCss() as $value) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $value;?>" />
    <?php }?>
    <?php foreach (\frame\Html::getJs() as $value) { ?>
    <script type="text/javascript" src="<?php echo $value;?>"></script>
    <?php }?>
</head>
<body>
<?php if ($site['gray_start_at'] <= time() && $site['gray_end_at'] >= time()) { ?>
<style type="text/css">
html {
    filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);
    -webkit-filter: grayscale(100%);
    -moz-filter: grayscale(100%);
    -ms-filter: grayscale(100%);
    -o-filter: grayscale(100%);
    filter: grayscale(100%);
    filter: gray;
}
</style>
<?php } ?>
<script type="text/javascript">
var HOME_URI = "<?php echo Env('APP_DOMAIN').'home/';?>";
</script>
<div class="header-top fixed">
    <div class="container">
        <div class="table left">
            <a href="<?php echo url('');?>" class="table-cell logo">
                <img src="<?php echo siteUrl('image/mobile/logo.png');?>">
            </a>
        </div>
        <div class="right top-right">
            <a class="block mean right close" id="top-mean" href="javascript:;">
                <i class="iconfont icon-nav font-30 color-blue"></i>
            </a>
            <a class="block search right" href="<?php echo url('index/search');?>">
                <span class="iconfont icon-search font-16 color-white"></span>
                <span class="font-16 title color-white"><?php echo dist('搜索');?></span>
            </a>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!-- 导航栏 -->
<?php if (!empty($nav_list)) {?>
<div class="menu-box hidden">
    <div class="menu-sy-mask"></div>
    <div class="menu-content bg-white">
        <?php foreach ($nav_list as $value) { ?>
        <div class="item-box">
            <a class="item font-14 font-600 <?php echo !empty($value['son']) ? 'item-href' : '';?>" href="<?php echo !empty($value['son']) ? 'javascript:;' : $value['url'];?>">
                <span class="font-14 font-600"><?php echo $value['name'];?></span> 
                <i class="iconfont icon-more"></i>
            </a>
        </div>
        <?php if (!empty($value['son'])) { ?>
        <div class="category-box hidden">
            <div class="back-menu item font-600 font-14">
                <i class="iconfont icon-back"></i>
                <span class="margin-left-24 font-600 font-14"><?php echo dist('返回菜单');?></span>
            </div>
            <div class="nav-category">
                <div class="category-list">
                    <div class="category-name">
                        <a class="item" href="<?php echo $value['url'];?>">
                            <span class="font-14 font-600"><?php echo $value['name'];?></span>
                            <span class="view-all"><?php echo dist('全部');?></span>
                        </a>
                    </div>
                    <ul>
                        <?php foreach ($value['son'] as $sonv) { ?>
                        <li>
                            <a class="font-14" href="<?php echo $sonv['url'];?>"><?php echo $sonv['name'];?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<?php } ?>