<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<form class="form-horizontal" style="max-width: 500px;" method="post" action="<?php echo adminUrl('site');?>">
		<input type="hidden" name="site_id" value="<?php echo $siteInfo['site_id'] ?? 0;?>">
		<?php foreach ($name as $key => $value) { ?>
		<?php if (in_array($key, ['domain', 'phone', 'email', 'ipc'])) { ?>
		<div class="input-group margin-top-15">
            <div class="input-group-addon"><span><?php echo $value;?>：</span></div>
            <input type="text" class="form-control" name="<?php echo $key;?>" value="<?php echo $siteInfo[$key] ?? '';?>" />
        </div>
    	<?php } else { ?>
    	<div class="input-group margin-top-15">
            <div class="input-group-addon"><span><?php echo $value;?>：</span></div>
            <textarea type="text" class="form-control" name="<?php echo $key;?>"><?php echo $siteInfo[$key] ?? '';?></textarea>
        </div>
    	<?php } ?>
    	<?php } ?>
        <div class="input-group margin-top-15">
            <div class="input-group-addon"><span>网页置灰开始时间：</span></div>
            <input type="text" class="form-control" name="start_at" value="<?php echo !empty($siteInfo['gray_start_at']) ? date('Y-m-d', $siteInfo['gray_start_at']): '';?>" id="start_at" />
        </div>
         <div class="input-group margin-top-15">
            <div class="input-group-addon"><span>网页置灰开始时间：</span></div>
            <input type="text" class="form-control" name="end_at" value="<?php echo !empty($siteInfo['gray_end_at']) ? date('Y-m-d', $siteInfo['gray_end_at']): '';?>" id="end_at" />
        </div>
    	<button type="submit" class="btn btn-primary margin-top-15">保存</button>
	</form>
</div>
<script type="text/javascript">
$(function(){
    $('#start_at').datepicker({
        format: 'yyyy-mm-dd',
        language: 'zh-CN', //语言
        autoclose: true, //选择后自动关闭
        clearBtn: true,//清除按钮
        todayHighlight: true,
    });
    $('#end_at').datepicker({
        format: 'yyyy-mm-dd',
        language: 'zh-CN', //语言
        autoclose: true, //选择后自动关闭
        clearBtn: true,//清除按钮
        todayHighlight: true,
    });
});
</script>
<?php $this->load('Common.baseFooter');?>