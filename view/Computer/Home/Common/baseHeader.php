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
var ADMIN_API = "<?php echo getenv('APP_DOMAIN').'api/admin/';?>";
</script>
<div class="header-top">
    <div class="container">
        <div id="index_welcome"><?php echo $index_welcome;?></div>
        <?php echo dist('欢迎');?>
    </div>
</div>