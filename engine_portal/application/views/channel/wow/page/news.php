<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />
<style>
	.news-title-big {
		width: 100%;
		height: auto;
		text-transform: uppercase;
		color: #fff;
		float: left;
	}
</style>

<div class="content-container">
    
    <div class="margin-container" style="margin-top: 80px;">
        <!--<div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
        
        <div class="left-sidebar">
            <?php if($event_name == '10 Seconds' ) { ?>
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-10-second-big.png">
            <?php } elseif( $event_name == 'Digital Idol' ) { ?>
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-digital-idol.png">
            <?php } else { ?>
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-your-project.png">
            <?php } ?>
            
        </div>
        <div class="right-sidebar">
            <div class="news-title-big" style="font-size: 30px;"><?php echo $item->news_title; ?></div>
            <div class="underline-red thin"></div>
            
            <div class="statik-content">
            	<?php if($item->img_path) { ?>
            		<?php if($item->video_path) { ?>
                     <div class="playtime-thumb" style="max-width:200px;">
                        <a class='iframe' href="<?php echo site_url('wow/channel/video').'/'.$item->id;?>" >
                            <img src="<?php echo base_url().'userfiles/wow/news/'.$item->img_path; ?>" >
                            <div class="overlay-play-icon"></div>
                        </a>
                    </div>
            		<?php } else { ?>
            			<img src = "<?php echo base_url().'userfiles/wow/news/'.$item->img_path; ?>" style="float:left;padding-right:20px;max-width:200px;" />
            		<?php } ?>
            	<?php } ?>
                <p><?php echo $item->news_text; ?></p>
            </div>
            
            
        </div>
    </div>
</div>
<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>