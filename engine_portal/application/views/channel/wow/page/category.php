<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />




<div class="content-container">
    
    <div class="margin-container" style="margin-top: 80px;">
        <div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>
        
        <div class="left-sidebar">
            <?php if($category_title == '10 Seconds' ) { ?>
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-10-second-big.png">
            <?php } elseif( $category_title == 'Digital Idol' ) { ?>
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-digital-idol.png">
            <?php } else { ?>
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-your-project.png">
            <?php } ?>
            
        </div>
        <div class="right-sidebar">
            <div class="statik-title-big"><?php echo $category_title; ?></div>
            <div class="underline-red thin"></div>
            <div class="statik-content">
                <?php echo $content; ?>
            </div>
            
            
        </div>
    </div>
</div>
<div class="sidebar-bottom-bg">
    <div class="margin-container" style="height: 340px;">
        <div class="sidebar-bottom-left">
            <div class="sidebar-bottom-title">Judge</div>
            <div class="etalase-sidebar-bottom-left">
                <div class="etalase-image-thumb">
                    <img src="<?php echo config_item('assets_wow')?>css/img/sampel-image-3.jpg">
                </div>
                <div class="etalase-desc-container">
                    <div class="etalase-desc-title">
                        @JokoAnwar
                    </div>
                    <div class="etalase-desc-text">
                        Morbi pharetra odio in libero varius soluta nobis eleifend venenatis mauris vel tellus arcu  <a href="#">#wow10sec</a>
                    </div>
                </div>
            </div>
            <div class="etalase-sidebar-bottom-left">
                <div class="etalase-image-thumb">
                    <img src="<?php echo config_item('assets_wow')?>css/img/sampel-image-4.jpg">
                </div>
                <div class="etalase-desc-container">
                    <div class="etalase-desc-title">
                        @RadityaDika
                    </div>
                    <div class="etalase-desc-text">
                        Morbi pharetra odio in libero varius venenatis mauris vel tellus arcu <a href="#">#wow10sec</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar-bottom-center">
            <div class="sidebar-bottom-title">Playtime</div>
            <div class="playtime-thumb">
                <a href="#">
                    <img src="<?php echo config_item('assets_wow') ?>css/img/sampel-image-2.jpg">
                    <div class="overlay-play-icon"></div>
                </a>
            </div>
            <div class="etalase-desc-title">
                Ikuti WOW Project dan Raih Hadiahnya.
            </div>
            <div class="etalase-desc-text">
                Posted 3 day ago
            </div>
        </div>
        
        <div class="sidebar-bottom-right">
            <div class="sidebar-bottom-title">Twitter feed</div>
            <div class="twitter-feed-heading">
                <a href="#" class="icon-twitter-circle-grey"></a>
                <div class="twitter-feed-title">
                    @UzoneWOWProject
                </div>
                <div class="twitter-feed-text">
                    Join our conversation on twitter with hashtag: <a href="#">#Wow10Sec</a>
                </div>
                <a href="#" class="follow-red-button">Follow</a>
            </div>
            <div class="twitter-feed-timeline">
                <div id="myslider1" class="myslider1">
                    <div id="myslider-content">

                        <div class='slide1 container-item'>
                            <a href="#">
                                <img class="rounded" src="<?php echo config_item('assets_wow') ?>css/img/sampel-image-2.jpg">
                            </a>
                            <div class="news-container">
                                <div class="slider-title-news">Test <a href="#">@TestUser</a></div>
                                <div class="slider-desc-news">Lorem ipsum dolor sit amet, <a href="#">#hashtag</a> onsectetur adipiscing elit. Quisque tincidunt dictum ligula, in blandit elit. Maecenas dictum, orci vitae aliquam euismod, urna erat venenatis eros.</div>
                                <div class="slider-nav-twit">
                                    Posted on 12:15 am
                                    <a class="nav-twit-item" href="#">Reply</a>
                                    <a class="nav-twit-item" href="#">Retweet</a>
                                    <a class="nav-twit-item" href="#">Favorite</a>
                                </div>
                            </div>
                        </div>
                        <div class='slide1 container-item'>
                            <a href="#">
                                <img class="rounded" src="<?php echo config_item('assets_wow') ?>css/img/sampel-image-2.jpg">
                            </a>
                            <div class="news-container">
                                <div class="slider-title-news">Test <a href="#">@TestUser</a></div>
                                <div class="slider-desc-news">Lorem ipsum dolor sit amet, <a href="#">#hashtag</a> onsectetur adipiscing elit. Quisque tincidunt dictum ligula, in blandit elit. Maecenas dictum, orci vitae aliquam euismod, urna erat venenatis eros.</div>
                                <div class="slider-nav-twit">
                                    Posted on 12:15 am
                                    <a class="nav-twit-item" href="#">Reply</a>
                                    <a class="nav-twit-item" href="#">Retweet</a>
                                    <a class="nav-twit-item" href="#">Favorite</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#myslider1').swipePlanes();
</script>
