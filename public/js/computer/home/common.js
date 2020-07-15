$(function(){
    $('#languega_list .selector-icon').on('click', function(){
        $(this).parent().find('.selector').slideToggle('200');
    });
    $('#languega_list .selector li').on('click', function(){
        var type = $(this).data('type');
        API.get(HOME_API+'Index/setSiteLanguage', {'type': type}, function(res) {
            window.location.reload();
        }); 
    });
});