<?php $this->load('Common.baseHeader');?>
<div class="margin-top-58">
	<?php if (!empty($banner['content'])) { ?>
	<div class="image-slider">
		<ul class="font-0">
			<?php foreach ($banner['content'] as $value) { ?>
			<li <?php if (!empty($value['background'])){?>style="background-color: <?php echo $value['background'];?>;" <?php } ?>>
				<a class="block" href="<?php echo !empty($value['href']) ? $value['href'] : 'javascript:;';?>">
					<img src="<?php echo $value['url'];?>">
				</a>
			</li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
		<?php if (count($banner['content']) > 1) { ?>
		<ol>
            <?php foreach ($banner['content'] as $key => $value) { ?>
            <li <?php if($key == 0){ echo 'class="active"'; }?>></li>
            <?php }?>
        </ol>
    	<?php } ?>
	</div>
	<?php } ?>
	<?php if (!empty($cateList)) { ?>
	<div class="margin-top-10">
		<?php foreach ($cateList as $key => $value) { ?>
		<div class="product-list-content">
			<div class="section-title">
				<div class="font-16 left name"><?php echo dist($value['name']);?></div>
				<a href="<?php echo url('productList', ['cate_id'=>$value['cate_id']]);?>" class="right">
					<span class="color-9"><?php echo dist('更多');?></span>
					<i class="iconfont icon-more color-9"></i>
				</a>
				<div class="clear"></div>
			</div>
			<div class="container product-list">
				<ul>
					<?php foreach ($value['product'] as $pk => $pv) {?>
						<li <?php if (($pk+1) % 2 == 0){ ?> style="margin-right: 0;" <?php } ?>>
							<a class="block" href="<?php echo url('product', ['pro_id'=>$pv['pro_id'], 'lan_id' => $pv['lan_id']]);?>">
								<div class="product-img table-cell">
									<img src="<?php echo $pv['image'];?>">
								</div>
								<p class="word-ellipsis-2 font-14 margin-top-8"><?php echo $pv['name'];?></p>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
$(function(){
	INDEX.init();
})
</script>
<?php $this->load('Common.baseFooter');?>