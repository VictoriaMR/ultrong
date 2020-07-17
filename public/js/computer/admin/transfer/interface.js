var INTERFACE = {
	init: function()
	{
		$('#dealbox').offsetCenter();
		//新增
		$('.add').on('click', function() {
			$('#dealbox').show();
			INTERFACE.initShow();
		});
		//编辑
		$('.modify').on('click', function(){
			$('#dealbox').show();
			INTERFACE.initShow($(this).parents('tr').data());
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
	    	INTERFACE.save();
	    });
	    //删除
	    $('.delete').on('click', function(){
	    	var _thisobj = $(this);

	    	confirm('确定删除吗?', function(){
	    		var tc_id = _thisobj.parents('tr').data('tc_id');
	    		API.post(ADMIN_URI+'Transfer/modifyConfig', {tc_id: tc_id, is_deleted: 1 }, function(res) {
	    			if (res.code == 200) {
	    				successTips(res.message);
	    				window.location.reload();
	    			} else {
	    				errorTips(res.message);
	    			}
	    		});
	    	});
	    });
	    //状态
	    $('.switch_botton.status .switch_status').on('click', function() {
	    	var _thisobj = $(this);
	    	var tc_id = _thisobj.parents('tr').data('tc_id');
	    	var status = _thisobj.hasClass('on') ? 0 : 1;
	    	API.post(ADMIN_URI+'Transfer/modifyConfig', {tc_id: tc_id, status: status }, function(res) {
    			if (res.code == 200) {
    				successTips(res.message);
    				switch_status(_thisobj, status);
    			} else {
    				errorTips(res.message);
    			}
    		});
	    });
	    //检查
	    $('.switch_botton.checked .switch_status').on('click', function() {
	    	var _thisobj = $(this);
	    	var tc_id = _thisobj.parents('tr').data('tc_id');
	    	API.post(ADMIN_URI+'Transfer/checkConfig', {tc_id: tc_id}, function(res) {
    			if (res.code == 200) {
    				successTips(res.message);
    				switch_status(_thisobj, 1);
    			} else {
    				errorTips(res.message);
    				switch_status(_thisobj, 0);
    			}
    		});
	    });
	},
	initShow:function (data)
	{	
		if (!data) {
			data = {
				tran_id: 0,
				name: '',
				status: 1,
				app_id: '',
				app_key: '',
			};
		}
		for (var i in data) {
			$('#dealbox [name="'+i+'"]').val(data[i]);
		}

		if (!data.tran_id) {
			$('#dealbox h3').html('新增接口');
		} else {
			$('#dealbox h3').html('编辑接口');
		}
	},
	save: function ()
	{
		if ($('#dealbox button.save').find('.fa-spinner').length > 0) return false;
	    	$('#dealbox button.save').html($('#dealbox button.save').data('loading-text'));
	    	API.post(ADMIN_URI+'Transfer/saveConfig', $('#dealbox form').serializeArray(), function(res){
	    		$('#dealbox button.save').html('确认');
	    		if (res.code == 200) {
	    			successTips(res.message)
	    			window.location.reload();
	    		} else {
	    			errorTips(res.message);
	    		}
	    	});
	}
};