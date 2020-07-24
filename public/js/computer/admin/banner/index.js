var BANNER = {
	init: function()
	{
		UPLOAD.init({
			obj: $('.banner-content .upload-item'),
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
			var lan_id = $(this).parents('.banner-content').data('lan_id');

			var idArr = [];
			$(this).parents('.banner-content').find('ul li').each(function(){
				var id = $(this).data('attach_id');
				if (id > 0)
					idArr.push(id);
			});

			if (idArr.length == 0) return false;
			$(this).button('loading');
			API.post(ADMIN_URI+'site/saveBanner', {lan_id: lan_id, attach_id: idArr.join(',')}, function(res){
				if (res.code == 200) {
					successTips(res.message);
				} else {
					errorTips(res.message);
				}
			});
			$(this).button('reset');
		});
	}
};