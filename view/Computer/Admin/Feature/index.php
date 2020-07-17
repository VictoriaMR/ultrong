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
            <th class="col-md-2 col-2">控制器名称</th>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-3 col-3">排序</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr>
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
                	
                </td>
                <td class="col-md-3 col-3">
                	
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
<?php $this->load('Common.baseFooter');?>