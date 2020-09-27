var ARTICLELIST = {
	init: function()
	{
		//删除
	    $('.delete-btn').on('click', function(event){
	    	event.stopPropagation();
	    	var _thisobj = $(this);
	    	confirm('确定删除吗?', function(){
	    		var art_id = _thisobj.parents('tr').data('art_id');
	    		var lan_id = _thisobj.parents('tr').data('lan_id');
	    		API.post(ADMIN_URI+'article/delete', { art_id: art_id, lan_id: lan_id}, function(res) {
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
	    $('table .switch_botton.status .switch_status').on('click', function() {
	    	var _thisobj = $(this);
	    	var art_id = _thisobj.parents('tr').data('art_id');
	    	var status = _thisobj.hasClass('on') ? 0 : 1;
	    	API.post(ADMIN_URI + 'article/modify', {art_id: art_id, status: status }, function(res) {
    			if (res.code == 200) {
    				successTips(res.message);
    				switch_status(_thisobj, status);
    				_thisobj.parents('tr').data('status', status);
    			} else {
    				errorTips(res.message);
    			}
    		});
	    });
	}
};