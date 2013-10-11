<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />




<div class="content-container">

    <div class="margin-container" style="margin-top: 60px;">
        <!--<div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        <div class="gallery-header">
            <?php if ($event_name == '10 Seconds') { ?>
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $event_id; ?>">
                <div class="gallery-logo-event ten-seconds"></div>
			</a>
            <?php } elseif ($event_name == 'Digital Idol') { ?>
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $event_id; ?>">
                <div class="gallery-logo-event digital-idol"></div>
			</a>
            <?php } else { ?>
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $event_id; ?>">
                <div class="gallery-logo-event your-project"></div>
			</a>
            <?php } ?>
            <div class="gallery-heading-title" style="width: auto;">Gallery</div>

            <div class="gallery-nav-container">
                <span class="gallery-nav-sort-span">sort by</span>
                <ul id="galleryNav">
                    <li><?php
                        if (isset($sort_by_date)) {
                            switch ($sort_by_date) {
                                case 'desc' :
                                    echo '<a class="sort_down" href="' . base_url() . 'wow/channel/roadshow/' . $event_id . '/oldest_date">Date</a>';
                                    break;
                                case 'asc' :
                                    echo '<a class="sort_up" href="' . base_url() . 'wow/channel/roadshow/' . $event_id . '/newest_date">Date</a>';
                                    break;
                                default :
                                    echo '<a href="' . base_url() . 'wow/channel/roadshow/' . $event_id . '/newest_date">Date</a>';
                                    break;
                            }
                        } else {
                            echo '<a href="' . base_url() . 'wow/channel/roadshow/' . $event_id . '/newest_date">Date</a>';
                        }
                        ?>
                    </li>
                    <li><a>Kind</a>
                        <ul>
                            <li><a>Photo</a></li>
                            <li><a>Video</a></li>
                        </ul>
                    </li>
                    <li><a>Event</a>
                        <ul>
                        <?php foreach ($gallery_categories as $gallery_category): ?>
                            <li><a><?php echo $gallery_category->category_name; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>

        <div class="gallery-type-title">
            <?php echo $which_name; ?>
        </div>

        <?php $i = 0;
        foreach ($items as $item): ?>
            <div class="gallery-video-container">
                <div class="gallery-video-thumb">
                    <a href="<?php echo site_url('wow/channel/detail_roadshow/' . $item->id); ?>">
                        <?php if (!$item->img_path) { ?>
                            <img src="<?php echo base_url('userfiles/wow') . '/news/roadshow_default.jpg'; ?>">
                        <?php } else { ?>
                            <img src="<?php echo base_url('userfiles/wow') . '/news/' . $item->img_path; ?>">
                        <?php } ?>

                        <?php if ($item->video_path) { ?>
                            <div class="gallery-overlay-play-icon"></div>
    <?php } ?>
                    </a>
                </div>
                <div class="gallery-video-title"><?php echo $item->news_title; ?></div>
                <div class="gallery-video-date">by @<?php echo $user_name; ?></div>
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

