var FEATURE = {
	init: function() 
	{
		var _this = this;
		$('#dealbox').offsetCenter();
		$('.modify').on('click', function(event){
			event.stopPropagation();
			_this.initShow($(this).parents('tr').data());
		});
		//弹窗保存
		$('#dealbox button.save').on('click', function(event){
			event.stopPropagation();
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
	    	_this.save();
	    	$(this).button('reset');
	    });
	    //状态
	    $('table .switch_botton.status .switch_status').on('click', function(event) {
	    	var _thisobj = $(this);
	    	var con_id = _thisobj.parents('tr').data('con_id');
	    	var status = _thisobj.hasClass('on') ? 0 : 1;
	    	API.post(ADMIN_URI + 'feature/modify', {con_id: con_id, status: status }, function(res) {
    			if (res.code == 200) {
    				successTips(res.message);
    				switch_status(_thisobj, status);
    				_thisobj.parents('tr').data('status', status);
    			} else {
    				errorTips(res.message);
    			}
    		});
    		event.stopPropagation();
	    });
	    //编辑框开关切换
	    $('#dealbox .switch_status').on('click', function(){
	    	var _thisobj = $(this);
	    	var status = _thisobj.hasClass('on') ? 0 : 1;
	    	switch_status(_thisobj, status);
	    	_thisobj.parents('.form-control').find('input').val(status);
	    });
	    //删除
	    $('.delete-btn').on('click', function(event){
	    	event.stopPropagation();
	    	var _thisobj = $(this);
	    	confirm('确定删除吗?', function(){
	    		var con_id = _thisobj.parents('tr').data('con_id');
	    		API.post(ADMIN_URI+'feature/delete', { con_id: con_id}, function(res) {
	    			if (res.code == 200) {
	    				successTips(res.message);
	    				window.location.reload();
	    			} else {
	    				errorTips(res.message);
	    			}
	    		});
	    	});
	    });
	    //新增
	    $('.addroot').on('click', function(event){
	    	event.stopPropagation();
	    	_this.initShow($(this).data());
	    });
	    //点击全部展开/收起
	    $('.all-open').on('click', function(){
	    	$('tr').show();
	    });
	    $('.all-close').on('click', function(){
	    	$('tr.son').hide();
	    });
	    $('tr.parent').on('click', function(){
	    	if ($(this).next().hasClass('son')) {
	    		if ($(this).next().is(':visible')) {
	    			$(this).nextUntil('.parent').hide();
	    		} else {
	    			$(this).nextUntil('.parent').show();
	    		}
	    	}
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
		if (typeof data.status != 'undefined') {
			if (data.status == 0) {
				$('#dealbox [name="status"]').val(0).parents('.input-group').find('.switch_status').removeClass('on').addClass('off');
			} else {
				$('#dealbox [name="status"]').val(1).parents('.input-group').find('.switch_status').removeClass('off').addClass('on');
			}
		}

		if (data.parent_id) {
			$('#dealbox [name="icon"]').parents('.input-group').hide();
		} else {
			$('#dealbox [name="icon"]').parents('.input-group').show();
		}
		$('#dealbox').show();
	},
	save: function ()
	{
    	API.post(ADMIN_URI + 'feature/modify', $('#dealbox form').serializeArray(), function(res){
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