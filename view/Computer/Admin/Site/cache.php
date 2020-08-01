<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<div class="bottom15">
        <button class="btn btn-danger delete-cache" data-loading-text="Loading..." type="button">清除全部缓存</button>
    </div>
</div>
<script type="text/javascript">
$(function(){
	$('.delete-cache').on('click', function(){
		$(this).button('loading');
		API.post(ADMIN_URI+'site/deleteCache', {}, function(res){
			if (res.code == 200) {
				successTips(res.message);
			} else {
				errorTips(res.message);
			}
		});
		$(this).button('reset');
	});
});
</script>
<?php $this->load('Common.baseFooter');?>