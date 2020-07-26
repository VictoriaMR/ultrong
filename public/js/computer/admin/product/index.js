var PRODUCT = {
	init: function()
	{
		$('.delete-btn').on('click', function(){
			var _this = $(this);
			confirm('确认删除吗', function(){
				API.post(ADMIN_URI+'product/delete', _this.parent().data(), function(res) {
					window.location.reload();
				})
			});
		});
	}
};