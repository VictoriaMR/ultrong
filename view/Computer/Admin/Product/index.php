<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<form class="form-inline" method="get" action="<?php echo adminUrl('product');?>">
		<div class="col-md-2">
			<div class="form-group">
				<label>SPU ID</label>
				<input type="text" class="form-control" name="spu_id" placeholder="SPU ID" value="<?php echo $spu_id;?>">
			</div>
			
		</div>
		<div class="form-group col-md-2">
			<label>关键字</label>
			<input type="text" class="form-control" name="keyword" placeholder="请输入关键字..." value="<?php echo $keyword;?>">
		</div>
		<div class="form-group col-md-2">
			<label>语言</label>
			<select class="form-control" name="lan_id">
				<option></option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary">查找</button>
	</form>
</div>
<?php $this->load('Common.baseFooter');?>