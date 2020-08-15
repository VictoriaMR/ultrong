var syalert=function(){return{syopen:function(id){var dom=$("#"+id);var oH=dom.attr('old-height');if(typeof oH!='undefined'){dom.css({height:oH+'px'});dom.find('.sy-content').css({height:(oH-100)+'px','overflow-y':''});}
this.init(dom);var name=dom.attr("sy-enter");var type=dom.attr("sy-type");this.type=type
var mask=dom.attr("sy-mask");dom.addClass(name);dom.show();var that=this;if(type!="tips"){if(hasScrollbar()){$("body").css({"margin-right":"17px"});}
$("body").css({"overflow-y":"hidden"});}
if(mask=="true"){$("body").find('.sy-mask').remove();$("body").append("<div class='sy-mask' onClick=\"closeAlert('"+id+"')\"></div>");$(".sy-mask").fadeIn(300)}
setTimeout(function(){dom.removeClass(name)},300);if(type=="tips"){setTimeout(function(){that.syhide(id)},2500)}},syhide:function(id){if(typeof id=="undefined"){var dom=$(".sy-alert")}else{var dom=$("#"+id)}
var name=dom.attr("sy-leave");dom.addClass(name);setTimeout(function(){dom.hide();$(".sy-mask").hide();dom.removeClass(name);if($('.sy-alert:visible').length==0)
$(".sy-mask").remove();$("body").css({"margin-right":"0"});$("body").css({"overflow-y":"auto"})},290);if(this.type!="tips")
$(".sy-mask").fadeOut(290);},sycenter:function(dom){var mgtop=parseFloat(dom.height()/2);dom.css({"top":"50%","margin-top":"-"+mgtop+"px"})},init:function(dom){var oH=dom.attr('old-height');var wH=$(window).height();var mH=dom.height();if(typeof oH=='undefined'){dom.attr('old-height',mH);}
if(wH<mH){var mW=dom.width();dom.css({height:wH+'px'});if(dom.find('.sy-title').length>0)
wH=parseInt(wH)-50;if(dom.find('.sy-footer').length>0)
wH=parseInt(wH)-50;dom.find('.sy-content').css({height:wH+'px','overflow-y':'auto'});}
this.sycenter(dom);}}}();