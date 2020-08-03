$(function(){
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
});