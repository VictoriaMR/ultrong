<?php $this->load('Common.baseHeader');?>
<div id="product-content" class="bg-f5">
	<div class="container">
		<div class="info-box">
			<?php if (!empty($cateList)) { $cateName = '';?>
			<div class="nav-box">
				<ul>
					<?php foreach ($cateList as $key => $value) { 
						if ($cate_id == $value['cate_id']) {$cateName = $value['name'];}
					?>
					<li class="<?php echo $cate_id == $value['cate_id'] ? 'selected' : '';?>">
						<a class="block" href="<?php echo url('productList', ['cate_id' => $value['cate_id']]);?>">
							<span><?php echo dist($value['name']);?></span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			<div class="nav-title text-right">
				<span><?php echo dist('当前位置');?>:&nbsp;&nbsp;</span>
				<?php if (!empty($_site_name)) { ?>
				<a href="/"><?php echo $_site_name ?? '';?></a>
				<span>&nbsp;/&nbsp;</span>
				<?php } ?>
				<a href="<?php echo url('productList');?>"><?php echo dist('产品中心');?></a>
				<?php if (!empty($cateName)) { ?>
				<span>&nbsp;/&nbsp;</span>
				<a href="<?php echo url('productList', ['cate_id' => $cate_id]);?>"><?php echo dist($cateName);?></a>
				<?php } ?>
			</div>
			<?php if (!empty($list)) { ?>
			<div class="product-list padding-top-10">
				<ul>
					<?php foreach ($list as $key => $value) {?>
					<li <?php if (($key+1) % 4 == 0) { ?>style="margin-right: 0;"<?php } ?>>
						<a class="square product-img" href="<?php echo 
						$value['url'];?>">
							<img src="<?php echo $value['image'];?>" alt="<?php echo $value['name'] ?? '';?>">
						</a>
						<a class="font-16 text-center" href="<?php echo url('product', ['pro_id'=>$value['pro_id'], 'lan_id' => $value['lan_id']]);?>">
							<div class="word-ellipsis-2"><?php echo $value['name'];?></div>
							<?php if (!empty($value['sale_price'])) { ?>
                            <div class="text-right">
                                <span class="font-14 color-9"><?php echo dist('价格');?>:&nbsp;</span>
                                <span class="font-16 font-600 color-blue"><?php echo $value['sale_price'];?></span>
                                <span class="font-14 color-9">&nbsp;<?php echo dist('元');?></span>
                            </div>
                            <?php } ?>
						</a>
					</li>
					<?php } ?>
				</ul>
				<div class="clear"></div>
			</div>
			<?php echo $pageBar;?>
			<?php } else { ?>
			<div class="text-center">
				<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php $this->load('Common.baseFooter');?>