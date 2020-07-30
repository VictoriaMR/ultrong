var PRODUCT = {
	init: function()
	{
		$('.product-info .pic-left li').on('click', function(){
			if ($(this).hasClass('selected')) return false;
			$(this).addClass('selected').siblings().removeClass('selected');
			var src = $(this).find('img').attr('src');
			$('.product-info .pic-right').find('img').attr('src', src);
		})
	}
};