<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $title ?? '';?></title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="apple-mobile-web-app-title" content="<?php echo $name ?? '';?>">
    <meta name="keywords" content="<?php echo $seo ?? '';?>">
    <meta name="description" content="<?php echo $description ?? '';?>">
    <?php foreach (\frame\Html::getCss() as $value) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $value;?>">
    <?php }?>
    <?php foreach (\frame\Html::getJs() as $value) { ?>
    <script type="text/javascript" src="<?php echo $value;?>"></script>
    <?php }?>
</head>
<body>
<script type="text/javascript">
var HOME_API = "<?php echo Env('APP_DOMAIN').'api/home/';?>";
</script>
<div class="header-top">
    <div class="container">
        <div id="index_welcome" class="left font-700"><?php echo dist($top_title);?></div>
        <?php if (!empty($language_list)){ ?>
        <div id="languega_list" class="right">
            <div class="selection languega-selection">
               <div class="selector-icon">
                    <i class="icon-curr icon-curr-<?php echo $site_language;?>"></i>
                    <span><?php echo $language_list[$site_language]['name'] ?? '';?></span>
                    <i class="icon icon-angle-g-down"></i>
                </div>
                <ul class="selector hidden">
                    <?php foreach ($language_list as $key => $value) { ?>
                    <li class="select" data-type="<?php echo $key;?>">
                        <i class="icon-curr icon-curr-<?php echo $key;?>"></i>
                        <span><?php echo $value['name'];?></span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
        <div class="clear"></div>
    </div>
</div>
<div id="logo">
    <div class="container">
        <a id='logo-img' href="/" class="block left">
            <img src="<?php echo siteUrl('image/computer/logo.png');?>" alt="">
        </a>
        <ul id="address-phone" class="left">
            <li class="address">
                <div class="left">
                    <img src="<?php echo siteUrl('image/computer/home.png');?>">
                </div>
                <div class="left text-content">
                    <div class="font-16 font-700 margin-bottom-5">珠海市香洲区前山工业片区</div>
                    <div class="font-14 color-9">二期福田路12号2栋601</div>
                </div>
            </li>
            <li>
                <div class="left">
                    <img src="<?php echo siteUrl('image/computer/time.png');?>">
                </div>
                 <div class="left text-content">
                    <div class="font-16 font-700 margin-bottom-5">csssss</div>
                    <div class="font-14 color-9">168522555</div>
                </div>
            </li>
            <li>
                <div class="left">
                    <img src="<?php echo siteUrl('image/computer/email.png');?>">
                </div>
                 <div class="left text-content">
                    <div class="font-16 font-700 margin-bottom-5">csssss</div>
                    <div class="font-14 color-9">168522555</div>
                </div>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<div id="menu">
    <div class="container">
        <div class="nav-list left">
            <ul>
                <li  class="<?php echo $index == 'index' ? 'select': '';?>">
                    <a href="/"><?php echo dist('首页');?></a>
                </li>
                <li>
                    <a href="<?php echo url('about');?>"><?php echo dist('关于'.$site_name);?></a>
                </li>
                <li>
                    <a href="<?php echo url('show');?>"><?php echo dist('应用展示');?></a>
                </li>
                <li>
                    <a href="<?php echo url('product');?>"><?php echo dist('产品介绍');?></a>
                </li>
                <li>
                    <a href="<?php echo url('news');?>"><?php echo dist('新闻中心');?></a>
                </li>
                <li>
                    <a href="<?php echo url('contact');?>"><?php echo dist('联系我们');?></a>
                </li>
            </ul>
        </div>
        <div class="search left">
            <div class="relative margin-top-15 right width-100">
                <input type="input" name="search" class="input right" placeholder="<?php echo dist('输入搜索...');?>">
                <i class="icon icon-16 icon-search-gray-16"></i>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>