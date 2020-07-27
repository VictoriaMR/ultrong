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
			$(this).parents('form').eq(0).find('.upload-item').each(function(){
				var id = $(this).attr('data-attach_id');
				if (id > 0)
					idArr.push(id);
			});

			$(this).parents('form').eq(0).find('input[name="image"]').val(idArr.join(','));
			if (idArr.length == 0) return false;
			$(this).button('loading');
			API.post(ADMIN_URI+'site/saveBanner', $(this).parents('form').eq(0).serializeArray(), function(res){
				if (res.code == 200) {
					successTips(res.message);
					window.location.reload();
				} else {
					errorTips(res.message);
				}
			});
			$(this).button('reset');
		});

		$('.shebei').on('change', function(){

		});
	}
};