<?php $this->load('header');?>
<div class="margin-top-58">
	<div class="container">
		<div class="crumbs flex" style="line-height: 0.16rem;">
			<a href="/"><?php echo $_site_name ?? '';?></a>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('search');?>"><?php echo dist('搜索');?></a>
			<?php if (!empty(iget('keyword'))) { ?>
			<span>&nbsp;/&nbsp;</span>
			<a class="flex-1 word-ellipsis-1" href="<?php echo url('search', ['keyword' => iget('keyword')]);?>"><?php echo iget('keyword');?></a>
			<?php } ?>
		</div>
		<?php if (!empty($product) || !empty($article)) { ?>
		<?php if (!empty($product)) { ?>
		<ul class="item-list">
		<?php foreach ($product as $key => $value) {?>
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
									<div class="color-8 font-14 margin-top-15"><?php echo $value['desc'];?></div>
								</div>
							</td>
						</tr>
					</table>
				</a>
			</li>
		<?php } ?>
		</ul>
		<?php } ?>
		<?php if (!empty($article)) { ?>
		<ul class="item-list">
		<?php foreach ($article as $key => $value) {?>
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
									<?php if (!empty($value['create_at'])){?>
									<div class="color-9 margin-top-3"><?php echo date('Y-m-d H:i:s', $value['create_at']);?></div>
									<?php } ?>
									<div class="color-8 font-14 margin-top-15"><?php echo $value['desc'];?></div>
								</div>
							</td>
						</tr>
					</table>
				</a>
			</li>
		<?php } ?>
		</ul>
		<?php } ?>
		<?php } else { ?>
		<div class="text-center">
			<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
		</div>
		<?php } ?>
	</div>
	<div class="gray-width bg-f5"></div>
</div>
<?php $this->load('Common.baseFooter');?>
