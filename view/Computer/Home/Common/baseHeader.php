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
    <link rel="shortcut icon" href="image/favicon.ico">
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
var HOME_URL = "<?php echo Env('APP_DOMAIN').'home/';?>";
</script>
<div class="header-top">
    <div class="container">
        <a class="right help" href="<?php echo url('help');?>"><?php echo dist('帮助');?></a>
        <a class="right language" href="javascript:;"><?php echo dist('语言');?><span class="icon icon-angle-w-down"></span>
            <ul class="language-selector selector hidden">
                <li class="select" data-id="3200">
                    <span>English</span>
                </li>
            </ul>
        </a>
        <div class="clear"></div>
    </div>
</div>