$(document).ready(function(){
    var viewH = $('.header-top').height() + 2;
    var nowH = 0;
    var up = false;
    var down = false;
    $(document).scroll(function() {
        var scroH = $(document).scrollTop();  //滚动高度
        if (scroH > nowH) {
            if (scroH > viewH && !up) {
                $('.header-top').stop(true).animate({top: '-'+viewH+'px'}, 300);
                $('.header-top').find('.drop-mean').fadeOut(200);
                up = true;
                down = false;
            }
        } else if(!down) {
            $('.header-top').stop(true).animate({top: '0'}, 300);
            down = true;
            up = false;
        }
        nowH = scroH;
    });

    //头部菜单
    $('#top-mean').on('click', function(){
        var _this = $(this);
        if (_this.hasClass('disabled')) return false;
        _this.addClass('disabled');
        if (_this.hasClass('close')) {
            $('.menu-box').fadeIn(200);
            _this.find('.iconfont').removeClass('icon-nav').addClass('icon-category');
            $('.menu-content').animate({'left': '0'}, 250, function(){
                _this.removeClass('close').addClass('open');
                _this.removeClass('disabled');
            });
            BODY.stopscoll();
        } else {
            _this.find('.iconfont').removeClass('icon-category').addClass('icon-nav');
            $('.menu-content').animate({'left': '-100%'}, 250, function(){
                $('.menu-box').fadeOut(200);
                    _this.removeClass('open').addClass('close');
                    _this.removeClass('disabled');
            });
            BODY.init();
        }
    });
    //菜单阴影部分点击
    $('.menu-sy-mask').on('click', function(){
        $('#top-mean').click();
    });
    //分类点击
    $('.menu-content .item-box .item-href').on('click', function(){
        $(this).parent('.item-box').next().show().animate({'left': '0'}, 250);
    });
    //返回菜单
    $('.category-box .back-menu').on('click', function() {
        $('.menu-content .item-box').show().animate({'right': '0'}, 250);
        $('.menu-content .category-box').animate({'left': '100%'}, 250, function(){
            $('.category-box').hide();
        });
    });
    //语言点击
    $('.header-top .language').on('click', function(){
        if ($(this).find('.drop-mean').is(':visible')) {
            $(this).find('.drop-mean').fadeOut(200);
        } else {
            $(this).find('.drop-mean').fadeIn(200);
        }
    });
    $('.header-top .language li').on('click', function(event){
        event.stopPropagation();
        if ($(this).hasClass('selected')) return false;
        var id = $(this).data('id');
        API.get(HOME_URI+'Index/setSiteLanguage', {'lan_id': id}, function(res) {
            if (res.code == 200)
                window.location.reload();
        }); 
});
});

var POP = {
    tips: function(text, time) {
        $('.sy-alert-tips').remove();
        $('body').append('<div class="sy-alert sy-alert-tips animated" sy-enter="zoomIn" sy-leave="zoomOut" sy-type="tips" sy-mask="false" id="sy-alert-tips"> <div class="sy-content">'+text+'</div> </div>');
        syalert.syopen('sy-alert-tips');
    }
};

var BODY = {
    init: function (obj) {
        if (obj)
            obj.css({'overflow': ''});
        else
            $('body').css({'overflow': ''});
    },
    stopscoll: function(obj) {
        if (obj)
            obj.css({'overflow': 'hidden'});
        else
            $('body').css({'overflow': 'hidden'});
    }
};

