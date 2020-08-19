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
            $('.menu-content').animate({'right': '0'}, 250, function(){
                _this.removeClass('close').addClass('open');
                _this.removeClass('disabled');
            });
            BODY.stopscoll();
        } else {
            $('.menu-content').animate({'right': '-75%'}, 250, function(){
                $('.menu-box').fadeOut(200);
                 _this.removeClass('open').addClass('close');
                 _this.removeClass('disabled');
            });
            BODY.init();
        }
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