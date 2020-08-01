<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<form class="form-inline" method="get" action="<?php echo adminUrl('product');?>">
		<div class="form-group">
			<label>SPU</label>
			<input type="text" class="form-control" name="spu_id" placeholder="SPU ID" value="<?php echo $spu_id;?>">
		</div>
		<div class="form-group">
			<label>关键字</label>
			<input type="text" class="form-control" name="keyword" placeholder="关键字搜索" value="<?php echo $keyword;?>">
		</div>
		<div class="form-group">
			<label>分类</label>
			<select name="cate_id" class="form-control" style="width: 180px;">
				<option value="">请选择</option>
				<?php foreach ($cateList as $key => $value) { ?>
				<option value="<?php echo $value['cate_id'];?>" <?php echo $cate_id == $value['cate_id'] ? 'selected' : '';?>><?php echo $value['name'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label>语言</label>
			<select name="lan_id" class="form-control" style="width: 180px;">
				<option value="">请选择</option>
				<?php foreach ($lanList as $key => $value) { ?>
				<option value="<?php echo $value['lan_id'];?>" <?php echo $lan_id == $value['lan_id'] ? 'selected' : '';?>><?php echo $value['name'];?></option>
				<?php } ?>
			</select>
		</div>
		<button type="submit" class="btn btn-primary">查询</button>
	</form>
	<div class="product-content" style="min-height: 700px;">
		<?php if (!empty($list)) { ?>
		<ul>
			<?php foreach ($list as $key => $value) { ?>
			<li data-pro_id="<?php echo $value['pro_id'];?>" data-lan_id="<?php echo $value['lan_id'];?>">
				<a class="image-item" href="<?php echo adminUrl('product/info', ['pro_id'=>$value['pro_id'], 'lan_id'=>$value['lan_id']]);?>">
			      	<img src="<?php echo $value['image'];?>">
			    </a>
				<a class="info-content" href="<?php echo adminUrl('product/info', ['pro_id'=>$value['pro_id'], 'lan_id'=>$value['lan_id']]);?>">
					<div>
						<label style="margin-bottom: 0;">语言: </label>
						<span><?php echo $value['language_name'];?></span>
					</div>
					<div>
						<label style="margin-bottom: 0;">分类: </label>
						<span><?php echo $value['cate_name'];?></span>
					</div>
					<div class="word-ellipsis-1">
						<span><?php echo $value['name'];?></span>
					</div>
				</a>
				<span class="glyphicon glyphicon-trash delete-btn"></span>
			</li>
			<?php } ?>
		</ul>
		<div class="clear"></div>
		<?php } ?>
	</div>
	<?php echo $pageBar ?? '';?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    PRODUCT.init();
});
</script>
<?php $this->load('Common.baseFooter');?>