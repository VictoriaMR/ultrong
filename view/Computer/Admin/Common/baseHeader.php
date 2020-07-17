<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?? '';?></title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="favicon.ico">
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
var ADMIN_URI = "<?php echo Env('APP_DOMAIN').'admin/';?>";
</script>
<?php if (!empty($navArr)) { ?>
<div id="header-nav" class="container-fluid">
    <div class="nav" data-id="0"> 
        <span><?php echo implode(' > ', $navArr);?></span>
        <a title="新窗口中打开" class="extralink" target="_blank" href="#">
            <img src="<?php echo siteUrl('image/computer/icon/extralink.png');?>">
        </a>
        <a title="刷新当前页面" class="extralink" href="#">
            <img src="<?php echo siteUrl('image/computer/icon/refresh.png');?>">
        </a>
     </div>
</div>
<?php } ?>
<?php if (!empty($tabs)) { ?>
<div class="container-fluid" style="margin-bottom: 15px;">
    <ul class="nav nav-tabs common-tabs">
        <?php foreach ($tabs as $key => $val) {?>
            <li class="<?php echo $key == $func ? 'active' : '';?>"><a href="<?php echo adminUrl($controller.'/'.$key);?>"><?php echo $val; ?></a></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>