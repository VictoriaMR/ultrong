<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?? '';?></title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
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
<?php if (!empty($tabs)) { ?>
<div class="container-fluid" style="margin-bottom: 15px;">
    <ul class="nav nav-tabs common-tabs">
        <?php foreach ($tabs as $key => $val) {?>
            <li class="<?php echo $key == $func ? 'active' : '';?>"><a href="<?php echo adminUrl($controller.'/'.$key);?>"><?php echo $val; ?></a></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>