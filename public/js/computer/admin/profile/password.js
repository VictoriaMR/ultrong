var PASSWORD = {
	init: function (){
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
	}
};