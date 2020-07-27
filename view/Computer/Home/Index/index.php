<?php $this->load('Common.baseHeader');?>
<?php if (!empty($banner)) { ?>
<div id="slider-banner">
    <ul>
        <?php foreach ($banner['content'] as $key => $value) { ?>
        <li class="slider">
            <div style="width: 100%; display: table;background-color: <?php echo $value['background'] ?? '#000';?>;">
                <a class="block" href="<?php echo $value['href'] ?? 'javascript:;';?>">
                    <img src="<?php echo $value['url'];?>">
                </a>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
<script type="text/javascript">
$(function(){
	//轮播图
    $('#slider-banner').slider({
        dots: true,
        fluid: true
    });
});
</script>
<?php $this->load('Common.baseFooter');?>