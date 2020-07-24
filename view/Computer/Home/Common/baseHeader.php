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
var HOME_URI = "<?php echo Env('APP_DOMAIN').'home/';?>";
</script>
<div class="header-top">
    <div class="container">
        <a class="right help" href="<?php echo url('help');?>"><?php echo dist('帮助');?></a>
        <a class="right language" href="javascript:;"><span><?php echo dist('语言');?></span><span class="icon icon-angle-w-down"></span>
            <?php if (!empty($language_list)) { ?>
            <ul class="language-selector selector hidden">
                <?php foreach ($language_list as $key => $value) { ?>
                <li class="<?php echo $site_language == $value['value'] ? 'selected': '';?>" data-id="<?php echo $value['lan_id'];?>">
                    <span><?php echo $value['name'];?></span>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
        </a>
        <div class="clear"></div>
    </div>
</div>