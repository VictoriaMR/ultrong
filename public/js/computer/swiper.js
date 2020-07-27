(function(e, t) {
    if (!e) return t;
    var n = function() {
        this.el = t;
        this.items = t;
        this.sizes = [];
        this.max = [0, 0];
        this.current = 0;
        this.interval = t;
        this.opts = { speed: 500, delay: 100000, complete: t, keys: !t, dots: t, fluid: t };
        var n = this;
        this.init = function(t, n) {
            this.el = t;
            this.ul = t.children("ul");
            this.items = this.el.children(".slider").each(this.calculate);
            n.animate_status = 0;
            this.setup();
            return this
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
            this.arrows();
            this.start();
        };
        this.move = function(t, obj) {
            if (!this.ul.find('.slider').length) t = 0;
            if (t < 0) t =  this.ul.find('.slider').length - 1;
            if (t >= this.ul.find('.slider').length) t = 0;

            var i = this.ul.find('.slider').eq(t);
            var s = { height: i.outerHeight() };
            var o = this.opts.speed;

            if (!n.animate_status) {
                n.animate_status = 1;
                n.el.find(".dot:eq(" + t + ")").addClass("active").siblings().removeClass("active");
                this.el.animate(s, o) && this.el.find('.slider').animate(e.extend({ left: "-" + t + "00%" }, s), o, function(i) {
                    n.current = t;
                    n.animate_status = 0;
                    e.isFunction(n.opts.complete) && !r && n.opts.complete(n.el)
                })
            }
        };
        this.start = function() { n.interval = setInterval(function() { n.move(n.current + 1) }, n.opts.delay) };
        this.stop = function() { n.interval = clearInterval(n.interval); return n };
        this.keys = function(t) { var r = t.which; var i = { 37: n.prev, 39: n.next, 27: n.stop }; if (e.isFunction(i[r])) { i[r]() } };
        this.next = function() { return n.stop().move(n.current + 1) };
        this.prev = function() { return n.stop().move(n.current - 1) };
        this.dots = function() {
            var t = '<div class="dots"><ol class="dots-content">';
            this.el.find('.slider').each( function(e) { t += '<li class="dot' + (e < 1 ? " active" : "") + '">' + "</li>" });
            t += "</ol></div>";
            this.el.append(t).on('click', '.dot', function(e){
                n.move($(this).index(), $(this));
            });
        };
        this.arrows = function()
        {
            this.el.append('<p class="arrows"><span class="prev"><i class="icon icon-16-32 icon-left-16-32"></i></span><span class="next"><i class="icon icon-16-32 icon-right-16-32"></i></span></p>').find(".arrows span").click(function() { 
                var index = n.el.find('.dots .active').index();
                if ($(this).hasClass('prev')) {
                    index = parseInt(index) - 1;
                } else {
                    index = parseInt(index) + 1;
                }
                n.move(index);
            })
        };
    };
    e.fn.slider = function(t) {
        (new n).init(this, t);
    }
})(window.jQuery, false)