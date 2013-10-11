<?php $i = 1; if (isset($categories)):?>
    <?php foreach($categories as $category):?>
        <?php if($i==1) {?>
		<!--
            <div class="circle-container">
                <a class="upload-circle-button your-project" href="javascript:void(0);" onclick="goNext(<?php echo $category->category_id; ?>);" data="<?php echo $category->category_id; ?>"></a>
                <div class="circle-title"><?php echo $category->category_title; ?></div>
                <div class="circle-desc">
                    <?php echo $category->synopsis_category; ?>
                </div>
            </div>
		-->
        <?php }elseif($i==2) { ?>
            <div class="circle-container">
                <a class="upload-circle-button digital-idol" href="javascript:void(0);" onclick="goNext(<?php echo $category->category_id; ?>);" data="<?php echo $category->category_id; ?>"></a>
                <div class="circle-title"><?php //echo $category->category_title; ?>DIGITAL IDOL</div>
                <div class="circle-desc">
                    <?php echo $category->synopsis_category; ?>
                </div>
            </div>
        <?php }elseif($i==3) { ?>
            <div class="circle-container">
                <a class="upload-circle-button movie-project" href="javascript:void(0);" onclick="goNext(<?php echo $category->category_id; ?>);" data="<?php echo $category->category_id; ?>"></a>
                <div class="circle-title"><?php //echo $category->category_title; ?>wow 10seconds</div>
                <div class="circle-desc">
                    <?php echo $category->synopsis_category; ?>
                </div>
            </div>
        <?php } ?>
    <?php $i++; endforeach; ?>
<?php endif;?>


<div class="circle-container">
    <a href="<?php echo site_url('wow/channel/comingsoon'); ?>" class="upload-circle-button next-project" ></a>
    <div class="circle-title">Next Project</div>
    <div class="circle-desc">
        Bersiaplah untuk ikut tantangan berikutnya di Wow Competition. Siapkan diri kamu di Proyek Selanjutnya. 
    </div>
</div>
