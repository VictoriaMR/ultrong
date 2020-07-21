var API = {
	get: function(url, param, callback) {
		var returnData = {};
		$.ajaxSetup({
	  		async: false
	  	});
		$.get(url, param, function(res) {
			if (callback) callback(res);
			else returnData = res;
		}, 'json');
		return returnData;
	},
	post: function(url, param, callback) {
		var returnData = {};
		$.ajaxSetup({
	  		async: false
	  	});
		$.post(url, param, function(res) {
			if (callback) callback(res);
			else returnData = res;
		}, 'json');
		return returnData;
	},
};

var VERIFY = {
	phone: function (phone) {
		var reg = /^1[3456789]\d{9}$/;
		return VERIFY.check(phone, reg);
	},
	email: function (email) {
		var reg = /^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
		return VERIFY.check(email, reg);
	},
	password: function (password) {
		var reg = /^[0-9A-Za-z]{6,}/;
		return VERIFY.check(password, reg);
	},
	code: function(code) {
		var reg = /^\d{4,}/;
		return VERIFY.check(code, reg);
	},
	check: function(input, reg) {
		input = input.trim();
		if (input == '') return false;
		return reg.test(input);
	}
};

var UPLOAD = {
	init: function (data){
		this.data = data;
		this.data.obj.css({'cursor': 'pointer'});
		this.data.obj.on('click', function(event){
			if ($('body input[type="file"]').length == 0) {
				$('body').append('<input type="file" style="display: none;" />');
			}
			$('body input[type="file"]').trigger('click');
		});

		$('body').on('change', 'input[type="file"]', function() {
			UPLOAD.loadFile($(this), UPLOAD.data.site ? UPLOAD.data.site : 'temp');
		});
	},
	loadFile: function(obj, site)
	{
		var returnData = {};
        var formData = new FormData();
        formData.append('file', obj.get(0).files[0]);  //上传一个files对象
        formData.append('site', site);

        $.ajax({//jQuery方法，此处可以换成其它请求方式
            url: API_URL + 'upload',
            type: 'post',
            data: formData, 
            processData: false, //jquery 是否对数据进行 预处理
            contentType: false, // 不要自己修改请求内容类型
            error: function (res) {
                if (UPLOAD.data.error)
                	UPLOAD.data.error(res);
            },
            success: function (res) {
                if (UPLOAD.data.success)
                	UPLOAD.data.success(res);
            }
        });
	}
};