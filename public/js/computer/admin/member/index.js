var ADMINMEMBER = {
	init: function()
	{
		$('#dealbox').offsetCenter();
		$('.add').on('click', function() {
			ADMINMEMBER.initShow();
		});
		//保存
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
	    	ADMINMEMBER.save();
	    	(this).button('reset');
	    });
	    $('.modify').on('click', function(){
	    	ADMINMEMBER.initShow($(this).parents('tr').data());
	    });
	    //编辑框状态按钮
	    $('#dealbox .switch_botton').on('click', function(){
			var status = $(this).find('.switch_status').hasClass('on') ? 0 : 1;
			switch_status($(this).find('.switch_status'), status);
			$(this).parents('.form-control').find('input').val(status);
		});
		//状态点击按钮
		$('.status').on('click', function(){
			var id = $(this).parents('tr').data('mem_id');
			var status = $(this).find('.switch_status').hasClass('on') ? 0 : 1;
			var res = API.post(ADMIN_URI+'adminMember/modify', {mem_id: id, status: status});
			if(res.code == 200) {
				successTips(res.message);
				switch_status($(this).find('.switch_status'), status);
			} else {
				errorTips(res.message);
			}
		});
		//is_super点击按钮
		$('.is_super').on('click', function(){
			var id = $(this).parents('tr').data('mem_id');
			var status = $(this).find('.switch_status').hasClass('on') ? 0 : 1;
			var res = API.post(ADMIN_URI+'adminMember/modify', {mem_id: id, is_super: status});
			if(res.code == 200) {
				successTips(res.message);
				switch_status($(this).find('.switch_status'), status);
			} else {
				errorTips(res.message);
			}
		});
	},
	initShow:function (data)
	{	
		if (!data) {
			data = {
				mem_id: 0,
				name: '',
				nickname: '',
				status: 1,
				is_default: '',
				password: '',
			};
		}
		for (var i in data) {
			$('#dealbox [name="'+i+'"]').val(data[i]);
		}

		if (typeof data.status != 'undefined') {
			if (data.status == 0) {
				$('#dealbox [name="status"]').val(0).parents('.input-group').find('.switch_status').removeClass('on').addClass('off');
			} else {
				$('#dealbox [name="status"]').val(1).parents('.input-group').find('.switch_status').removeClass('off').addClass('on');
			}
		}

		if (typeof data.is_super != 'undefined') {
			if (data.is_super == 0) {
				$('#dealbox [name="is_super"]').val(0).parents('.input-group').find('.switch_status').removeClass('on').addClass('off');
			} else {
				$('#dealbox [name="is_super"]').val(1).parents('.input-group').find('.switch_status').removeClass('off').addClass('on');
			}
		}

		if (!data.mem_id) {
			$('#dealbox h3').html('新增管理员');
		} else {
			$('#dealbox h3').html('编辑管理员');
		}

		$('#dealbox').show();
	},
	save: function ()
	{
    	API.post(ADMIN_URI+'adminMember/add', $('#dealbox form').serializeArray(), function(res){
    		if (res.code == 200) {
    			successTips(res.message)
    			window.location.reload();
    		} else {
    			errorTips(res.message);
    		}
    	});
	}
};