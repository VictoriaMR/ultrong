<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $_title ?? '';?><?php echo !empty($_title2) ? '-'.$_title2 : '';?></title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
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
<div id="header-top">
    <div class="container">
        <a class="font-15 left" href="<?php echo url();?>"><?php echo $_name ?? '';?></a>
        <a class="right help" href="<?php echo url('help');?>"><?php echo dist('帮助');?></a>
        <a class="right language" href="javascript:;">
            <span><?php echo dist('语言');?></span>
            <span class="icon icon-angle-w-down"></span>
            <?php if (!empty($language_list)) { ?>
            <ul class="language-selector selector hidden">
                <?php foreach ($language_list as $key => $value) { ?>
                <li class="<?php echo $site_language == $value['value'] ? 'selected': '';?>" data-id="<?php echo $value['lan_id'];?>">
                    <span class="icon-curr icon-curr-<?php echo $value['value'];?>"></span>
                    <span><?php echo $value['name'];?></span>
                </li>
                <?php } ?>
            </ul>
            <?php } ?>
        </a>
        <div class="clear"></div>
    </div>
</div>
<div id="header-content">
    <div class="container bg-white">
        <table border="0" width="100%">
            <tbody>
                <tr>
                    <td width="20%" valign="middle">
                        <div class="logo-box">
                            <a class="block logo" href="<?php echo url();?>">
                                <img src="<?php echo siteUrl('image/computer/logo.png');?>" alt="logo">
                            </a>
                        </div>
                    </td>
                    <td width="80%">
                        <div class="nav width-100">
                            <ul>
                                <li>
                                    <a href="<?php echo url();?>" class="title <?php echo $controller == 'index' ? 'selected' : '';?>"><?php echo dist('首页');?></a>
                                </li>
                                <?php foreach ($nav_list as $value) { ?>
                                <li>
                                    <a href="<?php echo $value['url'];?>" class="title <?php echo $value['selected'] ? 'selected' : '';?>"><?php echo $value['name'];?></a>
                                    <?php if (!empty($value['son'])) { ?>
                                    <ul class="nav-son">
                                    <?php foreach ($value['son'] as $v) { ?>
                                    <li>
                                        <a href="<?php echo $v['url'];?>" class="block"><?php echo $v['name'];?></a>
                                    </li>
                                    <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </li>
                                <?php } ?>
                                <li class="relative">
                                    <a href="<?php echo url('search');?>" class="title <?php echo $controller=='search' ? 'selected' : '';?>">
                                        <span><?php echo dist('搜索');?></span>
                                        <span class="icon search-icon"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(function(){
    HEADER.init();
})
</script>