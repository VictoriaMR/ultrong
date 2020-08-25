var HEADER = {
    init: function(data)
    {
        $('#header-top .language').on('click', function(){
            var _thisobj = $(this);
            $(this).find('.selector').slideToggle(100, function(){
                if (_thisobj.find('.selector').is(':visible')) {
                    _thisobj.find('.icon').addClass('icon-angle-w-up').removeClass('icon-angle-w-down');
                } else {
                    _thisobj.find('.icon').addClass('icon-angle-w-down').removeClass('icon-angle-w-up');
                }
            });
        });
        $('#header-top .language li').on('click', function(event){
        	event.stopPropagation();
            if ($(this).hasClass('selected')) return false;
            var id = $(this).data('id');
            API.get(HOME_URI+'Index/setSiteLanguage', {'lan_id': id}, function(res) {
            	if (res.code == 200)
                	window.location.reload();
            }); 
        });
        //滚动按钮
        var viewH = $(window).height();  //可见高度
        $(document).scroll(function() {
            var scroH = $(document).scrollTop();  //滚动高度
            if (scroH > viewH) {
                $('.goto-top').removeClass('pop-down');
                $('.goto-top').addClass('pop-up');
                $('.goto-top').show();
            } else {
                $('.goto-top').removeClass('pop-up');
                $('.goto-top').hide();
            }
        });

        $('.goto-top').on('click', function(){
            $('html, body').animate({scrollTop: 0}, 300);
        });

        //头部导航子显示
        $('#header-content .nav .title').parent().on('mouseover', function(){
            $(this).find('.nav-son').slideDown(200);
        }).on('mouseleave', function(){
           $(this).find('.nav-son').slideUp(200);
        })
    }
};

var POP = {
    tips: function(text, time) {
        $('.sy-alert-tips').remove();
        $('body').append('<div class="sy-alert sy-alert-tips animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="tips" sy-mask="false" id="sy-alert-tips"> <div class="sy-content">' + text + '</div> </div>');
        syalert.syopen('sy-alert-tips');
    }
};

var FOOTER = {
    init: function(data)
    {
        $('#submit').on('click', function(){
            var check = true;
            var _thisobj = $(this);
            _thisobj.parent('form').find('[required="required"]').each(function(){
                var val = $(this).val();
                if (val == '') {
                    var name = $(this).data('name');
                    $(this).focus();
                    POP.tips(name+data.empty_text);
                    var check = false;
                    return false;
                }
            });
            if (!check) return false;
            API.post(data.contact_url, $(this).parent('form').serializeArray(), function(res) {
                POP.tips(res.message);
                _thisobj.parent('form').find('[required="required"]').val('');
                if ($('.chat .chat-content').is(':visible'))
                    CHAT.get();
            });
        });
    }
};

var CHAT = {
    init: function(data)
    {
        var _this = this;
        _this.data = data;
        _this.lastId = 0;
        _this.interval = null;
        _this.intervalCount = null;
        _this.getCount();
        _this.startCount();
        $('.chat').on('click', '.chat_button_bar', function(){
            $(this).hide();
            _this.get();
            _this.start();
            _this.stopCount();
            _this.initBottom();
            $('.chat .chat-content').slideDown(100, function(){
                _this.initBottom();
            });
        });
        $('.chat').on('click', '.close-hide', function(){
            $(this).parents('.chat-content').slideUp(100, function(){
                $('.chat .chat_button_bar').show();
                _this.stop();
                _this.startCount();
            });
        });
        //发送按钮
        $('.chat').on('click', '.chat-button .btn', function(){
            var val = $(this).parents('.chat-button').find('input').val();
            if (val == '') {
                $(this).parents('.chat-button').find('input').focus();
                POP.tips(data.empty_text)
                return false;
            }
            CHAT.send(val);
        });
        //绑定发送enter键
        document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if(ev.keyCode==13) {
                $('.chat .chat-button .btn').trigger('click');
            }
        }
    },
    //未读消息
    startCount: function()
    {
        var _this = this;
        _this.key = localStorage.getItem('chat_group_key');
        if (!_this.key) {
            return false;
        }
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
        $('.chat .unread').remove();
        if (num > 0) {
            $('.chat').append('<span class="unread">'+num+'</span>');
        }
    },
    //获取信息
    start:function()
    {
        var _this = this;
        _this.key = localStorage.getItem('chat_group_key');
        if (!_this.key) {
            var res = API.post(_this.data.create_url);
            if (res.code != 200) {
                POP.tips(res.message);
                return false;
            }
            _this.key = res.data;
            localStorage.setItem('chat_group_key', res.data);
        }
        _this.stop();
        _this.interval = setInterval(function() { 
            _this.get();
        }, 3000);
    },
    get: function()
    {
        var _this = this;
        _this.key = localStorage.getItem('chat_group_key');
        var res = API.post(_this.data.list_url, {'group_key': _this.key, 'last_id': _this.last_id});
        if (res.code == 200) {
            var len = res.data.length;
            if (len > 0) {
                var html = '';
                for (var i in res.data) {
                    var type = '';
                    if (res.data[i].is_self) {
                        type = 'right';
                    } else {
                        type = 'left';
                    }
                    if (res.data[i].create_at)
                        html += '<p class="text-center font-12">'+res.data[i].create_at+'</p>';

                    html += '<p>\
                                <div class="avatar '+type+'">\
                                    <img src="'+res.data[i].user_avatar+'">\
                                </div>\
                                <div class="content '+type+' font-14">'+res.data[i].content+'</div>\
                                <div class="clear"></div>\
                            </p>';
                }
                $('#chat-text-content').append(html);
                _this.last_id = res.data[len-1].message_id;
            }
        }
    },
    stop: function()
    {
        var _this = this;
        clearInterval(_this.interval);
        _this.interval = null; 
    },
    send: function(val)
    {
        var _this = this;
        if (!_this.key) return false;
        var res = API.post(_this.data.contact_url, {'group_key': _this.key, 'content': val});
        if (res.code == 200) {
            $('.chat .chat-button input').val('');
            _this.get();
            _this.initBottom();
        }
    },
    initBottom: function()
    {
        $('#chat-text-content').animate({scrollTop: $('#chat-text-content').height()+200}, 100);
    }
};