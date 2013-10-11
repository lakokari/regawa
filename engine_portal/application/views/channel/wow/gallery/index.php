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
<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />

<div class="content-container">

    <div class="margin-container" style="margin-top: 60px;">
        <div class="gallery-header">
            <div class="gallery-heading-title" style="width: auto;font-size:35px;">
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $get_event_id; ?>">
			<?php echo $filter->event_name; ?> Gallery
			</a>
			</div>

            <div class="gallery-nav-container">
                <span class="gallery-nav-sort-span">sort by</span>
                
                <ul id="galleryNav">
                    <li>
                        <a href="<?php echo $base_url_thumb->date;?>" class="<?php echo $filter->date_order=='desc'?'sort_down':'sort_up';?>">Date</a>
                    </li>
                    <li><a>Kind &lt;<span class="active-title"><?php echo $filter->kind==TYPE_IMAGE?'Photo':'Video';?></span>&gt;</a>
                        <ul>
                            <li<?php echo $filter->kind==TYPE_IMAGE?' class="active-order"':'';?>>
                                <a href="<?php echo $base_url_thumb->kind;?>&kind=<?php echo TYPE_IMAGE;?>">Photo ALbum</a>
                            </li>
                            <li<?php echo $filter->kind==TYPE_VIDEO?' class="active-order"':'';?>>
                                <a href="<?php echo $base_url_thumb->kind;?>&kind=<?php echo TYPE_VIDEO;?>">Video</a>
                            </li>
                        </ul>
                    </li>
                    <li><a>Event <?php echo $filter->gallery_category_id ? '&lt;<span class="active-title">'.$filter->gallery_category_name.'</span>&gt;':'';?></a>
                        <ul>
                            <li>
                                <a href="<?php echo $base_url_thumb->category; ?>">All</a>
                            </li>
                            <?php foreach ($gallery_categories as $gallery_category): ?>
                            <li<?php echo ($filter->gallery_category_id && $gallery_category->id==$filter->gallery_category_id)?' class="active-order"':''; ?>>
                                <a href="<?php echo $base_url_thumb->category; ?>&category=<?php echo $gallery_category->id; ?>"><?php echo $gallery_category->category_name; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>

        <div class="gallery-type-title">
            <?php echo $event_selected->name; ?>
			<?php if($filter->kind){ echo " > ".$filter->kind; } ?>
			<?php if($filter->gallery_category_name){ echo " > ".$filter->gallery_category_name; } ?>
        </div>

        <?php $i = 0;
        foreach ($items as $item): ?>
            <div class="gallery-video-container">
                <div class="gallery-video-thumb">
                    <a href="<?php echo site_url('wow/gallery/detail/'.$item->item_type.'/' . $item->id); ?>">
                        <?php if (!$item->cover_image) { ?>
                        <img src="<?php echo config_item('userfiles') . 'wow/news/roadshow_default.jpg'; ?>">
                        <?php } else { ?>
                            <img src="<?php echo config_item('userfiles') . 'wow/gallery/image/'. $item->cover_image; ?>">
                        <?php } ?>

                        <?php if ($item->item_type=='video') { ?>
                            <div class="gallery-overlay-play-icon"></div>
                        <?php }else{ ?>
                            <div class="gallery-overlay-play-icon"></div>
                        <?php } ?>
                    </a>
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

