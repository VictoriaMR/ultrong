<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
   	<table class="table table-condensed table-hover table-middle margin-top-15" style="border-bottom: 1px solid #ddd;">
        <tr>
            <th class="col-md-1 col-1">ID</th>
            <th class="col-md-2 col-2">聊天组key</th>
            <th class="col-md-1 col-1">发送人</th>
            <th class="col-md-3 col-3">消息</th>
            <th class="col-md-3 col-3">操作</th>
        </tr>
        <?php if (!empty($list)) { ?>
        <?php foreach ($list as $key => $value){ ?>
            <tr
                data-message_id="<?php echo $value['message_id'];?>"
                data-user_id="<?php echo $value['user_id'];?>"
                data-group_key="<?php echo $value['group_key'];?>"
                data-content="<?php echo $value['content'];?>"
            >
            	<td class="col-md-1 col-1"><?php echo $value['message_id'];?></td>
            	<td class="col-md-2 col-2"><?php echo $value['group_key'];?></td>
                <td class="col-md-1 col-1"><?php echo $value['user_name'];?></td>
                <td class="col-md-3 col-3"><?php echo $value['content'];?></td>
                <td class="col-md-3 col-3">
                	<?php if ($value['can_replay']) { ?>
                    <button class="btn btn-success btn-sm replay-btn" type="button"><span class="glyphicon glyphicon-plus"></span>&nbsp;回复</button>
                	<?php } ?>
                	<a class="btn btn-primary btn-sm modify-btn" type="button" href="<?php echo adminUrl('message/groupInfo', ['group_key'=>$value['group_key']]);?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;查看</a>
                </td>
            </tr>
        <?php } ?>
    	<?php } else { ?>
    	<tr>
    		<td colspan="5" style="text-align: center;"><span style="color: orange;">暂无数据</span></td>
    	</tr>
    	<?php } ?>
    </table>
	<?php echo $pageBar;?>
</div>
<div id="dealbox" style="display: none;">
    <form class="form-horizontal">
        <input type="hidden" class="form-control" name="group_key" value="">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h3 style="margin-top: 0px;">回复</h3>
        <div class="input-group">
            <div class="input-group-addon"><span>咨询：</span></div>
            <input type="text" class="form-control" name="content" disabled="disabled">
        </div>
        <div class="input-group">
            <div class="input-group-addon"><span>回复：</span></div>
            <textarea type="text" class="form-control" name="replay" required="required" maxlength="150">
            </textarea>
        </div>
        <div class="margin-top-15">
            <button type="button" class="btn btn-primary btn-lg btn-block save" data-loading-text="loading..">确认</button>
        </div>
    </form>
</div>
<script type="text/javascript">
	MESSAGE.init();
</script>
<?php $this->load('Common.baseFooter');?>