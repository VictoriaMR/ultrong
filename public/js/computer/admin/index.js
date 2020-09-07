var INDEX = {
	init: function(data) {
		var _this = this;
		var width = $(window).width();
		var height = $(window).height();
		var topH = $('#header').height();
		_this.data = data;
		_this.intervalCount = null;
		_this.getCount();
        _this.startCount();
		$('#left').css({height: height - topH + 'px'});

		var iframeTop = $('#iframe-list').height();
		$('#iframe-list-content').css({height: height - topH - iframeTop + 'px', 'margin-top': '-10px'})

		$('#left-one .toggle').on('click', function(){
			var ow = $('#left-one').width();
			if (ow == 40) {
				$(this).removeClass('close').addClass('open');
				ow = 110;
				aw = 185 + 70;
			} else {
				$(this).removeClass('open').addClass('close');
				ow = 40;
				aw = 185;
			}
			$('#left-one').css({'width': ''+ow+'px'});
			$('#left-two').css({'width': 'calc(100% - '+ow+'px);'});

			$(this).parents('td').attr('width', aw);
		});

		$('#left-one [data-title]').on('mouseover', function(){
			if ($('#left-one .toggle').hasClass('open')) return false;
			var offTop = $(this).position().top;
			var oh = $(this).height();
			var diff = (oh - 24) / 2;
			$(this).parent().find('.tooltips').remove();
			$(this).parent().append('<div class="tooltips" style="top:'+(parseInt(offTop)+diff)+'px">'+$(this).data('title')+'</div>');
		}).on('mouseleave', function(){
			$(this).parent().find('.tooltips').remove();
		});

		//切换iframe 
		$('#left-two .menu-content li').on('click', function(){
			$(this).addClass('selected').siblings().removeClass('selected');
			var id = $(this).data('id');
			if ($('#iframe-list-content [data-id="'+id+'"]').length > 0) {
				$('#iframe-list [data-id="'+id+'"]').addClass('select');
				$('#iframe-list-content [data-id="'+id+'"]').show();
			} else {
				var src = $(this).data('src');
				var html = '<iframe src="'+src+'" frameborder="0" width="100%" height="100%" data-id="'+id+'"></iframe>';
				$('#iframe-list-content').append(html);
				var name = $(this).text();
				html = '<li class="select" data-id="'+id+'">'+name+'</li>';
				$('#iframe-list ul').append(html);
			}

			localStorage.setItem('controller', id);

			$('#iframe-list [data-id="'+id+'"]').siblings().removeClass('select');
			$('#iframe-list-content [data-id="'+id+'"]').siblings().hide();
		});

		//顶部切换页面
		$('#iframe-list').on('click', 'li', function(){
			var id = $(this).data('id');
			$(this).addClass('select').siblings().removeClass('select');
			$('#iframe-list-content [data-id="'+id+'"]').show().siblings().hide();
		});

		//左侧点击切换
		$('#left-one .feature').on('click', function(){
			$(this).addClass('selected').siblings().removeClass('selected');
			var featureId = $(this).data('feature-id');
			localStorage.setItem('feature', featureId);
			$('#left-two #menu-main-'+featureId).removeClass('hidden').siblings().addClass('hidden');
		});

		this.frameInit();
	},
	//未读消息
    startCount: function()
    {
        var _this = this;
        _this.stopCount();
        _this.intervalCount = setInterval(function() { 
            _this.getCount();
        }, 3000);
    },
    stopCount: function()
    {
        var _this = this;
        $('.chat .unread').remove();
        clearInterval(_this.intervalCount);
        _this.intervalCount = null; 
    },
    getCount: function()
    {
        var _this = this;
        _this.key = localStorage.getItem('chat_group_key');
        var res = API.post(_this.data.count_url, {'group_key': _this.key});
        if (res.code == 200) {
            _this.initCount(res.data);
        } else {
            _this.stopCount();
        }
    },
    initCount: function(num)
    {
        $('#message .unread').remove();
        if (num > 0) {
            $('#message').append('<span class="unread">'+num+'</span>');
        }
    },
	frameInit: function(){
		var id = localStorage.getItem('feature');
		if (id) {
			$('#feature-main-'+id).trigger('click');
		}

		id = localStorage.getItem('controller');
		if (id) {
			$('#left-two .menu-content li[data-id='+id+']').trigger('click');
		}
	}
};