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
<?php if (!empty($cateList)) { ?>
<div class="container">
    <?php foreach ($cateList as $key => $value) {?>
    <div class="category-item margin-top-30">
        <div class="text-center">
            <div class="font-24 font-600"><?php echo dist($value['name']);?></div>
            <div class="font-16 margin-top-3"><?php echo dist($value['remark']);?></div>
        </div>
        <div class="bg-f5 category-product margin-top-10">
            <div class="product-box">
                <ul>
                    <?php foreach ($value['product'] as $k => $v) { ?>
                    <li class="slider">
                        <a class="square" href="<?php echo url('product', ['pro_id'=>$v['pro_id'], 'lan_id' => $v['lan_id']]);?>">
                            <img src="<?php echo $v['image'];?>" alt="<?php echo $v['name'];?>">
                        </a>
                        <a class="block product-title" href="<?php echo url('product', ['pro_id'=>$v['pro_id'], 'lan_id' => $v['lan_id']]);?>">
                            <div class="font-18 word-ellipsis-1"><?php echo $v['name'];?></div>
                            <div class="font-14 margin-top-10 word-ellipsis-5"><?php echo $v['desc'];?></div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <span class="icon ant2-icon prev-stay left"></span>
            <span class="icon ant2-icon next-stay right"></span>
        </div>
    </div>
    <?php } ?>
</div>
<?php }?>
<script type="text/javascript">
$(function(){
    INDEX.init();
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