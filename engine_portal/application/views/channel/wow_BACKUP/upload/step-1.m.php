<style>
.tengah{
	margin-left: auto;
	margin-right: auto;
	float: none;
	width: 100%;
}
.kecil {
	width: 600px;
} 
</style>
<div class="container kecil">
    <div class="button-list tengah">
        <?php if (isset($categories)):?>
        <?php foreach($categories as $category):?>
        <a class="wow-event" href="javascript:void(0);" onclick="goNext(<?php echo $category->category_id; ?>);" data="<?php echo $category->category_id; ?>">
            <img src="<?php echo config_item('assets_wow').'images/'. $category->image_preview;?>" height="30" width="150"/>
        </a>
        <?php endforeach; ?>
        <?php endif;?>
    </div>
</div>