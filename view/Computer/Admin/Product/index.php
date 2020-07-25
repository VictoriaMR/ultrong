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
	<div class="content">
		
	</div>
</div>
<?php $this->load('Common.baseFooter');?>