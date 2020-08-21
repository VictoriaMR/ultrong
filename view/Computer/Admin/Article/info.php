<?php $this->load('Common.baseHeader');?>
<div class="container-fluid article-page">
	<form class="form-horizontal" method="post" action="<?php echo adminUrl('articleList/add');?>">
		<input type="hidden" name="art_id" value="<?php echo $info['art_id'] ?? 0;?>">
		<div style="width: 500px;">
			<div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>文章标题：</span></div>
	            <textarea type="text" class="form-control" name="name" required="required" maxlength="150"><?php echo $info['name'] ?? '';?></textarea>
	        </div>
	        <?php if (!empty($info)) { ?>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>url显示(英文)：</span></div>
	            <textarea type="text" class="form-control" name="name_en" required="required" maxlength="150"><?php echo $info['name_en'] ?? '';?></textarea>
	        </div>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>文章描述：</span></div>
	            <textarea type="text" class="form-control" name="desc" required="required" maxlength="150"><?php echo $info['desc'] ?? '';?></textarea>
	        </div>
	   		<?php } ?>
	        <?php if (!empty($info)) { ?>
	        <div class="input-group margin-top-15">
	            <div class="input-group-addon"><span>文章状态：</span></div>
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
	            <div class="input-group-addon"><span>文章分类：</span></div>
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
            <div class="input-group-addon"><span>文章图片：</span></div>
            <div class="form-control article-image-content" style="max-width: 1050px; height: auto;">
				<ul data-length="1" data-site="article" data-sort="1" data-delete="1">
					<?php if (!empty($info['image_list'])) { ?>
					<?php foreach ($info['image_list'] as $key => $value) {?>
					<li class="upload-item" data-attach_id="<?php echo $value['attach_id'];?>">
						<img src="<?php echo $value['url'];?>">
					</li>
					<?php } ?>
					<?php } else{ ?>
					<li class="upload-item"></li>
					<?php } ?>
				</ul>
				<input type="hidden" name="image" value="<?php echo $info['image'] ?? '';?>">
				<div class="clear"></div>
			</div>
        </div>
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span>文章详情：</span></div>
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
	if ($('#editor').length > 0) {
		var ue = UE.getEditor('editor');
		ue.ready(function() {
		    ue.execCommand('serverparam', 'site', 'article');
		});
	}
    ARTICLE.init();
});
</script>
<?php $this->load('Common.baseFooter');?>