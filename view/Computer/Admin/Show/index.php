<?php $this->load('Common.baseHeader');?>
<div style="padding: 40px;">
	<p class="font-20">概览</p>
	<a class="block log-item left" href="<?php echo adminUrl('show/logList');?>">
		<p class="font-20 color-green"><?php echo $total;?></p>
		<p>访客总人数</p>
	</a>
	<a class="block log-item left" href="<?php echo adminUrl('show/logList');?>">
		<p class="font-20 color-green"><?php echo $monthTotal;?></p>
		<p>月度访客人数</p>
	</a>
	<a class="block log-item left" href="<?php echo adminUrl('show/logList');?>">
		<p class="font-20 color-green"><?php echo $dateTotal;?></p>
		<p>今日访客人数</p>
	</a>
	<div class="clear"></div>
	<p class="margin-top-20 font-20">按月统计</p>
	<?php foreach ($monthList as $key => $value) { ?>
	<a class="block log-item left" href="<?php echo adminUrl('show/logList', ['date'=>$key]);?>">
		<p class="font-20 color-green"><?php echo $value;?></p>
		<p><?php echo $key;?></p>
	</a>
	<?php } ?>
</div>
<?php $this->load('Common.baseFooter');?>