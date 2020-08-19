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
<script type="text/javascript">
var HOME_URI = "<?php echo Env('APP_DOMAIN').'home/';?>";
</script>
<div class="header-top fixed">
    <div class="table left margin-left-10">
        <a href="<?php echo url('');?>" class="table-cell logo">
            <img src="<?php echo siteUrl('image/mobile/logo.png');?>">
        </a>
    </div>
    <div class="right top-right">
        <a class="block mean right close" id="top-mean" href="javascript:;">
            <i class="iconfont icon-nav font-30"></i>
        </a>
        <a class="block search right" href="<?php echo url('index/search');?>">
            <span class="iconfont icon-search font-16"></span>
            <span class="font-16 title"><?php echo dist('搜索');?></span>
        </a>
    </div>
</div>
<!-- 导航栏 -->
<div class="menu-box hidden">
    <div class="menu-sy-mask"></div>
    <div class="menu-content bg-white"></div>
</div>
<style type="text/css">
.menu-box .menu-sy-mask {
    width: 100%;
    height: 100%;
    position: fixed;
    background: #000000;
    left: 0;
    top: .58rem;
    z-index: 16000006;
    opacity: 0.65;
}
.menu-box .menu-content {
    width: 75%;
    right: 0;
    top: .58rem;
    position: fixed;
    height: calc(100% - 0.58rem);
    z-index: 16000007;
    overflow: auto;
    right: -75%;
}
</style>