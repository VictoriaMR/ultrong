<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<div class="bottom15">
        <button class="btn btn-success addroot-btn" type="button"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;新增分类</button>
        <button class="btn btn-info all-open" type="button"><span class="glyphicon glyphicon-list"></span>&nbsp;全部展开</button>
        <button class="btn btn-info all-close" type="button"><span class="glyphicon glyphicon-folder-close"></span>&nbsp;全部折叠</button>
    </div>
   	<table class="table table-condensed table-hover table-middle margin-top-15" style="border-bottom: 1px solid #ddd;">
        <tr>
            <th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">名称</th>
            <th class="col-md-2 col-2">名称(英文)</th>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr
                data-cate_id="<?php echo $value['cate_id'];?>"
                data-parent_id="<?php echo $value['parent_id'];?>"
                data-name="<?php echo $value['name'];?>"
                data-name_en="<?php echo $value['name_en'];?>"
                data-status="<?php echo $value['name'];?>"
                class="parent"
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
                <td class="col-md-3 col-3">
                    <button class="btn btn-success btn-sm addroot-btn" type="button" data-parent_id="<?php echo $value['cate_id'];?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;新增</button>
                	<button class="btn btn-primary btn-sm modify-btn" type="button" ><span class="glyphicon glyphicon-edit"></span>&nbsp;修改</button>
                    <button class="btn btn-danger btn-sm delete-btn" type="button" ><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</button>
                </td>
            </tr>
            <?php if (!empty($value['son'])) { ?>
            <?php foreach ($value['son'] as $k => $v) {?>
            <tr
                data-cate_id="<?php echo $v['cate_id'];?>"
                data-parent_id="<?php echo $v['parent_id'];?>"
                data-name="<?php echo $v['name'];?>"
                data-status="<?php echo $v['name'];?>"
                class="son"
                style="display: none; background: #fffcfc;"
            >
                <td class="col-md-1 col-1"><?php echo $v['cate_id'];?></td>
                <td class="col-md-2 col-2" style="padding-left: 20px;"><?php echo $v['name'];?></td>
                <td class="col-md-1 col-1">
                    <?php if($v['status']){?>
                        <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-2 col-2">
                    <button class="btn btn-primary btn-sm modify-btn" type="button" ><span class="glyphicon glyphicon-edit"></span>&nbsp;修改</button>
                    <button class="btn btn-danger btn-sm delete-btn" type="button" ><span class="glyphicon glyphicon-trash hidden"></span>&nbsp;删除</button>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        <?php } ?>
    	<?php } else { ?>
    	<tr>
    		<td colspan="4" style="text-align: center;"><span style="color: orange;">暂无数据</span></td>
    	</tr>
    	<?php } ?>
    </table>
	<?php echo $pageBar;?>
</div>
<div id="dealbox" style="display: none;">
    <form class="form-horizontal">
        <input type="hidden" class="form-control" name="cate_id" value="0">
        <input type="hidden" class="form-control" name="parent_id" value="0">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">新增分类</h3>
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
            <div class="form-control" style="padding-top: 2px;width: 210px;">
                <div class="switch_botton status" data-status="1" style="margin-top: 8px;">
                    <div class="switch_status on"></div>
                </div>
                <input type="hidden" name="status" value="1">
            </div>
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