var PRODUCT = {
	init: function()
	{
		$('.product-info .pic-left li').on('click', function(){
			if ($(this).hasClass('selected')) return false;
			$(this).addClass('selected').siblings().removeClass('selected');
			var src = $(this).find('img').attr('src').replace('300x300', '800x800');
			$('.product-info .pic-right').find('img').attr('src', src);
		})
	}
};