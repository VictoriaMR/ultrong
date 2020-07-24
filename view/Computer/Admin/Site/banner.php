<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<?php if (!empty($list)) { ?>
	<?php foreach ($list as $key => $value) { ?>
	<div class="banner-content" data-lan_id="<?php echo $value['lan_id'];?>">
		<h4><?php echo $value['name'];?></h4>
		<ul data-length="6" data-site="banner" data-sort="1" data-delete="1">
			<?php if (!empty($imageArr[$value['lan_id']])) { ?>
			<?php foreach ($imageArr[$value['lan_id']] as $k => $v) { ?>
			<li class="upload-item" data-attach_id="<?php echo $v['attach_id'];?>">
				<img src="<?php echo $v['url'];?>">
			</li>
			<?php } ?>
			<?php } ?>
			<?php if (count($imageArr[$value['lan_id']] ?? []) < 6) { ?>
			<li class="upload-item"></li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
		<button class="btn btn-primary save">保存</button>
	</div>
	<div class="clear"></div>
	<?php } ?>
	<?php } ?>
</div>
<script type="text/javascript">
$(function(){
	BANNER.init();
});
</script>
<?php $this->load('Common.baseFooter');?>