function slider_init(e){
    var $this;
    if(e!=undefined){
        $this=e;
    }else{
        $this=$('.image-slider');
    }
    if ($this.find('ul li').length < 2){
        $this.find('ul li').css({'-webkit-transform': 'translateX(0%)', 'transform': 'translateX(0%)'});
        return false;
    }
    $this.unbind();
    var height = $this.height();
    $this.css({height: height}).find('ul li').css({position: 'absolute', height: height, top: 0, left: 0});
    $this.each(function(){
        var _this = $(this);
        _this.interval = null;
        var carousel = $(this);
        var carouselUl = carousel.find('ul');
        var carouselLis = carouselUl.find('li');
        if(carouselLis.length<=1){
            carouselLis[0].style.transform = 'translateX(0px)';
            return false;
        }
        var points = carousel.find('ol');
        // 获取slider组件宽度
        var screenWidth = $this.width();
        // 初始化三个固定的位置
        var left = carouselLis.length - 1;
        var center = 0;
        var right = 1;

        // 动态设置小圆点的active类
        var pointsLis = points.find('li');

        // 归位（多次使用，封装成函数）
        setTransform();

        // 分别绑定touch事件
        var startX = 0;  // 手指落点
        var startY = 0;  // 手指落点
        var startTime = null; // 开始触摸时间
        carouselUl.on('touchstart', touchstartHandler); // 滑动开始绑定的函数 touchstartHandler
        carouselUl.on('touchmove', touchmoveHandler);   // 持续滑动绑定的函数 touchmoveHandler
        carouselUl.on('touchend', touchendHandeler);    // 滑动结束绑定的函数 touchendHandeler
        //定时轮播
        start();
        function start() {
            stop();
            _this.interval = setInterval(function() { 
                showNext();
            }, 6000);
        }
        function stop() {
            clearInterval(_this.interval);
            _this.interval = null; 
        }

        // 轮播图片切换下一张
        function showNext() {
            // 轮转下标
            left = center;
            center = right;
            right++;
            //　极值判断
            if (right > carouselLis.length - 1) {
                right = 0;
            }
            //添加过渡（多次使用，封装成函数）
            setTransition(1, 1, 0);
            // 归位
            setTransform();
            // 自动设置小圆点
            setPoint();
        }

        // 轮播图片切换上一张
        function showPrev() {
            // 轮转下标
            right = center;
            center = left;
            left--;
            //　极值判断
            if (left < 0) {
                left = carouselLis.length - 1;
            }
            //添加过渡
            setTransition(0, 1, 1);
            // 归位
            setTransform();
            // 自动设置小圆点
            setPoint();
        }

        // 滑动开始
        function touchstartHandler(e) {
            stop();
            // 记录滑动开始的时间
            startTime = Date.now();
            // 记录手指最开始的落点
            startX = e.changedTouches[0].clientX;
            startY = e.changedTouches[0].clientY;
        }
        // 滑动持续中
        function touchmoveHandler(e) {
            // 获取差值 自带正负
            var dx = e.changedTouches[0].clientX - startX;
            //阻止左右滑动时页面上下抖动
            var deltaX = e.changedTouches[0].clientX - startX;
            var deltaY = e.changedTouches[0].clientY - startY;
            if (Math.abs(Math.asin(deltaY/deltaX)) <= 15/180*Math.PI && e.cancelable) {
                e.preventDefault();
            }
            // 干掉过渡
            setTransition(0, 0, 0);
            // 归位
            setTransform(dx);
        }
        //　滑动结束
        function touchendHandeler(e) {
            start();
            // 在手指松开的时候，要判断当前是否滑动成功
            var dx = e.changedTouches[0].clientX - startX;
            // 获取时间差
            var dTime = Date.now() - startTime;
            // 滑动成功的依据是滑动的距离（绝对值）超过屏幕的三分之一 或者滑动的时间小于200毫秒同时滑动的距离大于30
            if (Math.abs(dx) > screenWidth / 3 || (dTime < 200 && Math.abs(dx) > 30)) {
                // 滑动成功了
                // 判断用户是往哪个方向滑
                if (dx > 0) {
                    // 往右滑 看到上一张
                    showPrev();
                } else {
                    // 往左滑 看到下一张
                    showNext();
                }
            } else {
                // 添加上过渡
                setTransition(1, 1, 1);
                // 滑动失败了
                setTransform();
            }
        }
        // 设置过渡
        function setTransition(a, b, c) {
            if (a) {
                carouselLis[left].style.transition = 'transform 0.7s';
            } else {
                carouselLis[left].style.transition = 'none';
            }
            if (b) {
                carouselLis[center].style.transition = 'transform 0.7s';
            } else {
                carouselLis[center].style.transition = 'none';
            }
            if (c) {
                carouselLis[right].style.transition = 'transform 0.7s';
            } else {
                carouselLis[right].style.transition = 'none';
            }
        }

        //　封装归位
        function setTransform(dx) {
            dx = dx || 0;
            carouselLis[left].style.transform = 'translateX(' + (-screenWidth + dx) + 'px)';
            carouselLis[center].style.transform = 'translateX(' + dx + 'px)';
            carouselLis[right].style.transform = 'translateX(' + (screenWidth + dx) + 'px)';
        }

        function setPoint() {
            carousel.find('ol li.active').removeClass('active');
            pointsLis.eq(center).addClass('active');
        }
        //窗口宽度改变时 改变slider翻页宽度 并重置前后图片定位
        $(window).resize(function(){
            screenWidth = $this.width();
            setTransform();
        });
    });
}

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
            $('.chat').css({'bottom': 0, 'right': 0});
            BODY.stopscoll();
            $(this).hide();
            var height = $(window).height();
            $('.chat .chat-content').css({height: height * 0.65});
            _this.get();
            _this.start();
            _this.stopCount();
            _this.initBottom();
            $('.chat .chat-content').slideDown(100, function(){
                _this.initBottom();
            });
        });
        $('.chat').on('click', '.close-hide', function(){
            $('.chat').css({'bottom': '0.15rem', 'right': '0.15rem'});
            $(this).parents('.chat-content').slideUp(100, function(){
                $('.chat .chat_button_bar').show();
                _this.stop();
                _this.startCount();
                BODY.init();
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
        console.log(_this.key)
        if (!_this.key) {
            return false;
        }
        _this.stop();
        _this.interval = setInterval(function() { 
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
                        html += '<p class="text-center font-12 color-9">'+res.data[i].create_at+'</p>';

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