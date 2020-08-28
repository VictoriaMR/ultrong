<?php $this->load('Common.baseHeader');?>
<div class="margin-top-58">
	<div class="container">
		<div class="crumbs">
			<a href="/"><?php echo dist($_site_name ?? '');?></a>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('productList');?>"><?php echo dist('产品中心');?></a>
			<?php if (!empty($cateName)) { ?>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('productList', ['cate_id' => $cate_id]);?>"><?php echo dist($cateName);?></a>
			<?php } ?>
		</div>
		<?php if (!empty($list)) { ?>
		<ul class="item-list">
			<?php foreach ($list as $key => $value) {?>
			<li>
				<a class="block" href="<?php echo $value['url'];?>">
					<table width="100%" border="0">
						<tr>
							<td width="32%" valign="top">
								<div class="image-item table-cell">
									<img src="<?php echo $value['image'];?>">
								</div>
							</td>
							<td width="68%" valign="top">
								<div class="item-info">
									<div class="word-ellipsis-2 font-16 title"><?php echo $value['name'];?></div>
									<?php if (!empty($value['sale_price'])){?>
									<div class="color-9 margin-top-3">
										<span><?php echo dist('价格');?>:</span>
										<span class="font-14 font-600"><?php echo $value['sale_price'];?></span>
										<span><?php echo dist('元');?></span>
									</div>
									<?php } ?>
									<div class="color-8 font-14 margin-top-8"><?php echo $value['desc'];?></div>
								</div>
							</td>
						</tr>
					</table>
				</a>
			</li>
			<?php } ?>
		</ul>
		<?php echo $pageBar;?>
		<?php } else { ?>
		<div class="text-center">
			<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
		</div>
		<?php } ?>
	</div>
</div>
<?php $this->load('Common.baseFooter');?>