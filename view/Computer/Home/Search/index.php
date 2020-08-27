<?php $this->load('Common.baseHeader');?>
<div class="bg-f5" style="padding: 40px 0;">
	<div class="container">
		<div class="info-box">
			<div class="nav-box" style="border-bottom: 1px solid #e1e1e1;">
				<form class="text-right" action="<?php echo url('search');?>" method="get">
					<input type="input" class="input inline" name="keyword" value="<?php echo iget('keyword', '');?>" style="max-width: 400px;height: 36px;line-height: 36px;" placeholder="<?php echo dist('请输入关键字');?>">
					<button class="btn inline" type="submit"><?php echo dist('搜索');?></button>
				</form>
			</div>
			<div class="nav-title text-right">
				<span><?php echo dist('当前位置');?>:&nbsp;&nbsp;</span>
				<?php if (!empty($siteInfo)) { ?>
				<a href="/"><?php echo $_site_name ?? '';?></a>
				<span>&nbsp;/&nbsp;</span>
				<?php } ?>
				<a href="<?php echo url('search');?>"><?php echo dist('搜索区域');?></a>
			</div>
			<?php if (!empty($product) || !empty($article)) { ?>
			<?php if (!empty($product)) { ?>
			<ul class="item-list">
			<?php foreach ($product as $key => $value) {?>
				<li>
					<a class="block" href="<?php echo $value['url'];?>">
						<table width="100%" border="0">
							<tr>
								<td width="25%" valign="top">
									<div class="image-item table-cell">
										<img src="<?php echo $value['image'];?>">
									</div>
								</td>
								<td width="75%" valign="top">
									<div class="item-info">
										<div class="word-ellipsis-2 font-18 title"><?php echo $value['name'];?></div>
										<div class="color-9 margin-top-3"><?php echo date('Y-m-d H:i:s', $value['create_at']);?></div>
										<div class="color-8 font-16 margin-top-15"><?php echo $value['desc'];?></div>
										<div class="more"><?php echo dist('查看详情');?> ></a>
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
								<td width="25%" valign="top">
									<div class="image-item table-cell">
										<img src="<?php echo $value['image'];?>">
									</div>
								</td>
								<td width="75%" valign="top">
									<div class="item-info">
										<div class="word-ellipsis-2 font-18 title"><?php echo $value['name'];?></div>
										<div class="color-9 margin-top-3"><?php echo date('Y-m-d H:i:s', $value['create_at']);?></div>
										<div class="color-8 font-16 margin-top-15"><?php echo $value['desc'];?></div>
										<div class="more"><?php echo dist('查看详情');?> ></a>
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
	</div>
</div>
<?php $this->load('Common.baseFooter');?>