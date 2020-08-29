<?php $this->load('Common.baseHeader');?>
<div class="margin-top-58">
	<div class="container">
		<div class="crumbs">
			<a href="/"><?php echo dist($_site_name ?? '');?></a>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('productList');?>"><?php echo dist('产品中心');?></a>
			<?php if (!empty($cateName)) { ?>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('productList', ['cate_id' => $info['cate_id']]);?>"><?php echo dist($cateName);?></a>
			<?php } ?>
		</div>
		<?php if (!empty($info)) { ?>
		<?php if (!empty($info['image_list'])) { ?>
		<div class="image-slider">
			<ul class="font-0">
				<?php foreach ($info['image_list'] as $key => $value) { ?>
				<li>
					<a class="block" href="javascript:;">
						<img src="<?php echo str_replace('300x300', '600x600', $value['url']);?>">
					</a>
				</li>
				<?php } ?>
			</ul>
			<div class="clear"></div>
			<?php if (count($info['image_list']) > 1) { ?>
			<ol style="right: calc(50% - 0.06rem*<?php echo count($info['image_list']);?>);">
	            <?php foreach ($info['image_list'] as $key => $value) { ?>
	            <li <?php if($key == 0){ echo 'class="active"'; }?>></li>
	            <?php }?>
	        </ol>
	    	<?php } ?>
		</div>
		<?php } ?>
		<div class="product-name margin-top-20 font-18 font-600"><?php echo $info['name'];?></div>
		<?php if (!empty($info['sale_price'])) {?>
		<div class="product-price font-600 font-18 margin-top-5"><span><?php echo dist('价格');?>:&nbsp;&nbsp;</span><?php echo sprintf('%.2f', $info['sale_price']);?>&nbsp;&nbsp;<span class="color-9"><?php echo dist('元');?></span></div>
		<?php } ?>
		<?php } else { ?>
		<div class="text-center">
			<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
		</div>
		<?php } ?>
	</div>
	<div class="gray-width bg-f5 margin-top-8"></div>
	<?php if (!empty($info['desc'])) { ?>
	<div class="container">
		<div class="item-desc-title font-16"><?php echo dist('描述');?></div>
		<div class="font-14 item-desc-content"><?php echo $info['desc'];?></div>
	</div>
	<?php } ?>
	<div class="gray-width bg-f5 margin-top-8"></div>
	<?php if (!empty($info['content'])) {?>
	<div class="container item-content">
		<?php echo str_replace('800x800', '600x600', $info['content']);?>
	</div>
	<div class="gray-width bg-f5 margin-top-8"></div>
	<?php } ?>
</div>
<script type="text/javascript">
$(function(){
	PRODUCT.init();
});
</script>
<?php $this->load('Common.baseFooter');?>