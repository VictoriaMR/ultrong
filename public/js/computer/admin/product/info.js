var PRODUCT = {
	init: function()
	{
		var _this = this;
		UPLOAD.init({
			obj: $('.product-image-content .upload-item'),
			success: function(res){
				if(res.code == 200) {
					$('.avatar').find('img').attr('src', res.data.url);
				} else {
					errorTips(res.message);
				}
			},
			error: function(res){
				errorTips('上传失败');
			}
		});
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
			$(this).button('loading');
			_this.initImage();
			_this.save($(this).parents('form').serializeArray());
		});
		//编辑框开关切换
	    $('.switch_status').on('click', function(){
	    	var _thisobj = $(this);
	    	var status = _thisobj.hasClass('on') ? 0 : 1;
	    	switch_status(_thisobj, status);
	    	_thisobj.parents('.input-group').find('input').val(status);
	    });
	},
	initImage: function()
	{
		var img = [];
		$('.upload-item').each(function(){
			var id = $(this).data('attach_id');
			if (id)
				img.push(id);
		});

		$('input[name="image"]').val(img.join(','));
	},
	save: function(data)
	{
		API.post(ADMIN_URI + 'product/save', data, function(res){
			if (res.code == 200) {
				successTips(res.message);
				window.location.href = res.data.url;
			} else {
				errorTips(res.message);
			}
		});
	}
};