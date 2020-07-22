var LANGUAGE = {
	init: function()
	{
		$('#dealbox').offsetCenter();
		//默认按钮点击
		$('.default').on('click', function(){
			if ($(this).find('.switch_status').hasClass('on')) return false;
			var id = $(this).parents('tr').data('lan_id');
			var res = LANGUAGE.modify({'lan_id': id, 'is_default': 1});

			if(res.code == 200) {
				successTips(res.message);
				$(this).parents('tr').data('is_default', 1);
				$('.default').each(function(){
					var tempId = $(this).parents('tr').data('lan_id');
					switch_status($(this).find('.switch_status'), tempId == id ? 1 : 0);
				})
			} else {
				errorTips(res.message);
			}
		});
		//状态点击按钮
		$('.status').on('click', function(){
			var id = $(this).parents('tr').data('lan_id');
			var status = $(this).find('.switch_status').hasClass('on') ? 0 : 1;
			var res = LANGUAGE.modify({'lan_id': id, 'status': status});
			if(res.code == 200) {
				successTips(res.message);
				switch_status($(this).find('.switch_status'), status);
				$(this).parents('tr').data('status', status);
			} else {
				errorTips(res.message);
			}
		});
		//编辑框内switch
		$('#dealbox .switch_botton').on('click', function(){
			var status = $(this).find('.switch_status').hasClass('on') ? 0 : 1;
			switch_status($(this).find('.switch_status'), status);
		});
		//修改
		$('.modify').on('click', function(){
			LANGUAGE.initShow($(this).parents('tr').data());
		});
		//新增
		$('.add').on('click', function(){
			LANGUAGE.initShow();
		});
		//保存
		$('#dealbox .save').on('click', function(){
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
	    	LANGUAGE.save();
		});
	},
	modify: function(data)
	{
		return API.post(ADMIN_URI+'language/modify', data);
	},
	initShow:function (data)
	{	
		if (typeof data == 'undefined') data = {};

		$('#dealbox .form-control').each(function(){
			var name = $(this).attr('name');
			if (typeof data[name] == 'undefined') {
				$('#dealbox [name="'+name+'"]').val('');
			} else {
				$('#dealbox [name="'+name+'"]').val(data[name]);
			}
		});
		if (typeof data.status != 'undefined') {
			if (data.status == 0) {
				$('#dealbox [name="status"]').val(0).parents('.input-group').find('.switch_status').removeClass('on').addClass('off');
			} else {
				$('#dealbox [name="status"]').val(1).parents('.input-group').find('.switch_status').removeClass('off').addClass('on');
			}
		}

		if (typeof data.is_default != 'undefined') {
			if (data.is_default == 0) {
				$('#dealbox [name="is_default"]').val(0).parents('.input-group').find('.switch_status').removeClass('on').addClass('off');
			} else {
				$('#dealbox [name="is_default"]').val(1).parents('.input-group').find('.switch_status').removeClass('off').addClass('on');
			}
		} else {
			$('#dealbox [name="is_default"]').val(0).parents('.input-group').find('.switch_status').removeClass('on').addClass('off');
		}

		if (data.lan_id) {
			$('#dealbox h3').text('编辑语言');
		} else {
			$('#dealbox h3').text('新增语言');
		}

		$('#dealbox').show();
	},
	save: function ()
	{
		if ($('#dealbox button.save').find('span').length > 0) return false;
    	$('#dealbox button.save').html($('#dealbox button.save').data('loading-text'));
    	API.post(ADMIN_URI + 'language/update', $('#dealbox form').serializeArray(), function(res){
    		$('#dealbox button.save').html('确认');
    		if (res.code == 200) {
    			successTips(res.message);
    			window.location.reload();
    		} else {
    			errorTips(res.message);
    		}
    	});
	}
};