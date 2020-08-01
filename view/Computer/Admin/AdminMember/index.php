<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<?php if ($is_super) { ?>
    <div class="bottom15">
        <button class="btn btn-primary add" data-loading-text="Loading..." type="button"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;新增人员</button>
    </div>
	<?php } ?>
	<form action="<?php echo adminUrl('adminMember');?>" method="post" class="form-horizontal">
		<div class="row margin-top-15">
            <div class="col-md-4">
            	<div class="input-group">
		            <div class="input-group-addon"><span>关键字：</span></div>
		            <input type="text" class="form-control" name="keyword" maxlength="30" value="<?php echo $keyword;?>">
		        </div>
            </div>
            <div class="col-md-2">
            	<button class="btn btn-info" type="submit"><span class="glyphicon glyphicon-hourglass"></span> 查询</button>
            </div>
        </div>
	</form>
	<table class="table  table-hover table-middle margin-top-15">
        <tr>
        	<th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">名称</th>
            <th class="col-md-2 col-2">昵称</th>
            <th class="col-md-2 col-2">手机</th>
            <?php if ($is_super) { ?>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-1 col-1">超级管理员</th>
            <th class="col-md-2 col-2">操作</th>
            <?php } ?>
        </tr>
        <?php if (!empty($list['list'])) { ?>
        <?php foreach ($list['list'] as $key => $value){ ?>
            <tr data-mem_id="<?php echo $value['mem_id'];?>"
            	data-name="<?php echo $value['name'];?>"
            	data-nickname="<?php echo $value['nickname'];?>"
                data-mobile="<?php echo $value['mobile'];?>"
            	data-status="<?php echo $value['status'];?>"
            	data-is_super="<?php echo $value['is_super'];?>"
            >
                <td class="col-md-1 col-1"><?php echo $value['mem_id'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['name'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['nickname'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['mobile'];?></td>
                <?php if ($is_super) { ?>
                <td class="col-md-1 col-1">
                <?php if ($value['mem_id'] != $self_id) { ?>
                    <?php if($value['status']){?>
                        <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                <?php } ?>
                </td>
                <td class="col-md-1 col-1">
                <?php if ($value['mem_id'] != $self_id) { ?>
                    <?php if($value['is_super']){?>
                        <div class="switch_botton is_super" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton is_super" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                <?php } ?>
                </td>
                <td class="col-md-2 col-2">
                <?php if ($value['mem_id'] != $self_id && $value['is_super']) { ?>
                    <button class="btn btn-primary btn-sm modify" type="button" ><span class="glyphicon glyphicon-edit"></span>&nbsp;修改</button>
                <?php } ?>
                </td>
                <?php } ?>
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
    	<input type="hidden" class="form-control" name="mem_id" value="0">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">新增管理员</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>名称：</span></div>
            <input type="text" class="form-control" name="name" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>昵称：</span></div>
            <input type="text" class="form-control" name="nickname" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>手机：</span></div>
            <input type="text" class="form-control" name="mobile" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>初始密码：</span></div>
            <input type="text" class="form-control" name="password" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>状态：</span></div>
            <div class="form-control" style="padding-top: 2px; width: 210px;">
                <div class="switch_botton" data-status="0"><div class="switch_status on"></div></div>
                <input type="hidden" name="status" value="1">
            </div>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>超级管理员：</span></div>
            <div class="form-control" style="padding-top: 2px; width: 169px">
                <div class="switch_botton" data-status="0"><div class="switch_status off"></div></div>
                <input type="hidden" name="is_super" value="0">
            </div>
        </div>
        <div class="clear"></div>
        <div class="margin-top-15">
        	<button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="loading...">确认</button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(function(){
	ADMINMEMBER.init();
})
</script>
<?php $this->load('Common.baseFooter');?>