<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
   	<table class="table table-condensed table-hover table-middle margin-top-15" style="border-bottom: 1px solid #ddd;">
        <tr>
            <th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">聊天组key</th>
            <th class="col-md-4 col-4">成员</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr
                data-message_id="<?php echo $value['message_id'];?>"
                data-user_id="<?php echo $value['user_id'];?>"
                data-follow="<?php echo $value['follow'];?>"
                data-group_key="<?php echo $value['group_key'];?>"
            >
            	<td class="col-md-1 col-1"><?php echo $value['group_id'];?></td>
            	<td class="col-md-2 col-2"><?php echo $value['group_key'];?></td>
                <td class="col-md-4 col-4">
                    <?php foreach ($value['member_list'] as $mk => $mv) { ?>
                    <div class="flex margin-bottom-10">
                        <div class="margin-right-10" style="height: 50px;width: 50px;">
                            <img src="<?php echo $mv['user_avatar'];?>">
                        </div>
                        <div>
                            <?php echo $mv['user_id'];?>
                            <?php if (!empty($mv['user_nickname'])) { ?>
                            <?php echo '-'.$mv['user_nickname'];?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </td>
                <td class="col-md-3 col-3">
                	<?php if ($value['can_change']) { ?>
                    <button class="btn btn-success btn-sm change-btn" type="button" data-parent_id="<?php echo $value['cate_id'];?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;转让</button>
                	<?php } ?>
                	<a class="btn btn-primary btn-sm modify-btn" type="button" href="<?php echo adminUrl('message/groupInfo', ['group_key'=>$value['group_key']]);?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;查看</a>
                </td>
            </tr>
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
        <input type="hidden" class="form-control" name="group_key" value="">
        <input type="hidden" class="form-control" name="follow" value="">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">转让</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>原客服：</span></div>
            <input type="text" class="form-control" name="follow" disabled="disabled">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>人员列表：</span></div>
            <select class="form-control" name="to" required="required">
            <?php foreach ($member_list as $key => $value) { ?>
                <option value="<?php echo $value['mem_id'];?>"><?php echo $value['mem_id'];?>-<?php echo $value['nickname'];?></option>
            <?php }?>
            </select>
        </div>
        <div class="margin-top-15">
            <button type="button" class="btn btn-primary btn-lg btn-block group save" data-loading-text="loading..">确认</button>
        </div>
    </form>
</div>
<script type="text/javascript">
MESSAGE.init();
</script>
<?php $this->load('Common.baseFooter');?>