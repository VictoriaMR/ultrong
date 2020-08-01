var TRANSFER = {
	init: function() 
	{
		$('#dealbox').offsetCenter();
		$('.modify').on('click', function(){
			$('#dealbox').show();
			TRANSFER.initShow($(this).parents('tr').data());
		});
		$('#dealbox button.save').on('click', function(){
	    	var check = true;
	    	$(this).parents('form').find('[required=required]').each(function(){
	    		var val = $(this).val();
	    		if (val == '') {
	    			check = false;
	    			var name = $(this).prev().text();
	    			POP.tips('请将'+name.slice(0, -1)+'填写完整');
	    			$(this).focus();
	    			return false;
	    		}
	    	});
	    	if (!check) return false;
	    	$(this).button('loading');
	    	TRANSFER.save();
	    	$(this).button('reset');
	    });
	    //重构缓存
	    $('.reload-cache').on('click', function(){
	    	$(this).button('loading');
	    	API.post(ADMIN_URI+'transfer/reloadCache', {}, function(res){
	    		if (res.code == 200) {
	    			successTips(res.message);
	    		} else {
	    			errorTips(res.message);
	    		}
	    	});
	    	$(this).button('reset');
	    })
	},
	initShow:function (data)
	{	
		for (var i in data) {
			$('#dealbox [name="'+i+'"]').val(data[i]);
		}
	},
	save: function ()
	{
    	API.post(ADMIN_URI+'transfer/modify', $('#dealbox form').serializeArray(), function(res){
    		$('#dealbox button.save').html('确认');
    		if (res.code == 200) {
    			window.location.reload();
    		} else {
    			POP.tips(res.message);
    		}
    	});
    	return true;
	}
};