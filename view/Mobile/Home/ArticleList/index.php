<?php $this->load('Common.baseHeader');?>
<div class="margin-top-58">
	<div class="container">
		<div class="crumbs">
			<?php if (!empty($selectedNav)) { 
				$cateName = ''; $cateId= 0;
				foreach ($selectedNav['son'] as $key => $value) { 
					if ($value['selected']) {
						$cateName = $value['name']; $cateId = $value['cate_id'];
						break;
					}
				}
			}?>
			<?php if (!empty($_site_name)) { ?>
			<a href="/"><?php echo $_site_name ?? '';?></a>
			<span>&nbsp;/&nbsp;</span>
			<?php } ?>
			<a href="<?php echo url('articleList', ['cate_id'=>$selectedNav['id']]);?>"><?php echo $selectedNav['name'];?></a>
			<?php if (!empty($cateName)) { ?>
			<span>&nbsp;/&nbsp;</span>
			<a href="<?php echo url('articleList', ['cate_id' => $cateId]);?>"><?php echo $cateName;?></a>
			<?php } ?>
		</div>
		<?php if (!empty($list)) { ?>
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
							<td width="32%" valign="top">
								<div class="image-item table-cell">
									<img src="<?php echo $value['image'];?>">
								</div>
							</td>
							<td width="68%" valign="top">
								<div class="item-info">
									<div class="word-ellipsis-2 font-16 title"><?php echo $value['name'];?></div>
									<?php if (!empty($value['create_at'])){?>
									<div class="color-9 margin-top-3">
										<span><?php echo date('Y-m-d H:i:s', $value['create_at']);?></span>
									</div>
									<?php } ?>
									<div class="color-8 font-14 margin-top-8"><?php echo $value['desc'];?></div>
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
<?php $this->load('Common.baseFooter');?>