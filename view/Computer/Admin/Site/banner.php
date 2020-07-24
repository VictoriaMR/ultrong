<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<?php if (!empty($list)) { ?>
	<?php foreach ($list as $key => $value) { ?>
	<div class="banner-content">
		<h3>yingwen</h3>
		<ul data-length="6" data-site="banner" data-sort="1" data-delete="1">
			<?php if (!empty($imageArr[$value['lan_id']])) { ?>
			<?php foreach ($imageArr[$value['lan_id']] as $k => $v) { ?>
			<li class="upload-item">
				<img src="<?php echo $v['url'];?>">
			</li>
			<?php } ?>
			<?php } ?>
			<?php if (count($imageArr[$value['lan_id']] ?? []) < 6) { ?>
			<li class="upload-item"></li>
			<?php } ?>
		</ul>
	</div>
	<div class="clear"></div>
	<?php } ?>
	<?php } ?>
</div>
<script type="text/javascript">
$(function(){
	UPLOAD.init({
		obj: $('.banner-content .upload-item'),
		success: function(res){
			if(res.code == 200) {
				$('.avatar').find('img').attr('src', res.data.url);
			} else {
				errorTips(res.message);
			}
		},
		error: function(res){
			errorTips('上传失败');
		}
	});
});
</script>
<?php $this->load('Common.baseFooter');?>
