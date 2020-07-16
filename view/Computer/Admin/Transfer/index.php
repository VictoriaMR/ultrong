<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
   <table class="table  table-hover table-middle margin-top-15">
        <tr>
        	<th class="col-md-1 col-1">ID</th>
            <th class="col-md-1 col-1">类型</th>
            <th class="col-md-4 col-4">名称</th>
            <th class="col-md-4 col-4">翻译</th>
            <th class="col-md-2 col-2">操作</th>
        </tr>
        <?php if (!empty($list['list'])) { ?>
        <?php foreach ($list['list'] as $key => $value){ ?>
            <tr data-tran_id="<?php echo $value['tran_id'];?>"
            	data-name="<?php echo $value['name'];?>"
            	data-type="<?php echo $value['type'];?>"
            	data-type_name="<?php echo $value['type_name'];?>"
            	data-value="<?php echo $value['value'];?>"
            >
                <td class="col-md-1 col-1"><?php echo $value['tran_id'];?></td>
                <td class="strong col-md-1 col-1"><?php echo $value['type_name'];?></td>
                <td class="strong col-md-4 col-4"><?php echo $value['name'];?></td>
                <td class="strong col-md-4 col-4"><?php echo $value['value'];?></td>
                <td class="col-md-2 col-2">
                    <button class="btn btn-primary btn-sm modify" type="button" ><i class="fa fa-edit"></i>修改</button>
                </td>
            </tr>
        <?php } ?>
    	<?php } else { ?>
    	<tr>
    		<td colspan="7" style="text-align: center;"><span style="color: orange;">暂无数据</span></td>
    	</tr>
    	<?php } ?>
    </table>
	<?php echo $pageBar;?>
</div>
<div id="dealbox">
    <form class="form-horizontal">
    	<input type="hidden" class="form-control" name="tran_id" value="0">
    	<input type="hidden" class="form-control" name="type" value="">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">编辑翻译</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>类型：</span></div>
            <input type="text" class="form-control" name="type_name" required="required" maxlength="30" disabled="disabled" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>名称：</span></div>
            <textarea class="form-control" name="name" required="required" value="" disabled="disabled"></textarea>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>翻译：</span></div>
            <textarea class="form-control" name="value" required="required" value=""></textarea>
        </div>
        <button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="<span class='glyphicon glyphicon-refresh'></span>">确认</button>
    </form>
</div>
<script type="text/javascript">
$(function(){
	$('#dealbox').offsetCenter();
	$('.modify').on('click', function(){
		$('#dealbox').show();
		initShow($(this).parents('tr').data());
	});
	$('#dealbox button.save').on('click', function(){
    	var check = true;
    	$(this).parent('form').find('[required=required]').each(function(){
    		var val = $(this).val();
    		if (val == '') {
    			check = false;
    			var name = $(this).prev().text();
    			POP.tips('请将'+name.slice(0, -1)+'填写完整');
    			$(this).focus();
    			return false;
    		}
    	});
    	if (!check) return false;
    	save();
    });
	/*
	 * 初始化编辑弹窗
	 */
	function initShow(data)
	{
		for (var i in data) {
			$('#dealbox [name="'+i+'"]').val(data[i]);
		}
	}
	//保存
	function save()
	{
		if ($('#dealbox button.save').find('.fa-spinner').length > 0) return false;
    	$('#dealbox button.save').html($('#dealbox button.save').data('loading-text'));
    	return;
    	$.post("<?php echo url('Printer/savePage');?>", $('#dealbox form').serializeArray(), function(res){
    		$('#dealbox button.save').html('确认');
    		if (res.code == 0) {
    			successTips(res.msg);
    			$('#dealbox').hide();
    			window.location.reload();
    		} else {
    			errorTips(res.msg);
    		}
    	});
	}
})
</script>
<?php $this->load('Common.baseFooter');?>