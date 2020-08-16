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
            });
        });
    }
};