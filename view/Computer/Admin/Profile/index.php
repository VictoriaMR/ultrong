<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 left">
	        <ul class="list-unstyled">
	            <li class="form-group col-md-12"><b>工号：  </b><span><?php echo $info['mem_id'];?></span></li>
	            <li class="form-group col-md-12"><b>姓名：  </b><span><?php echo $info['name'];?></span></li>
	            <li class="form-group col-md-12"><b>昵称：  </b><span><?php echo $info['nickname'];?></span></li>
	            <li class="form-group col-md-12"><b>手机：  </b><span><?php echo $info['mobile'];?></span></li>
	            <li class="form-group col-md-12"><b>邮箱：  </b><span><?php echo $info['email'];?></span></li>
	            <li class="form-group col-md-12"><b>状态：  </b><span><?php echo $info['status'] ? '启用' : '关闭';?></span></li>
	            <li class="form-group col-md-12"><b>身份：  </b><span><?php echo $info['is_super'] ? '超级管理员' : '普通管理员';?></span></li>
	            <li class="form-group col-md-12"><b>注册时间：  </b><span><?php echo date('Y-m-d H:i:s', $info['create_at']);?></span></li>
	        </ul>
	    </div>
	    <div class="col-md-5 left">
	    	<div class="col-md-2 thumbnail avatar" style="border:solid:1px;width:210px;height:210px;">
                <img src="<?php echo $info['avatar'];?>">
            </div>
	    </div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	UPLOAD.init({
		obj: $('.avatar'),
		single: true,
		site: 'avatar',
		success: function(res){
			if(res.code == 200) {
				$('.avatar').find('img').attr('src', res.data.url);
				PROFILE.updateAvatar(res.data.attach_id);
			} else {
				errorTips(res.message);
			}
		},
		error: function(res){
			errorTips('上传失败');
		}
	});
});
</script>
<?php $this->load('Common.baseFooter');?>