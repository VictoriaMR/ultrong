var MESSAGE = {
	init: function()
	{
		var _this = this;
		$('#dealbox').offsetCenter();
		//修改
		$('.replay-btn').on('click', function(event){
			event.stopPropagation();
			_this.initShow($(this).parents('tr').data());
		});
		//修改
		$('.change-btn').on('click', function(event){
			event.stopPropagation();
			_this.initShow($(this).parents('tr').data());
		});
		//弹窗保存
		$('#dealbox button.save').on('click', function(){
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
	    	if ($(this).hasClass('group')) {
	    		var url = ADMIN_URI + 'message/changge';
	    	} else {
	    		var url = ADMIN_URI + 'message/sendMessage';
	    	}
	    	_this.save(url);
	    	$(this).button('reset');
	    });
	},
	initShow:function (data)
	{	
		$('#dealbox .form-control').each(function(){
			var name = $(this).attr('name');
			if (typeof data[name] == 'undefined') {
				$('#dealbox [name="'+name+'"]').val('');
			} else {
				$('#dealbox [name="'+name+'"]').val(data[name]);
			}
		});
		$('#dealbox').show();
	},
	save: function (url)
	{
    	API.post(url, $('#dealbox form').serializeArray(), function(res){
    		if (res.code == 200) {
    			successTips(res.message);
    			window.location.reload();
    		} else {
    			errorTips(res.message);
    		}
    	});
	}
};