<?php
if (!defined('TYPE_VIDEO')){
    define ('TYPE_VIDEO', 'video');
}
if (!defined('TYPE_IMAGE')){
    define ('TYPE_IMAGE', 'image');
}
?>
<style type="text/css">
    .active-title{font-style: italic; color: red;}
    .active-order{background-color: red; color: white;}
</style>
<!-- photo swipe -->
<link href="<?php echo config_item('assets_wow'); ?>photoswipe/photoswipe.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>photoswipe/lib/klass.min.js"></script>
<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>photoswipe/code.photoswipe-3.0.5.min.js"></script>
<script>
(function(window, PhotoSwipe){
	document.addEventListener('DOMContentLoaded', function(){
		var
			options = {},
			instance = PhotoSwipe.attach( window.document.querySelectorAll('#Gallery a'), options );
	}, false);
}(window, window.Code.PhotoSwipe));
</script>
<!-- end of photo swipe -->
<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />

<div class="content-container">

    <div class="margin-container" style="margin-top: 60px;">
        <div class="gallery-header">
            <!--
			<?php if(isset($filter)): ?>
                <?php if ($filter->event_name == '10 Seconds') {?>
                <div class="gallery-logo-event ten-seconds"></div>
                <?php } elseif($filter->event_name == 'Digital Idol') {?>
                <div class="gallery-logo-event digital-idol"></div>
                <?php } else {?>
                <div class="gallery-logo-event your-project"></div>
                <?php } ?>
            <?php else: ?>
                <div class="gallery-logo-event your-project"></div>
            <?php endif; ?>
            -->
            <div class="gallery-heading-title" style="width: auto;">
                <a href="<?php echo $gallery_home_url; ?>"><?php echo $filter->event_name; ?> Album</a>
            </div>

            <div class="gallery-nav-container">
                <span class="gallery-nav-sort-span">sort by</span>
                
                <ul id="galleryNav">
                    <li>
                        <a href="<?php echo $base_url_thumb->date;?>" class="<?php echo $filter->date_order=='desc'?'sort_down':'sort_up';?>">Date</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="gallery-type-title">
            <?php echo $filter->gallery_category_name; ?>
			<?php if($gallery_item->title){ echo " > ".$gallery_item->title; } ?>
        </div>

        <?php $i = 0;
        foreach ($items as $item): ?>
            <div class="gallery-video-container">
                <div class="gallery-video-thumb" id="Gallery">
					<a href="<?php echo config_item('userfiles') . 'wow/gallery/image/'. $item->file_name; ?>"><img src="<?php echo config_item('userfiles') . 'wow/gallery/image/'. $item->file_name; ?>" alt="<?php echo $item->file_name; ?>" /></a>
                    <!-- <a href="javascript:void(0);">
                        <img src="<?php echo config_item('userfiles') . 'wow/gallery/image/'. $item->file_name; ?>">
                    </a> -->
                </div>
                <div class="gallery-video-title"><?php echo $item->title; ?></div>
                <div class="gallery-video-date"><?php echo indonesia_date_format("D, d M Y", strtotime($item->date_time)); ?></div>
            </div>
        <?php endforeach; ?>

<?php if ($pagination): ?>
            <div style="width: 100%; height: auto; float : left;">
                <table align="center">
                    <tr>
                        <td>
    <?php echo $pagination; ?>
                        </td>
                    </tr>
                </table>
            </div>
<?php endif; ?>



    </div>
</div>

<?php if (isset($page)) $this->load->view('channel/wow/page/footer'); ?>

