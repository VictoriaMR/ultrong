$(function(){
    $('.header-top .language').on('click', function(){
        $(this).find('.selector').slideToggle(100);
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