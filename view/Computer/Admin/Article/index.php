<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<form class="form-inline" method="get" action="<?php echo adminUrl('article');?>">
		<div class="form-group">
			<label>文章ID</label>
			<input type="text" class="form-control" name="art_id" placeholder="文章ID" value="<?php echo $art_id;?>">
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
		<table class="table table-condensed table-hover table-middle margin-top-15" style="border-bottom: 1px solid #ddd;">
	        <tr>
	            <th class="col-md-1 col-1">文章ID</th>
	            <th class="col-md-1 col-1">文章图片</th>
	            <th class="col-md-2 col-2">文章名称</th>
	            <th class="col-md-3 col-3">文章描述</th>
	            <th class="col-md-1 col-1">状态</th>
	            <th class="col-md-2 col-2">操作</th>
	        </tr>
			<?php if (!empty($list)) { ?>
			<?php foreach ($list as $key => $value) { ?>
			<tr>
				<td><?php echo $value['art_id'];?></td>
				<td><?php echo $value['image'];?></td>
				<td><?php echo $value['name'];?></td>
				<td><?php echo $value['desc'];?></td>
				<td>
				<?php if($value['status']){?>
                    <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                <?php }else{?>
                    <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                <?php }?>
				</td>
				<td>
					<a href="<?php echo adminUrl('article/info', ['art_id'=>$value['art_id'], 'lan_id'=>$value['lan_id']]);?>" class="btn btn-primary btn-sm modify-btn" type="button" ><span class="glyphicon glyphicon-edit"></span>&nbsp;修改</a>
                    <button class="btn btn-danger btn-sm delete-btn" type="button" ><span class="glyphicon glyphicon-trash hidden"></span>&nbsp;删除</button>
				</td>
			</tr>
			<?php } ?>
			<?php } else {?>
			<tr>
	    		<td colspan="6" style="text-align: center;"><span style="color: orange;">暂无数据</span></td>
	    	</tr>
			<?php } ?>
		</table>
		<div class="clear"></div>
	</div>
	<?php echo $pageBar ?? '';?>
</div>
<?php $this->load('Common.baseFooter');?>