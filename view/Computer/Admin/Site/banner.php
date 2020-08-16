<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<select class="form-control margin-bottom-15 type" style="width: 200px;">
		<option value="0" <?php echo !$type ? 'selected' : '';?>>PC端</option>
		<option value="1" <?php echo $type ? 'selected' : '';?>>手机端</option>
	</select>
	<?php if (!empty($list)) { ?>
	<?php foreach ($list as $key => $value) { ?>
	<?php $info = $bannerList[$value['lan_id']] ?? [];?>
	<div class="banner-content margin-bottom-15" data-lan_id="<?php echo $value['lan_id'];?>">
		<form>
			<input type="hidden" name="lan_id" value="<?php echo $value['lan_id'];?>">
			<input type="hidden" name="image" value="">
			<input type="hidden" name="type" value="<?php echo $type ?? 0;?>">
			<h3 class="left font-16 margin-bottom-15"><?php echo $value['name'];?></h3>
			<div class="clear"></div>
			<ul class="upload-item-content" data-length="6" data-site="banner" data-sort="1" data-delete="1" data-href="1">
				<?php if (!empty($info['content'])) { ?>
				<?php foreach ($info['content'] as $k => $v) { ?>
				<li>
					<div class="upload-item" data-attach_id="<?php echo $v['attach_id'];?>">
						<img src="<?php echo $v['url'];?>">
					</div>
					<div class="margin-top-3 form-inline url-content">
						<label>链接: </label>
						<input type="text" class="form-control width-100" name="href[]" value="<?php echo $v['href'] ?? '';?>" />
					</div>
					<div class="margin-top-3 form-inline url-content">
						<label>背景色: </label>
						<input type="text" class="form-control width-100" name="background[]" value="<?php echo $v['background'] ?? '';?>" />
					</div>
				</li>
				<?php } ?>
				<?php } ?>
				<?php if (count($info['content'] ?? []) < 6) { ?>
				<li>
					<div class="upload-item"></div>
					<div class="margin-top-3 form-inline url-content">
						<label>链接: </label>
						<input type="text" class="form-control width-100" name="href[]" value="" />
					</div>
					<div class="margin-top-3 form-inline url-content">
						<label>背景色: </label>
						<input type="text" class="form-control width-100" name="background[]" value="" />
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
