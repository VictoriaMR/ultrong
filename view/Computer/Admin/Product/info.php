<?php $this->load('Common.baseHeader');?>
<div class="container-fluid product-page">
	<form class="form-horizontal" method="post" action="<?php echo adminUrl('product/add');?>">
		<input type="hidden" name="pro_id" value="<?php echo $info['pro_id'] ?? 0;?>">
		<div style="width: 500px;">
			<div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>商品名称：</span></div>
	            <textarea type="text" class="form-control" name="name" required="required" maxlength="150"><?php echo $info['name'] ?? '';?></textarea>
	        </div>
	        <?php if (!empty($info)) { ?>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>商品描述：</span></div>
	            <textarea type="text" class="form-control" name="desc" required="required" maxlength="150"><?php echo $info['desc'] ?? '';?></textarea>
	        </div>
	   		<?php } ?>
			<div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>商品号码：</span></div>
	            <input type="text" class="form-control" name="no" value="<?php echo $info['no'] ?? '';?>" maxlength="30"/>
	        </div>
	        <?php if (!empty($info)) { ?>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>商品状态：</span></div>
	            <div style="padding: 1px 0 1px 15px;border-left: 1px solid #ccc;">
		            <?php if($info['status']){?>
	                <div class="switch_botton" data-status="1">
	                	<div class="switch_status on"></div>
	                </div>
	                <?php } else {?>
	                <div class="switch_botton" data-status="0">
	                	<div class="switch_status off"></div>
	                </div>
	                <?php }?>
	                <input type="hidden" name="status" value="<?php echo $info['status'] ?? 0;?>">
	            </div>
	        </div>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>是否热门：</span></div>
	            <div style="padding: 1px 0 1px 15px;border-left: 1px solid #ccc;">
		            <?php if($info['is_hot']){?>
	                <div class="switch_botton" data-status="1">
	                	<div class="switch_status on"></div>
	                </div>
	                <?php } else {?>
	                <div class="switch_botton" data-status="0">
	                	<div class="switch_status off"></div>
	                </div>
	                <?php }?>
	                <input type="hidden" name="is_hot" value="<?php echo $info['is_hot'] ?? 0;?>">
	            </div>
	        </div>
	   		<?php } ?>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>语言：</span></div>
	            <select class="form-control" name="lan_id">
	            	<?php foreach ($lanList as $key => $value) { ?>
	            	<option value="<?php echo $value['lan_id'];?>" <?php echo ($info['lan_id'] ?? 0) == $value['lan_id'] ? 'selected' : '';?>><?php echo $value['name'];?></option>
	            	<?php } ?>
	            </select>
	        </div>
	        <?php if (!empty($info)) { ?>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>商品分类：</span></div>
	            <select class="form-control" name="cate_id">
	            	<?php foreach ($cateList as $key => $value) { ?>
	            	<option value="<?php echo $value['cate_id'];?>" <?php echo ($info['cate_id'] ?? 0) == $value['cate_id'] ? 'selected' : '';?>><?php echo $value['name'];?></option>
	            	<?php } ?>
	            </select>
	        </div>
	    	<?php } ?>
	    	<?php if (empty($info)){ ?>
	    	<div class="margin-top-15" style="width: 100px;">
	    	 	<button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="loading..">下一步</button>
	    	</div>
	    	<?php } ?>
		</div>
		<?php if (!empty($info)){ ?>
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span>商品图片：</span></div>
            <div class="form-control product-image-content" style="max-width: 1050px; height: auto;">
				<ul data-length="10" data-site="product" data-sort="1" data-delete="1">
					<?php if (!empty($info['image_list'])) { ?>
					<?php foreach ($info['image_list'] as $key => $value) {?>
					<li class="upload-item" data-attach_id="<?php echo $value['attach_id'];?>">
						<img src="<?php echo $value['url'];?>">
					</li>
					<?php } ?>
					<?php } ?>
					<?php if(count($info['image_list'] ?? []) < 10) { ?>
					<li class="upload-item"></li>
					<?php } ?>
				</ul>
				<input type="hidden" name="image" value="<?php echo $info['image'] ?? '';?>">
				<div class="clear"></div>
			</div>
        </div>
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span>商品详情：</span></div>
            <div class="form-control" style="width:1050px;height: auto;">
				<script id="editor" type="text/plain" name="content" style="width:1024px;height:500px;"><?php echo $info['content'] ?? '';?></script>
			</div>
        </div>
        <div class="margin-top-15" style="width: 200px;margin-bottom: 100px;">
    	 	<button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="loading..">保存</button>
    	</div>
    	<?php } ?>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	if ($('#editor').length > 0)
		UE.getEditor('editor');
    PRODUCT.init();
});
</script>
<?php $this->load('Common.baseFooter');?>