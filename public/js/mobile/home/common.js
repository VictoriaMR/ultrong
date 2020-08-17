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
});