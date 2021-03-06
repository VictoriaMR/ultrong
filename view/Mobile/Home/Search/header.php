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
    <div class="container flex">
        <a class="iconfont icon-home font-40 color-blue margin-top-5 margin-right-20" href="<?php echo url();?>"></a>
        <form class="flex-1 margin-top-8" action="<?php echo url('search')?>" method="get">
            <div class="flex">
                <input name="keyword" type="text" class="input search-input flex-1" placeholder="<?php echo dist('请输入关键字');?>" value="<?php echo iget('keyword', '');?>">
                <a class="btn search-btn" onclick="$('form').submit();"><?php echo dist('搜索');?></a>
            </div>
        </form>
    </div>
</div>