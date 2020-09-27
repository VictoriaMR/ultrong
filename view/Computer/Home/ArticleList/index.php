<?php $this->load('Common.baseHeader');?>
<div class="bg-f5" style="padding: 40px 0;">
	<div class="container">
		<div class="info-box">
			<?php if (!empty($selectedNav)) { $cateName = ''; $cateId= 0;?>
			<div class="nav-box">
				<ul>
					<?php foreach ($selectedNav['son'] as $key => $value) { 
						if ($value['selected']) {$cateName = $value['name']; $cateId = $value['cate_id'];}
					?>
					<li class="<?php echo $value['selected'] ? 'selected' : '';?>">
						<a class="block" href="<?php echo $value['url'];?>">
							<span><?php echo dist($value['name']);?></span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<?php } ?>
			<div class="nav-title text-right">
				<span><?php echo dist('当前位置');?>:&nbsp;&nbsp;</span>
				<a href="/"><?php echo $_site_name ?? '';?></a>
				<span>&nbsp;/&nbsp;</span>
				<a href="<?php echo url('articleList', ['cate_id'=>$selectedNav['id']]);?>"><?php echo $selectedNav['name'];?></a>
				<?php if (!empty($cateName)) { ?>
				<span>&nbsp;/&nbsp;</span>
				<a href="<?php echo url('articleList', ['cate_id' => $cateId]);?>"><?php echo dist($cateName);?></a>
				<?php } ?>
			</div>
			<?php if (!empty($info)) { ?>
			<div style="padding-top: 20px;">
				<div class="text-center font-20 color-6"><?php echo $info['name'];?></div>
				<div class="source color-9 margin-bottom-10">
					<span><?php echo dist('文章来源');?>：<?php echo $_name;?></span>
					<span>&nbsp;&nbsp;&nbsp;<?php echo dist('人气');?>：<?php echo $info['hit_count'];?></span>
					<span>&nbsp;&nbsp;&nbsp;<?php echo dist('发表时间');?>：<?php echo date('Y-m-d H:i:s', $info['create_at']);?></span>
				</div>
				<?php echo $info['content'] ?? '';?>
			</div>
			<?php if (!empty($recommend)) { ?>
			<div class="item-detail margin-top-20">
                <ul>
                    <li class="selected"><?php echo dist('相关推荐');?></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div class="recommend-list margin-top-10">
            	<ul>
            		<?php foreach ($recommend as $key => $value) {?>
            		<li class="font-12" <?php if (($key+1)%2 == 0){ ?>style="margin-right: 0;"<?php } ?>>
            			<a href="<?php echo $value['url'];?>"><?php echo $value['name'];?></a>
            			<span class="right color-9"><?php echo date('Y-m-d', $value['create_at']);?></span>
            			<div class="clear"></div>
            		</li>
            		<?php } ?>
            	</ul>
            </div>
        	<?php } ?>
			<?php } else if (!empty($list)) { ?>
			<ul class="item-list">
			<?php foreach ($list as $key => $value) {?>
				<?php if ($is_fujian) { ?>
				<li style="border-bottom: 1px dotted #e0e0e0;padding: 10px 0;">
					<a class="block flex" target="_blank" href="<?php echo $value['fujian'] ? media('fujian/'.$value['fujian']) : 'javascript:;';?>">
						<img class="margin-right-20" src="<?php echo siteUrl('image/computer/downa.png');?>">
						<div class="word-ellipsis-2 font-16 title"><?php echo $value['name'];?></div>
						<div style="margin-left:auto;"> 下载次数：<?php echo $value['hit_count'];?> </div>
					</a>
				</li>
				<?php } else { ?>
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
										<div class="word-ellipsis-2 font-16 title"><?php echo $value['name'];?></div>
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
			<?php } ?>
			</ul>
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