<?php $this->load('Common.baseHeader');?>
<div class="container-fluid" style="padding-left: 10px;">
	<?php if (!empty($member)) { ?>
		<h3>聊天组成员:</h3>
		<div style="margin-top: 10px;">
			<?php foreach ($member as $key => $value) { ?>
			<div class="flex left margin-right-20">
				<div class="flex-1 margin-right-10">
					<?php echo $value['user_id'];?>
					<?php if (!empty($value['user_nickname'])) { ?>
					<?php echo '-'.$value['user_nickname'];?>
					<?php } ?>
				</div>
				<div class="thumbnail" style="width: 100px;height: 100px;">
					<img src="<?php echo $value['user_avatar'];?>">
				</div>
			</div>
			<?php } ?>
			<div class="clear"></div>
		</div>
	<?php } ?>
	<?php if (!empty($list)) {?>
	<h3>聊天记录:</h3>
	<div style="height: 500px;overflow-y: auto;margin-top: 10px;">
		<?php foreach ($list as $key => $value) { ?>
		<div class="flex">
			<div class="thumbnail margin-right-10" style="width: 50px;height: 50px;">
				<img src="<?php echo $value['user_avatar'];?>">
			</div>
			<div class="flex-1">
				<?php echo $value['content'];?>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php $this->load('Common.baseFooter');?>