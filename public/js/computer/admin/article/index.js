var CATEGORY = {
	init: function()
	{
		var _this = this;
		$('#dealbox').offsetCenter();
		//修改
		$('.modify-btn').on('click', function(event){
			event.stopPropagation();
			_this.initShow($(this).parents('tr').data());
		});
		//新增
	    $('.addroot-btn').on('click', function(event){
	    	event.stopPropagation();
	    	_this.initShow($(this).data());
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
	    	_this.save();
	    	$(this).button('reset');
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
	    //删除
	    $('.delete-btn').on('click', function(event){
	    	event.stopPropagation();
	    	var _thisobj = $(this);
	    	confirm('确定删除吗?', function(){
	    		var cate_id = _thisobj.parents('tr').data('cate_id');
	    		API.post(ADMIN_URI+'articleCategory/delete', { cate_id: cate_id}, function(res) {
	    			if (res.code == 200) {
	    				successTips(res.message);
	    				window.location.reload();
	    			} else {
	    				errorTips(res.message);
	    			}
	    		});
	    	});
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
		$('#dealbox').show();
	},
	save: function ()
	{
    	API.post(ADMIN_URI + 'articleCategory/modify', $('#dealbox form').serializeArray(), function(res){
    		if (res.code == 200) {
    			successTips(res.message);
    			window.location.reload();
    		} else {
    			errorTips(res.message);
    		}
    	});
	}
};