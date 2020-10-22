<?php $this->load('Common.baseHeader');?>
<div class="margin-top-58">
	<div class="container">
		<div class="crumbs">
			<?php if (!empty($navArr)) { 
				$cateName = '';
				foreach ($navArr as $key => $value) { 
					if (($value['selected'] ?? false)) {
						$cateName = $value['name'] ?? '';
					}
				}
			} ?>
			<a href="/"><?php echo $_site_name ?? '';?></a>
			<?php if (!empty($selected_parent_id)) { ?>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('articleList', ['cate_id' => $selected_parent_id]);?>"><?php echo $selected_parent_name;?></a>
			<?php } ?>
			<?php if (!empty($cateName)) { ?>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('articleList', ['cate_id' => $info['cate_id']]);?>"><?php echo $cateName;?></a>
			<?php } ?>
		</div>
		<?php if (!empty($info)) { ?>
		<?php if (!empty($info['image_list'])) { ?>
		<div class="image-slider">
			<ul class="font-0">
				<?php foreach ($info['image_list'] as $key => $value) { ?>
				<li>
					<a class="block" href="javascript:;">
						<img src="<?php echo $value['url'];?>">
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
		<div style="padding-top: 20px;">
			<div class="text-center font-20 color-6"><?php echo $info['name'];?></div>
			<div class="source color-9 margin-top-10">
				<span><?php echo dist('文章来源');?>：<?php echo $_name;?>&nbsp;</span>
				<span><?php echo dist('发表时间');?>：<?php echo date('Y-m-d', $info['create_at']);?></span>
			</div>
			<?php if (!empty($info['fujian'])) { ?>
			<div class="model_down margin-top-10">
				<a href="<?php echo url('article/download', ['art_id' => $info['art_id'], 'lan_id'=>$info['lan_id']]);?>">立即下载</a>
				<span class="d1">浏览<i><?php echo $info['hit_count'];?></i></span>
				<span class="d2">下载<i><?php echo $info['download_count'];?></i></span>
			</div>
			<?php } ?>
			<div class="margin-top-10">
				<?php echo $info['content'] ?? '';?>
			</div>
		</div>
		<?php } else { ?>
		<div class="text-center">
			<img src="<?php echo siteUrl('image/computer/empty.png');?>" />
		</div>
		<?php } ?>
	</div>
	<div class="gray-width bg-f5 margin-top-8"></div>
</div>
<?php $this->load('Common.baseFooter');?>