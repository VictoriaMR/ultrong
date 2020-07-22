<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<form class="form-horizontal" style="width: 500px;">
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span>新密码：</span></div>
            <input type="text" class="form-control" name="password" required="required" maxlength="30" value="">
        </div>
        <div class="input-group margin-top-15">
            <div class="input-group-addon"><span>确认密码：</span></div>
            <input type="text" class="form-control" name="re_password" required="required" maxlength="30" value="">
        </div>
        <div class="margin-top-15">
            <button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="<span class='glyphicon glyphicon-refresh'></span>">确认</button>
        </div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	PASSWORD.init();
})
</script>
<?php $this->load('Common.baseFooter');?>