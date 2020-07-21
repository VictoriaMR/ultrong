<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<div class="bottom15">
        <button class="btn btn-success addroot" type="button"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;添加新系统功能</button>
        <button class="btn btn-info subFeatureOpen" type="button"><span class="glyphicon glyphicon-list"></span>&nbsp;全部展开</button>
        <button class="btn btn-info subFeatureClose" type="button"><span class="glyphicon glyphicon-folder-close"></span>&nbsp;全部折叠</button>
    </div>
   	<table class="table  table-hover table-middle margin-top-15">
        <tr>
            <th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">系统功能名称</th>
            <th class="col-md-2 col-2">控制器名称(英文小写)</th>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-3 col-3">备注</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr
                data-con_id="<?php echo $value['con_id'];?>"
                data-parent_id="<?php echo $value['parent_id'];?>"
                data-name="<?php echo $value['name'];?>"
                data-name_en="<?php echo $value['name_en'];?>"
                data-status="<?php echo $value['status'];?>"
                data-icon="<?php echo $value['icon'];?>"
                data-remark="<?php echo $value['remark'];?>"
            >
            	<td class="col-md-1 col-1"><?php echo $value['con_id'];?></td>
            	<td class="col-md-2 col-2"><?php echo $value['name'];?></td>
            	<td class="col-md-2 col-2"><?php echo $value['name_en'];?></td>
            	<td class="col-md-1 col-1">
                    <?php if($value['status']){?>
                        <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-3 col-3">
                	<div><?php echo $value['remark'];?></div>
                </td>
                <td class="col-md-3 col-3">
                    <button class="btn btn-success btn-sm addroot" type="button" data-parent_id="<?php echo $value['con_id'];?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;新增</button>
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
        <input type="hidden" class="form-control" name="con_id" value="0">
        <input type="hidden" class="form-control" name="parent_id" value="0">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">新增功能</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>系统功能名称：</span></div>
            <input type="text" class="form-control" name="name" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>控制器名称(英文小写)：</span></div>
            <input type="text" class="form-control" name="name_en" required="required" maxlength="30" value="">
        </div>
         <div class="input-group">
            <div class="input-group-addon"><span>状态：</span></div>
            <div class="form-control" style="padding-top: 2px;">
                <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                <input type="hidden" name="status" value="1">
            </div>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>图标：</span></div>
            <select class="form-control" name="icon">
                <option value="">请选择</option>
                <?php foreach ($iconList as $key => $value) { ?>
                <option value="<?php echo $value['name'];?>">
                    <?php echo $value['name'];?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>备注：</span></div>
            <textarea class="form-control" name="remark" value=""></textarea>
        </div>
        <div class="margin-top-15">
            <button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="<span class='glyphicon glyphicon-refresh'></span>">确认</button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    FEATURE.init();
});
</script>
<?php $this->load('Common.baseFooter');?>