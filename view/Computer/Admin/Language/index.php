<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
	<div class="bottom15">
	    <button class="btn btn-success add" type="button"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;新增语言</button>
	</div>
	<table class="table  table-hover table-middle margin-top-15">
        <tr>
            <th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">名称</th>
            <th class="col-md-1 col-1">值</th>
            <th class="col-md-1 col-1">状态</th>
            <th class="col-md-1 col-1">是否默认</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr
                data-lan_id="<?php echo $value['lan_id'];?>"
                data-name="<?php echo $value['name'];?>"
                data-value="<?php echo $value['value'];?>"
                data-status="<?php echo $value['status'];?>"
                data-is_default="<?php echo $value['is_default'];?>"
            >
            	<td class="col-md-1 col-1"><?php echo $value['lan_id'];?></td>
            	<td class="col-md-2 col-2"><?php echo $value['name'];?></td>
            	<td class="col-md-1 col-1"><?php echo $value['value'];?></td>
            	<td class="col-md-1 col-1">
                    <?php if($value['status']){?>
                        <div class="switch_botton status" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton status" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-1 col-1">
                	<?php if($value['is_default']){?>
                        <div class="switch_botton default" data-status="1"><div class="switch_status on"></div></div>
                    <?php }else{?>
                        <div class="switch_botton default" data-status="0"><div class="switch_status off"></div></div>
                    <?php }?>
                </td>
                <td class="col-md-3 col-3">
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
<script>
$(function(){
	LANGUAGE.init();
})
</script>
<?php $this->load('Common.baseFooter');?>