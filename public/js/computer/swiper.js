(function(e, t) {
    if (!e) return t;
    var n = function() {
        this.el = t;
        this.items = t;
        this.width = t;
        this.sizes = [];
        this.max = [0, 0];
        this.current = 0;
        this.interval = t;
        this.opts = { speed: 600, delay: 6000, complete: t, keys: !t, dots: t, fluid: t };
        var n = this;
        this.init = function(t, n) {
            this.el = t.find('.slider-box');
            if (!n.items) this.items = 'li';
            else this.items = n.items;
            if (this.el.find(this.items).length < 2) return false;
            n.animate_status = 0;
            this.width = n.width;
            this.el.find(this.items).eq(0).addClass('select');
            this.initDots();
            this.setup();
            return this;
        };
        this.initDots = function()
        {
            var index = this.el.find(this.items+'.select').data('sort');
            index = index ? index : 0;
            this.el.parent().find('.dots .dot').eq(index).addClass('active').siblings().removeClass('active');
        };
        this.calculate = function(t) {
            var r = e(this),
                i = r.outerWidth(),
                s = r.outerHeight();
            n.sizes[t] = [i, s];
            if (i > n.max[0]) n.max[0] = i;
            if (s > n.max[1]) n.max[1] = s
        };
        this.setup = function() {
            //初始化底部小点
            this.dots();
            // this.arrows();
            this.start();
        };
        this.move = function(type, callback) {
            var _this = this;
            var selectObj = _this.el.find(_this.items+'.select');
            var nextObj = _this.el.find(_this.items+'.select').next();
            _this.el.find(_this.items).animate({left: type+_this.width}, n.opts.speed, function(){
                _this.el.find(_this.items+':last').after(selectObj);
                nextObj.addClass('select').siblings().removeClass('select');
                _this.el.find(_this.items).css({left: '0'});
                _this.initDots();
                if (callback) callback();
            });
        };
        this.start = function() { n.interval = setInterval(function() { n.move('-') }, n.opts.delay) };
        this.stop = function() { n.interval = clearInterval(n.interval); return n; };
        this.keys = function(t) { var r = t.which; var i = { 37: n.prev, 39: n.next, 27: n.stop }; if (e.isFunction(i[r])) { i[r]() } };
        this.next = function() { return n.stop().move(n.current + 1) };
        this.prev = function() { return n.stop().move(n.current - 1) };
        this.dots = function() {
            var t = '<div class="dots"><ol class="dots-content">';
            this.el.find(this.items).each( function(e) {
                $(this).data('sort', $(this).index());
                t += '<li class="dot' + (e < 1 ? " active" : "") + '">' + "</li>" }
            );
            t += "</ol></div>";
            this.el.parent().append(t);
        };
        this.arrows = function() {
            var _this = this;
            _this.el.parent().append('<p class="arrows"><span class="prev"><i class="icon icon-16-32 icon-left-16-32"></i></span><span class="next"><i class="icon icon-16-32 icon-right-16-32"></i></span></p>');
        };
    };
    e.fn.slider = function(t) {
        (new n).init(this, t);
    }
})(window.jQuery, false)