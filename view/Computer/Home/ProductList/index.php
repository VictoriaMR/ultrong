<?php $this->load('Common.baseHeader');?>
<div id="product-content" class="bg-f5">
	<div class="container">
		<div class="product-box">
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
				<?php !empty($siteInfo) { ?>
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
					<li <?php if (($key+1) % 3 == 0) { ?>style="margin-right: 0;"<?php } ?>>
						<a class="square product-img" href="<?php echo url('product', ['pro_id'=>$value['pro_id'], 'lan_id' => $value['lan_id']]);?>">
							<img src="<?php echo $value['image'];?>" alt="<?php echo $v['name'];?>">
						</a>
						<a class="word-ellipsis-1 product-title" href="<?php echo url('product', ['pro_id'=>$value['pro_id'], 'lan_id' => $value['lan_id']]);?>"><?php echo $value['name'];?></a>
					</li>
					<?php } ?>
				</ul>
				<div class="clear"> </div>
			</div>
			<?php } else { ?>
			<div class="text-center">
				<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php $this->load('Common.baseFooter');?>