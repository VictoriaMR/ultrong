<?php $this->load('Common.baseHeader');?>
<style type="text/css">
</style>
<div class="container-fluid">
	<form class="form-horizontal" style="max-width: 500px;" method="post" action="<?php echo adminUrl('site');?>">
		<input type="hidden" name="site_id" value="<?php echo $siteInfo['site_id'] ?? 0;?>">
		<?php foreach ($name as $key => $value) { ?>
		<?php if (in_array($key, ['domain', 'phone'])) { ?>
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span><?php echo $value;?>：</span></div>
            <input type="text" class="form-control" name="<?php echo $key;?>" value="<?php echo $siteInfo[$key] ?? '';?>" />
        </div>
    	<?php } else { ?>
    	<div class="input-group margin-top-15">
            <div class="input-group-addon"><span><?php echo $value;?>：</span></div>
            <textarea type="text" class="form-control" name="<?php echo $key;?>"><?php echo $siteInfo[$key] ?? '';?></textarea>
        </div>
    	<?php } ?>
    	<?php } ?>
    	<button type="submit" class="btn btn-primary margin-top-15">保存</button>
	</form>
</div>
<?php $this->load('Common.baseFooter');?>