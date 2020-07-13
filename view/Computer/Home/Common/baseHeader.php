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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <?php foreach (\frame\Html::getCss() as $value) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $value;?>">
    <?php }?>
    <?php foreach (\frame\Html::getJs() as $value) { ?>
    <script type="text/javascript" src="<?php echo $value;?>"></script>
    <?php }?>
</head>
<body>
<script type="text/javascript">
var ADMIN_API = "<?php echo Env('APP_DOMAIN').'api/admin/';?>";
</script>
<div class="header-top">
    <div class="container">
        <div id="index_welcome" class="left font-700">欢迎访问纵横增材智能科技（珠海）有限公司</div>
        <div id="languega_list" class="right">
            <div class="selection">
                <div class="selection-icon">
                    <span>简体中文</span>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div id="logo" class="container">
    <a id='logo-img' href="/" class="block col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <img src="<?php echo url('image/computer/logo.png');?>" alt="">
    </a>
    <ul id="address-phone" class="left col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <li>
            <div class="left">
                <img src="<?php echo url('image/computer/home.png');?>">
            </div>
            <div class="left">
                <div class="font-16 font-700 margin-bottom-5">珠海市香洲区前山工业片区</div>
                <div class="font-14 color-9">二期福田路12号2栋601</div>
            </div>
        </li>
        <li>
            <div class="left">
                <img src="<?php echo url('image/computer/time.png');?>">
            </div>
        </li>
        <li>
            <div class="left">
                <img src="<?php echo url('image/computer/email.png');?>">
            </div>
        </li>
    </ul>
</div>