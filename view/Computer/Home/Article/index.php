<?php $this->load('Common.baseHeader');?>
<div class="bg-f5" style="padding: 40px 0;">
	<div class="container">
		<div class="info-box">
			<?php if (!empty($navArr)) { $cateName = '';?>
			<div class="nav-box">
				<ul>
					<?php foreach ($navArr as $key => $value) { 
						if (($value['selected'] ?? false)) {$cateName = $value['name'] ?? '';}
					?>
					<li class="<?php echo ($value['selected'] ?? false) ? 'selected' : '';?>">
						<a class="block" href="<?php echo $value['url'];?>">
							<span><?php echo dist($value['name'] ?? '');?></span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			<div class="nav-title text-right">
				<span><?php echo dist('当前位置');?>:&nbsp;&nbsp;</span>
				<a href="/"><?php echo dist($_site_name ?? '');?></a>
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
			<div style="padding-top: 20px;" id="product-content">
				<div class="text-center font-20 color-6"><?php echo $info['name'];?></div>
				<?php if ($info['fujian']){ ?>
				<?php if (!empty($info['image_list'])) { ?>
				<div class="left product-pic margin-top-20">
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
						<div class="table">
							<a href="javascript:;" class="table-cell text-center">
								<img src="<?php echo str_replace('300x300', '800x800', $info['image_list'][0]['url']);?>">
							</a>
						</div>
					</div>
					<div class="clear"></div>
					<?php if (!empty($info['fujian'])) { ?>
					<div class="model_down margin-top-10">
						<a href="<?php echo url('article/download', ['art_id' => $info['art_id'], 'lan_id'=>$info['lan_id']]);?>">立即下载</a>
						<span class="d1">浏览<i><?php echo $info['hit_count'];?></i></span>
						<span class="d2">下载<i><?php echo $info['download_count'];?></i></span>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
				<?php } else { ?>
				<div class="source color-9 margin-bottom-10">
					<span><?php echo dist('文章来源');?>：<?php echo $_name;?>&nbsp;</span>
					<span><?php echo dist('人气');?>：<?php echo $info['hit_count'];?>&nbsp;</span>
					<span><?php echo dist('发表时间');?>：<?php echo date('Y-m-d', $info['create_at']);?></span>
				</div>
				<?php echo $info['content'] ?? '';?>
				<?php } ?>
			</div>
			<div class="clear"></div>
			<?php if (!empty($recommend)) { ?>
			<div class="article-detail margin-top-20">
                <ul>
                    <li class="selected"><?php echo dist('相关推荐');?></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="recommend-list margin-top-10">
            	<ul>
            		<?php foreach ($recommend as $key => $value) {?>
            		<li class="font-12" <?php if (($key+1)%2 == 0){ ?>style="margin-right: 0;"<?php } ?>>
            			<a href="<?php echo url('article', ['art_id'=>$value['art_id'], 'lan_id'=>$value['lan_id']]);?>"><?php echo $value['name'];?></a>
            			<span class="right color-9"><?php echo date('Y-m-d', $value['create_at']);?></span>
            			<div class="clear"></div>
            		</li>
            		<?php } ?>
            	</ul>
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
<?php $this->load('Common.baseFooter');?>