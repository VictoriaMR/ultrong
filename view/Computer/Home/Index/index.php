<?php load('Common.baseHeader');?>
<div id="banner" class="hide">
    <ul>
        <li class="slider">
            <img src="<?php echo siteUrl('image/computer/01.jpg');?>">
        </li>
        <li class="slider">
            <img src="<?php echo siteUrl('image/computer/02.jpg');?>">
        </li>
        <li class="slider">
            <img src="<?php echo siteUrl('image/computer/03.jpg');?>">
        </li>
        <li class="slider">
            <img src="<?php echo siteUrl('image/computer/04.jpg');?>">
        </li>
        <li class="slider">
            <img src="<?php echo siteUrl('image/computer/05.jpg');?>">
        </li>
    </ul>
</div>

<script type="text/javascript">
$(function(){
	//轮播图
    $('#banner').slider({
        dots: true,
        fluid: true
    });
});
</script>
<?php $this->load('Common.baseFooter');?>