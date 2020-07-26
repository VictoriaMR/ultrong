<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<?php if (!empty($list)) { ?>
	<?php foreach ($list as $key => $value) { ?>
	<?php $info = $bannerList[$value['lan_id']] ?? [];?>
	<div class="banner-content" data-lan_id="<?php echo $value['lan_id'];?>">
		<form>
			<input type="hidden" name="lan_id" value="<?php echo $value['lan_id'];?>">
			<input type="hidden" name="image" value="">
			<div class="form-inline">
				<h4 class="left"><?php echo $value['name'];?></h4>
				<div class="left form-group margin-left-15">
					<label>背景色</label>
					<input type="text" class="form-control" name="background" value="<?php echo $info['background'] ?? '';?>">
				</div>
			</div>
			<div class="clear"></div>
			<ul class="upload-item-content" data-length="6" data-site="banner" data-sort="1" data-delete="1" data-href="1">
				<?php if (!empty($info['content'])) { ?>
				<?php foreach ($info['content'] as $k => $v) { ?>
				<li>
					<div class="upload-item" data-attach_id="<?php echo $v['attach_id'];?>">
						<img src="<?php echo $v['url'];?>">
					</div>
					<div class="margin-top-3">
						<input type="text" class="form-control" name="href[]" value="<?php echo $v['href'] ?? '';?>" />
					</div>
				</li>
				<?php } ?>
				<?php } ?>
				<?php if (count($info['content'] ?? []) < 6) { ?>
				<li>
					<div class="upload-item"></div>
					<div class="margin-top-3">
						<input type="text" class="form-control" name="href[]" />
					</div>
				</li>
				<?php } ?>
			</ul>
			<div class="clear"></div>
			<button type="button" class="btn btn-primary save">保存</button>
		</form>
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
