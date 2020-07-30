<?php $this->load('Common.baseHeader');?>
<div id="product-content" class="bg-f5">
	<div class="container">
		<div class="product-box">
			<?php if (!empty($cateList)) { $cateName = '';?>
			<div class="nav-box">
				<ul>
					<?php foreach ($cateList as $key => $value) { 
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
						<?php if (!empty($info['image_list'])) { ?>
						<ul>
							<?php foreach ($info['image_list'] as $key => $value) { ?>
							<li class="table <?php echo $key == 0 ? 'selected' : '';?>">
								<a href="javascript:;" class="table-cell">
									<img src="<?php echo $value['url'];?>" />
								</a>
							</li>
							<?php } ?>
						</ul>
						<?php } ?>
					</div>
					<div class="left pic-right table">
						<a href="javascript:;" class="table-cell">
							<img src="<?php echo $info['image_list'][0]['url'];?>">
						</a>
					</div>
				</div>
				<?php } ?>
				<div class="left product-name">
					<h2 class="title"><?php echo $info['name'];?></h2>
					<div class="dashed"></div>
					<div class="description">
						<div><?php echo dist('产品简介');?>:</div>
						<div class="font-16 color-9 desc"><?php echo $info['desc'];?></div>
					</div>
				</div>
				<div class="clear"></div>
				<div class="product-detail margin-top-20">
                    <ul>
                        <li class="selected">产品描述</li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="margin-top-15 text-center">
                	<?php echo $info['content'];?>
                </div>
			</div>
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