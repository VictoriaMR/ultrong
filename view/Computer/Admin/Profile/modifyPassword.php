<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<form class="form-horizontal" style="width: 500px;">
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span>新密码：</span></div>
            <input type="text" class="form-control" name="password" required="required" maxlength="30" value="">
        </div>
        <div class="input-group margin-top-15">
            <div class="input-group-addon"><span>确认密码：</span></div>
            <input type="text" class="form-control" name="re_password" required="required" maxlength="30" value="">
        </div>
        <div class="margin-top-15">
            <button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="<span class='glyphicon glyphicon-refresh'></span>">确认</button>
        </div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$('.save').on('click', function(){
		var check = true;
    	$(this).parents('form').find('[required=required]').each(function(){
    		var val = $(this).val();
    		if (val == '') {
    			check = false;
    			var name = $(this).prev().text();
    			errorTips('请将'+name.slice(0, -1)+'填写完整');
    			$(this).focus();
    			return false;
    		}
    	});
    	if (!check) return false;

    	var password = $('[name="password"]').val();
    	var repassword = $('[name="re_password"]').val();

    	if (password != repassword) {
    		errorTips('两次密码不一致');
    		return false;
    	}

    	if (!VERIFY.password(password)) {
    		errorTips('6位以上英文数字组合密码');
    		return false;
    	}

    	API.post(ADMIN_URI+'profile/updatePassword', {password: password, repassword: repassword}, function(res){
    		if (res.code == 200) {
    			successTips(res.message);
    		} else {
    			errorTips(res.message);
    		}
    	});
	});
})
</script>
<?php $this->load('Common.baseFooter');?>