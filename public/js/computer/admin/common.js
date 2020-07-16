(function($){
$.fn.offsetCenter = function(width, height) {
    var obj = $(this);
    if(!obj.hasClass('centerShow')){
        obj.addClass('centerShow');
    }
    if(typeof width != 'undefined' && width>0){
        var w = width;
    } else {
        var w = $(window).innerWidth();
    }
    w = (w -obj.innerWidth())/2;
    if(typeof height != 'undefined' && height>0){
        var h = height;
    } else {
        var h = $(window).innerHeight();
    }
    h = (h - obj.innerHeight())/2*2/3;
    obj.css('position','fixed');
    obj.css('top',h+'px');
    obj.css('left',w+'px');

    if (obj.data("resizeSign") !='ok') {
        obj.data('resizeSign','ok');
        $(window).resize(function () {
            obj.offsetCenter(width, height);
        });
        obj.find('.close').on('click', function() {
            obj.hide();
        });
    }
};
}(jQuery));