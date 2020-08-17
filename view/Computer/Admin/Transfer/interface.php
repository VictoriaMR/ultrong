<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
    <div>
        <button type="button" class="btn btn-success btn-sm add">新增接口</button>
    </div>
    <table class="table  table-hover table-middle margin-top-15">
        <tr>
        	<th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">名称</th>
            <th class="col-md-2 col-2">APPID</th>
            <th class="col-md-2 col-2">APPKEY</th>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-1 col-1">检查</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr data-tc_id="<?php echo $value['tc_id'];?>"
            	data-name="<?php echo $value['name'];?>"
            	data-app_id="<?php echo $value['app_id'];?>"
            	data-app_key="<?php echo $value['app_key'];?>"
            	data-status="<?php echo $value['status'];?>"
                <?php if (empty($value['checked'])) { ?>
                    class="danger"
                <?php } ?>
            >
                <td class="col-md-1 col-1"><?php echo $value['tc_id'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['name'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['app_id'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['app_key'];?></td>
                <td class="col-md-1 col-1">
                    <?php if($value['status']){?>
                        <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-1 col-1">
                    <?php if($value['checked']){?>
                        <div class="switch_botton checked" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton checked" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-2 col-2">
                    <button class="btn btn-primary btn-sm modify" type="button" ><span class="glyphicon glyphicon-edit"></span>&nbsp;修改</button>
                    <button class="btn btn-danger btn-sm delete" type="button" ><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</button>
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
<div id="dealbox" style="display: none;">
    <form class="form-horizontal">
    	<input type="hidden" class="form-control" name="tc_id" value="0">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">新增接口</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>名称：</span></div>
            <input type="text" class="form-control" name="name" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>APP_ID：</span></div>
            <textarea class="form-control" name="app_id" required="required" value=""></textarea>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>APP_KEY：</span></div>
            <textarea class="form-control" name="app_key" required="required" value=""></textarea>
        </div>
        <div class="margin-top-15">
        	<button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="<span class='glyphicon glyphicon-refresh'></span>">确认</button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(function(){
	INTERFACE.init();
})
</script>
<?php $this->load('Common.baseFooter');?>