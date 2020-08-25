<div id="footer" class="bg-f5">
	<div class="footer-nav">
		<?php $temp = [
				'name' => dist('网站首页'),
				'url' => url(''),
			];
			array_unshift($nav_list, $temp);
			$tempData = array_chunk($nav_list, 4);
		?>
		<?php foreach ($tempData as $key => $value) { ?>
			<ul>
				<?php foreach ($value as $k => $v) { ?>
					<li>
						<a class="block color-white font-14" href="<?php echo $v['url'];?>"><?php echo $v['name'];?></a>
					</li>
				<?php } ?>
			</ul>
			<div class="clear"></div>
		<?php }?>
	</div>
	<p class="margin-top-8 text-center">&copy;2020-<?php echo date('Y', strtotime('+1 year', strtotime(date('Y-m-d', time()))));?>&nbsp;<?php echo dist($site['name']);?>&reg;&nbsp;<?php echo dist('版权所有');?></p>
	<?php if (!empty($site['ipc'])) { ?>
	<p class="margin-top-8 text-center"><?php echo dist($site['ipc']);?></p>
	<?php } ?>
</div>
<div class="chat">
	<div class="chat_button_bar">
		<div class="favicon">💬</div>
		<div class="title color-white"><?php echo dist('联系我们');?></div>
	</div>
	<div class="chat-content hidden">
		<div class="content-title">
			<span class="color-white"><?php echo dist('客服');?></span>
			<span class="right block close-hide color-white" style="padding: 0 10px;">-</span>
		</div>
		<div id="chat-text-content">
			<p class="text-center">
				<span class="title color-9"><?php echo dist('欢迎您的咨询, 期待为您服务');?></span>
			</p>
		</div>
		<div class="chat-button flex">
			<div class="left flex-1 margin-right-10">
				<input type="input" class="input" name="chat" />
			</div>
			<div class="right" style="margin-right: 5px;">
				<button class="btn"><?php echo dist('发送');?></button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	CHAT.init({
		contact_url: "<?php echo url('index/sendContact');?>",
		empty_text: "<?php echo dist('不能为空');?>",
		create_url: "<?php echo url('index/createContact');?>",
		list_url: "<?php echo url('index/contactList');?>",
		count_url: "<?php echo url('index/unread');?>",
	});
});
</script>
</body>
</html>