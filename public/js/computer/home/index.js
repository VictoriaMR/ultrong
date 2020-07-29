var INDEX = {
	init: function()
	{
		$('.product-box ul').each(function(){
			var _this = $(this);
			_this.obj = $(this);
	        _this.width;
	        _this.length;
	        _this.parentWidth;
	        _this.interval;
	        _this.stop = false;
	        getWidth(_this);
	        if (_this.width * _this.length <= _this.parentWidth)
	            return false;

	        start(_this);

	        _this.obj.parents('.category-product').find('.ant2-icon').on('click', function() {
	        	if (_this.stop) return false;
	        	_this.stop = true;
	        	stop(_this);
	        	if ($(this).hasClass('prev-stay')) {
	        		prev(_this, true)
	        	} else {
	        		next(_this, true);
	        	}
	        })

	        function getWidth(e) {
	        	var width = e.obj.find('.slider').eq(0).width();
		        var left = e.obj.find('.slider').eq(0).css('marginLeft');
		        var right = e.obj.find('.slider').eq(0).css('marginRight');
		        e.width = width + _pxToNum(left) + _pxToNum(right);
		        e.parentWidth = e.obj.width();
		        e.length = e.obj.find('.slider').length;
	        };

	        function start(e) {
		        stop(e);
		        e.interval = setInterval(function() { 
		            next(e);
		        }, 3000);
		    };

		    function prev(e, restart) {
		    	var selectobj = e.obj.find('.slider').eq(0);
            	var lastobj = e.obj.find('.slider:last');
            	selectobj.before(lastobj);
		        e.obj.find('.slider').css({left: -e.width});

		        e.obj.find('.slider').animate({left: 0}, 500, function() {
		            if (restart) start(_this);
		            _this.stop = false;
		        });
		    }

		    function next(e, restart) {
		    	var selectobj = e.obj.find('.slider').eq(0);
            	var lastobj = e.obj.find('.slider:last');
		        e.obj.find('.slider').animate({left: -e.width}, 500, function() {
		        	lastobj.after(selectobj)
		            e.obj.find('.slider').css({left: 0});
		            if (restart) start(_this);
		            _this.stop = false;
		        });
		    }

		    function stop(e) {
				clearInterval(e.interval);
        		e.interval = null; 
		    };

		});
	}
};