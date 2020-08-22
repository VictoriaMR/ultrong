<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<div class="bottom15">
        <button class="btn btn-success addroot" type="button"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;添加新分类</button>
    </div>
   	<table class="table  table-hover table-middle margin-top-15">
        <tr>
            <th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">分类名称</th>
            <th class="col-md-2 col-2">分类名称(英文)</th>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-1 col-1">前端展示</th>
            <th class="col-md-3 col-3">备注</th>
            <th class="col-md-2 col-2">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr
                data-cate_id="<?php echo $value['cate_id'];?>"
                data-parent_id="<?php echo $value['parent_id'];?>"
                data-name="<?php echo $value['name'];?>"
                data-name_en="<?php echo $value['name_en'];?>"
                data-status="<?php echo $value['status'];?>"
                data-is_index="<?php echo $value['is_index'];?>"
                data-remark="<?php echo $value['remark'];?>"
            >
            	<td class="col-md-1 col-1"><?php echo $value['cate_id'];?></td>
            	<td class="col-md-2 col-2"><?php echo $value['name'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['name_en'];?></td>
            	<td class="col-md-1 col-1">
                    <?php if($value['status']){?>
                        <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-1 col-1">
                    <?php if($value['is_index']){?>
                        <div class="switch_botton is_index" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton is_index" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-3 col-3">
                	<div><?php echo $value['remark'];?></div>
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
</div>
<div id="dealbox" style="display: none;">
    <form class="form-horizontal">
        <input type="hidden" class="form-control" name="cate_id" value="0">
        <input type="hidden" class="form-control" name="parent_id" value="0">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 class="margin-bottom-15">新增分类</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>分类名称：</span></div>
            <input type="text" class="form-control" name="name" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>分类名称(英文)：</span></div>
            <input type="text" class="form-control" name="name_en" required="required" maxlength="30" value="">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>状态：</span></div>
            <div class="form-control" style="width: 212px;">
                <div class="switch_botton" data-status="1"><div class="switch_status on"></div></div>
                <input type="hidden" name="status" value="1">
            </div>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>前端展示：</span></div>
            <div class="form-control" style="width: 184px;">
                <div class="switch_botton" data-status="0"><div class="switch_status off"></div></div>
                <input type="hidden" name="is_index" value="0">
            </div>
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>备注：</span></div>
            <textarea class="form-control" name="remark" value=""></textarea>
        </div>
        <div class="margin-top-15">
            <button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="loading..">确认</button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
    CATEGORY.init();
});
</script>
<?php $this->load('Common.baseFooter');?>