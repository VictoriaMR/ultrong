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

function _getRandomString(len) {
    len = len || 32;
    var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678'; // 默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1
    var maxPos = $chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}

var UPLOAD = {
	init: function (data){
		var _this = this;
		_this.data = data;
		_this.data.obj.css({'cursor': 'pointer', 'position': 'relative'});
		_this.data.obj.on('click', function(event){
			event.stopPropagation();
			var pid = $(this).parent().attr('id');
			if (!pid) {
				pid = _getRandomString(8);
				if (_this.data.obj.parents('.upload-item-content').data('href')) 
					$(this).parent().parent().attr('id', pid);
				else
					$(this).parent().attr('id', pid);
			}
			var index = $(this).parent().index();
			var fileId = pid+'_file_'+index;

			if ($('body').find('#'+fileId).length == 0) {
				$('body').append('<input id="'+fileId+'" type="file" style="display: none;" />');
			}
			$('#'+fileId).click();
		});

		if (_this.data.obj.parents('.upload-item-content').data('delete')) {
			if (_this.data.obj.find('.delete').length == 0) {
				_this.data.obj.append('<span class="glyphicon glyphicon-trash delete"></span>');
			}

			_this.data.obj.on('click', '.delete', function(event){
				event.stopPropagation();
				if (_this.data.obj.find('img').length == 0) return false;
				if (_this.data.obj.parents('.upload-item-content').data('href')) {
					var parent = $(this).parent().parent();
					$(this).parent().parent().remove();
				} else {
					var parent = $(this).parent();
					$(this).parent().remove();
				}
				UPLOAD.initItem(parent);
			});
		}

		if (_this.data.obj.parents('.upload-item-content').data('sort')) {
			if (_this.data.obj.find('.to-left').length == 0) {
				_this.data.obj.append('<span class="glyphicon glyphicon-chevron-left to-left"></span>');
			}

			if (_this.data.obj.find('.to-right').length == 0) {
				_this.data.obj.append('<span class="glyphicon glyphicon-chevron-right to-right"></span>');
			}

			_this.data.obj.on('click', '.to-right, .to-left', function(event){
				event.stopPropagation();
				if ($(this).hasClass('to-left')) {
					if (_this.data.obj.parents('.upload-item-content').data('href')) {
						if ($(this).parent().parent().index() == 0) return false;
					} else {
						if ($(this).parent().index() == 0) return false;
					}
					if (_this.data.obj.parents('.upload-item-content').data('href'))
						$(this).parent().parent().prev().before($(this).parent().parent());
					else
						$(this).parent().prev().before($(this).parent());
				} else {
					if (_this.data.obj.parents('.upload-item-content').data('href')) {
						if ($(this).parent().parent().index() == $(this).parent().parent().siblings().length) return false;
					} else {
						if ($(this).parent().index() == $(this).parent().siblings().length) return false;
					}
					if (_this.data.obj.parents('.upload-item-content').data('href'))
						$(this).parent().parent().next().after($(this).parent().parent());
					else
						$(this).parent().next().after($(this).parent());
				}
			});
		}

		_this.data.obj.on('mouseover', function(){
			$(this).find('span').show();
		}).on('mouseleave', function(){
			$(this).find('span').hide();
		});


		$('body').on('change', 'input[type="file"]', function() {
			var id = $(this).attr('id');
			idArr = id.split('_file_');
			UPLOAD.loadFile($(this), $('#'+idArr[0]).data('site') ? $('#'+idArr[0]).data('site') : 'temp');
		});
	},
	loadFile: function(obj, site)
	{
		var returnData = {};
        var formData = new FormData();

        if (!obj.get(0).files[0]) return false;
        
        formData.append('file', obj.get(0).files[0]);  //上传一个files对象
        formData.append('site', site);

        var id = obj.attr('id');
		idArr = id.split('_file_');

        $.ajax({//jQuery方法，此处可以换成其它请求方式
            url: API_URL + 'upload',
            type: 'post',
            data: formData, 
            processData: false, //jquery 是否对数据进行 预处理
            contentType: false, // 不要自己修改请求内容类型
            error: function (res) {
                if (UPLOAD.data.error)
                	UPLOAD.data.error(res, $('#'+idArr[0]).find('.upload-item').eq(idArr[1]));
            },
            success: function (res) {
            	if (res.code == 200) {
					if ($('#'+idArr[0]).find('.upload-item').eq(idArr[1]).find('img').length == 0) {
						$('#'+idArr[0]).find('.upload-item').eq(idArr[1]).append('<img src="" />');
					}

					$('#'+idArr[0]).find('.upload-item').eq(idArr[1]).find('img').attr('src', res.data.url);
					$('#'+idArr[0]).find('.upload-item').eq(idArr[1]).attr('data-attach_id', res.data.attach_id);

	                UPLOAD.initItem($('#'+idArr[0]));

	                if (UPLOAD.data.success)
	                	UPLOAD.data.success(res, $('#'+idArr[0]).find('.upload-item').eq(idArr[1]));
            	} else {
            		errorTips(res.message);
            	}
            }
        });
	},
	initItem: function(parentObj)
	{
		var len = parentObj.data('length');
		if (len > parentObj.find('.upload-item').length) {
			var check = true;
			parentObj.find('.upload-item').each(function(){
				if ($(this).find('img').length == 0) {
					check = false;
					return false;
				} else {
					if (!$(this).find('img').attr('src')) {
						check = false;
						return false;
					}
				}
			});

			if (!check) return false;
			var node = parentObj.find('.upload-item').parent().eq(0).clone(true);
			node.find('img').attr('src', '');
			node.find('input').val('');
			node.find('.upload-item').data('attach_id', 0);
			node.find('.upload-item').attr('data-attach_id', 0);
			parentObj.append(node)
		}
	}
};