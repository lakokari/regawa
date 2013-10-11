<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />




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
            <?php if($category_name == '10 Seconds' ) { ?>
				<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $get_event_id; ?>">
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/wow-10-second-banner-new.png">
				</a>
            <?php } elseif( $category_name == 'Digital Idol' ) { ?>
				<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $get_event_id; ?>">
                <img style="display: block;margin: auto; width : 300px;" src="<?php echo config_item('assets_wow');?>css/img/logo-digital-idol-hd.png">
				</a>
            <?php } else { ?>
				<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $get_event_id; ?>">
                <img style="display: block;margin: auto;" src="<?php echo config_item('assets_wow');?>css/img/logo-your-project.png">
				</a>
            <?php } ?>
            
        </div>
        <div class="right-sidebar">
            <div class="statik-title-big"><?php echo $item->title; ?></div>
            <div class="underline-red thin"></div>
            <div class="statik-content">
                <?php echo $item->content; ?>
            </div>
            
            
        </div>
    </div>
</div>

<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>