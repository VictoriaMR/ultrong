	<div id="footer">
		<div class="container">
			<table border="0" width="100%">
				<tr>
					<td width="62%">
						<div class="menu">
							<ul>
								<li>
									<a href="<?php echo url();?>">
										<span><?php echo dist('首页');?></span>
										<span class="separate">|</span>
									</a>
								</li>
								<li>
									<a href="/">
                                    	<span><?php echo dist('关于'.$site_name);?></span>
										<span class="separate">|</span>
									</a>
                                </li>
                                <li>
									<a href="<?php echo url('productList');?>">
                                    	<span><?php echo dist('产品中心');?></span>
										<span class="separate">|</span>
									</a>
                                </li>
                                <li>
									<a href="/">
                                    	<span><?php echo dist('新闻中心');?></span>
										<span class="separate">|</span>
									</a>
                                </li>
                                <li>
									<a href="/">
                                    	<span><?php echo dist('服务支持');?></span>
										<span class="separate">|</span>
									</a>
                                </li>
                                <li>
									<a href="/">
                                    	<span><?php echo dist('解决方案');?></span>
										<span class="separate">|</span>
									</a>
                                </li>
                                <li>
									<a href="/">
                                    	<span><?php echo dist('联系我们');?></span>
									</a>
                                </li>
							</ul>
						</div>
						<div class="site-content">
							<p>&copy;2020-<?php echo date('Y', strtotime('+1 year', strtotime(date('Y-m-d', time()))));?>&nbsp;<?php echo $site['name'];?>&reg;&nbsp;<?php echo dist('版权所有');?></p>
							<?php if (!empty($site['phone'])) { ?>
							<p><?php echo dist('业务咨询');?> :&nbsp;<?php echo $site['phone'];?></p>
							<?php } ?>
							<?php if (!empty($site['email'])) { ?>
							<p><?php echo dist('邮箱');?> :&nbsp;<?php echo $site['email'];?></p>
							<?php } ?>
							<?php if (!empty($site['address'])) { ?>
							<p><?php echo dist('地址');?> :&nbsp;<?php echo $site['address'];?></p>
							<?php } ?>
						</div>
					</td>
					<td width="38%"></td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>