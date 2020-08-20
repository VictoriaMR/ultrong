<div id="footer">
	<div class="container">
		<table border="0" width="100%">
			<tr>
				<td width="62%" valign="top">
					<div class="menu">
						<ul>
							<li>
								<a href="<?php echo url();?>">
									<span><?php echo dist('首页');?></span>
									<span class="separate">|</span>
								</a>
							</li>
							<?php foreach ($nav_list as $key => $value) { ?>
							<li>
								<a href="<?php echo $value['url'];?>">
                                	<span><?php echo $value['name'];?></span>
                                	<?php if ($key < count($nav_list) -1) { ?>
									<span class="separate">|</span>
									<?php } ?>
								</a>
                            </li>
							<?php } ?>
						</ul>
					</div>
					<div class="site-content">
						<p>&copy;2020-<?php echo date('Y', strtotime('+1 year', strtotime(date('Y-m-d', time()))));?>&nbsp;<?php echo dist($site['name']);?>&reg;&nbsp;<?php echo dist('版权所有');?></p>
						<?php if (!empty($site['phone'])) { ?>
						<p><?php echo dist('业务咨询');?> :&nbsp;<?php echo $site['phone'];?></p>
						<?php } ?>
						<?php if (!empty($site['email'])) { ?>
						<p><?php echo dist('邮箱');?> :&nbsp;<?php echo $site['email'];?></p>
						<?php } ?>
						<?php if (!empty($site['address'])) { ?>
						<p><?php echo dist('地址');?> :&nbsp;<?php echo $site['address'];?></p>
						<?php } ?>
						<?php if (!empty($site['ipc'])) { ?>
						<p><?php echo $site['ipc'];?></p>
						<?php } ?>
					</div>
				</td>
				<td width="38%" valign="top">
					<div class="contact margin-left-20">
						<h2><?php echo dist('在线留言');?></h2>
						<form>
					        <input type="text" name="name" placeholder="<?php echo dist('姓名');?>&nbsp;:&nbsp;" class="input" maxlength="100" required="required" data-name="<?php echo dist('姓名');?>">
					        <input type="text" name="tel" placeholder="<?php echo dist('电话');?>&nbsp;:&nbsp;" class="input" maxlength="100" required="required" data-name="<?php echo dist('电话');?>">
					        <input type="text" name="qq" placeholder="<?php echo dist('QQ');?>&nbsp;:&nbsp;" class="input" maxlength="100" required="required" data-name="<?php echo dist('QQ');?>">
					        <input type="text" name="address" placeholder="<?php echo dist('地址');?>&nbsp;:&nbsp;" class="input" maxlength="250" required="required" data-name="<?php echo dist('地址');?>">
					        <textarea name="content" class="textarea" placeholder="<?php echo dist('需求');?>&nbsp;:&nbsp;" maxlength="250" required="required" data-name="<?php echo dist('需求');?>"></textarea>
					        <div class="clear"></div>
					        <button type="button" class="btn right" id="submit"><?php echo dist('立即提交');?></button>
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="goto-top">
	<i class="icon icon-50 icon-to-top"></i>
</div>
<div class="chat">
	<div class="chat_button_bar">
		<div class="favicon">💬</div>
		<div class="title"><?php echo dist('联系我们');?></div>
	</div>
	<div class="chat-content hidden">
		<div class="content-title">
			<span><?php echo dist('客服');?></span>
			<span class="right block close-hide" style="padding: 0 10px;">-</span>
		</div>
		<div id="chat-text-content">
			<p class="text-center">
				<span class="title"><?php echo dist('欢迎您的咨询, 期待为您服务');?></span>
			</p>
		</div>
		<div class="chat-button">
			<div class="left">
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
	FOOTER.init({
		contact_url: "<?php echo url('index/contact');?>",
		empty_text: "<?php echo dist('不能为空');?>",
	});
	CHAT.init({
		contact_url: "<?php echo url('index/sendContact');?>",
		empty_text: "<?php echo dist('不能为空');?>",
		create_url: "<?php echo url('index/createContact');?>",
		list_url: "<?php echo url('index/contactList');?>"
	});
});
</script>
</body>
</html>