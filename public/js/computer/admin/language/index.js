var LANGUAGE = {
	init: function()
	{
		$('.default').on('click', function(){
			if ($(this).find('.switch_status').hasClass('on')) return false;
			var id = $(this).parents('tr').data('lan_id');
			var res = LANGUAGE.modify({'lan_id': id, 'is_default': 1});

			if(res.code == 200) {
				successTips(res.message);
				$('.default').each(function(){
					var tempId = $(this).parents('tr').data('lan_id');
					switch_status($(this).find('.switch_status'), tempId == id ? 1 : 0);
				})
			} else {
				errorTips(res.message);
			}
		});
	},
	modify: function(data)
	{
		return API.post(ADMIN_URI+'language/modify', data);
	}
};