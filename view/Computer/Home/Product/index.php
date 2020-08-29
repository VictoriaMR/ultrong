<?php $this->load('Common.baseHeader');?>
<div id="product-content" class="bg-f5">
	<div class="container">
		<div class="info-box">
			<?php if (!empty($selectedNav)) { $cateName = '';?>
			<div class="nav-box">
				<ul>
					<?php foreach ($selectedNav['son'] as $key => $value) { 
						if ($info['cate_id'] == $value['cate_id']) {$cateName = $value['name'];}
					?>
					<li class="<?php echo $info['cate_id'] == $value['cate_id'] ? 'selected' : '';?>">
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
				<a href="/"><?php echo dist($_site_name ?? '');?></a>
				<span>&nbsp;/&nbsp;</span>
				<a href="<?php echo url('productList');?>"><?php echo dist('产品中心');?></a>
				<?php if (!empty($cateName)) { ?>
				<span>&nbsp;/&nbsp;</span>
				<a href="<?php echo url('productList', ['cate_id' => $info['cate_id']]);?>"><?php echo dist($cateName);?></a>
				<?php } ?>
			</div>
			<?php if (!empty($info)) { ?>
			<div class="product-info padding-top-10">
				<?php if (!empty($info['image_list'])) { ?>
				<div class="left product-pic">
					<div class="left pic-left">
						<ul>
							<?php foreach ($info['image_list'] as $key => $value) { ?>
							<li class="<?php echo $key == 0 ? 'selected' : '';?>">
								<a href="javascript:;" class="block">
									<img src="<?php echo $value['url'];?>" />
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
					<div class="left pic-right">
						<a href="javascript:;" class="table-cell text-center">
							<img src="<?php echo str_replace('300x300', '800x800', $info['image_list'][0]['url']);?>">
						</a>
					</div>
				</div>
				<?php } ?>
				<div class="left product-name">
					<h2 class="title"><?php echo $info['name'];?></h2>
					<?php if (!empty($info['sale_price'])) { ?>
					<div class="font-600 margin-bottom-10">
						<span><?php echo dist('价格');?>:&nbsp;</span>
						<span class="font-24"><?php echo $info['sale_price'];?></span>
						<span>&nbsp;<?php echo dist('元');?></span>
					</div>
					<?php } ?>
					<div class="dashed"></div>
					<div class="description">
						<div><?php echo dist('产品简介');?>:</div>
						<div class="font-16 color-9 desc"><?php echo $info['desc'];?></div>
					</div>
					<?php if (!empty($site['phone'])) { ?>
					<div class="dashed"></div>
					<div class="contact">
						<div class="tel">
							<p><?php echo dist('全国服务热线');?></p>
							<p class="phone"><?php echo $site['phone'];?></p>
						</div>
					</div>
					<div class="margin-top-20">
						<a class="btn btn-blue" href="javascript:;"><?php echo dist('联系我们');?></a>
					</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
				<div class="product-detail margin-top-20">
                    <ul>
                        <li class="selected"><?php echo dist('产品描述');?></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="margin-top-15 text-center">
                	<?php echo $info['content'];?>
                </div>
			</div>
			<?php if (!empty($recommend)) { ?>
			<div class="product-detail margin-top-20">
                <ul>
                    <li class="selected"><?php echo dist('相关推荐');?></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="recommend-content product-list padding-top-10">
            	<ul>
					<?php foreach ($recommend as $key => $value) {?>
					<li <?php if (($key+1) % 4 == 0) { ?>style="margin-right: 0;"<?php } ?>>
						<a class="square product-img" href="<?php echo url('product', ['pro_id'=>$value['pro_id'], 'lan_id' => $value['lan_id']]);?>">
							<img src="<?php echo $value['image'];?>" alt="<?php echo $value['name'] ?? '';?>">
						</a>
						<a class="word-ellipsis-1 product-title" href="<?php echo url('product', ['pro_id'=>$value['pro_id'], 'lan_id' => $value['lan_id']]);?>"><?php echo $value['name'];?></a>
					</li>
					<?php } ?>
            	</ul>
            	<div class="clear"></div>
            </div>
        	<?php } ?>
			<?php } else { ?>
			<div class="text-center">
				<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	PRODUCT.init();
})
</script>
<?php $this->load('Common.baseFooter');?>