<?php $this->load('Common.baseHeader');?>
<?php if (!empty($banner)) { ?>
<div id="slider-content">
    <ul class="slider-box">
        <?php foreach ($banner['content'] as $key => $value) { ?>
        <li class="slider">
            <div style="background-color: <?php echo $value['background'] ?? '#000';?>;">
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
    $('#slider-content').slider({
        dots: true,
        fluid: true,
        items: '.slider',
        width: '100vw',
    });
});
</script>
<?php $this->load('Common.baseFooter');?>