var API = {
	get: function(url, param, callback) {
		$.get(url, param, function(res) {
			if (callback) callback(res);
		}, 'json');
	},
	post: function(url, param, callback) {
		$.ajaxSetup({
	  		async: true
	  	});
		$.post(url, param, function(res) {
			if (callback) callback(res);
		}, 'json');
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

var POP = {
	tips: function(text, time){
        $('.sy-alert-tips').remove();
        $('body').append('<div class="sy-alert sy-alert-tips animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="tips" sy-mask="false" id="sy-alert-tips"> <div class="sy-content">'+text+'</div> </div>');
        syalert.syopen('sy-alert-tips');
    },
    loading: function(obj) {
    	var html = '<div class="load-ing">\
			<div class="load-mask"></div>\
			<img src="'+LOADING_IMG+'" class="loading">\
		</div>';
		obj.find('.load-ing').remove();
		obj.append(html);
        SCROLL.stop();
    },
    loading_circle: function(obj, type){
        var text = obj.html();
        var html = '<span class="hide-text" style="display:none;">'+text+'</span>';
        var img = type == 9 ? LOADING_CIRCLE_9_IMG : LOADING_CIRCLE_IMG;
        html += '<div class="loading-9">\
            <div class="load-mask"></div>\
            <img src="'+img+'" class="loading rotate">\
        </div>';
        obj.find('.loading-9').remove();
        obj.html(html);
    },
    loadout: function(obj) {
    	obj.find('.load-ing').remove();
        SCROLL.init();
    },
    loadout_circle: function(obj) {
        var text = obj.find('.hide-text').html();
        obj.html(text);
    }
};