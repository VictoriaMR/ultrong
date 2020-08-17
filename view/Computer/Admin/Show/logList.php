<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
    <table class="table  table-hover table-middle margin-top-15">
        <tr>
        	<th class="col-md-1 col-1">ID</th>
            <!-- <th class="col-md-1 col-1">用户ID</th> -->
            <th class="col-md-1 col-1">语言</th>
            <th class="col-md-1 col-1">PC/移动端</th>
            <th class="col-md-2 col-2">ip</th>
            <th class="col-md-2 col-2">路径</th>
            <th class="col-md-1 col-1">设备</th>
            <th class="col-md-5 col-5">访问时间</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr>
                <td class="col-md-1 col-1"><?php echo $value['log_id'];?></td>
                <!-- <td class="col-md-1 col-1"><?php echo $value['user_id'];?></td> -->
                <td class="col-md-1 col-1"><?php echo $value['language'];?></td>
                <td class="col-md-1 col-1"><?php echo $value['is_moblie'] ? '移动端' : 'PC端';?></td>
                <td class="col-md-2 col-2"><?php echo $value['ip'];?></td>
                <td class="col-md-2 col-2"><?php echo $value['path'];?></td>
                <td class="col-md-1 col-1"><?php echo $value['user_agent'];?></td>
                <td class="col-md-2 col-2"><?php echo date('Y-m-d H:i:s', $value['create_at']);?></td>
            </tr>
        <?php } ?>
    	<?php } else { ?>
    	<tr>
    		<td colspan="8" style="text-align: center;"><span style="color: orange;">暂无数据</span></td>
    	</tr>
    	<?php } ?>
    </table>
	<?php echo $pageBar;?>
</div>
<?php $this->load('Common.baseFooter');?>