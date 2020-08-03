var SITEINFO = {
	init: function()
	{
		$('.modify').on('click', function(){
			$(this).parents('.info-item').find('input[type="file"]').trigger('click');
		});

		$('input[type="file"]').on('change', function(){
			var path = $(this).data('id');
			var type = $(this).data('type');
			SITEINFO.loadFile($(this), path, type);
		});
	},
	loadFile: function(obj, path, type)
	{
		var formData = new FormData();

        if (!obj.get(0).files[0]) return false;
        
        formData.append('file', obj.get(0).files[0]);  //上传一个files对象
        formData.append('path', path);
        formData.append('type', type);
        formData.append('site', 'file');

        $.ajax({//jQuery方法，此处可以换成其它请求方式
            url: API_URL + 'upload',
            type: 'post',
            data: formData, 
            processData: false, //jquery 是否对数据进行 预处理
            contentType: false, // 不要自己修改请求内容类型
            error: function (res) {
                errorTips(res.message);
            },
            success: function (res) {
            	if (res.code == 200) {
            		successTips(res.message);
					obj.parents('.info-item').find('img').attr('src', res.data.url);
            	} else {
            		errorTips(res.message);
            	}
            }
        });
	},
};