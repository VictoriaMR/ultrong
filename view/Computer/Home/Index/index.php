<?php load('Common.baseHeader');?>
<div id="slider-banner">
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
<div class="container">
    <div id="application">
        <ul>
            <li>
            	<a href="" class="block">
            		<div class="font-16 font-600">应用展示</div>
            		<div class="margin-top-15">
            			<img src="http://www.zongheng3d.com/images/callto-action/330-150-1.jpg" alt="">
            		</div>
            		<div class="margin-top-15 text-content">Now widely used in automotive, aircraft, aviation, footwear, dentistry, medical, hand-made, sculpture, construction and other fields!</div>
            	</a>
            </li>
            <li>
            	<a href="" class="block">
            		<div class="font-16 font-600">应用展示</div>
            		<div class="margin-top-15">
            			<img src="http://www.zongheng3d.com/images/callto-action/330-150-1.jpg" alt="">
            		</div>
            		<div class="margin-top-15 text-content">Now widely used in automotive, aircraft, aviation, footwear, dentistry, medical, hand-made, sculpture, construction and other fields!</div>
            	</a>
            </li>
            <li>
            	<a href="" class="block">
            		<div class="font-16 font-600">应用展示</div>
            		<div class="margin-top-15">
            			<img src="http://www.zongheng3d.com/images/callto-action/330-150-1.jpg" alt="">
            		</div>
            		<div class="margin-top-15 text-content">Now widely used in automotive, aircraft, aviation, footwear, dentistry, medical, hand-made, sculpture, construction and other fields!</div>
            	</a>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
	<div id="product-list">
		<div class="text-center">
            <span class="font-600 font-30 color-white"><?php echo dist('了解我们的产品');?></span>      
        </div>
	</div>
</div>

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