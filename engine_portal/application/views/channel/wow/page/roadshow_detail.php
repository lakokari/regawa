<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />

<script src="<?php echo config_item("assets_url"); ?>jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="6aMwqeMz0opU9trgteTwz6bLsKUOzlGvNCg64g==";</script>


<div class="content-container">
    
    <div class="margin-container" style="margin-top: 60px;">
        <!--<div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        <div class="gallery-header">
            <div class="gallery-logo-event ten-seconds"></div>
            <div class="gallery-heading-title">roadshow</div>
			<!--
            <div class="gallery-nav-container">
			
                <span class="gallery-nav-sort-span">sort by</span>
				
                <ul id="galleryNav">
                    <li><a href="#">Date</a>
                        <ul>
                            <li><a href="#">Lorem</a></li>
                            <li><a href="#">Lorem</a></li>
                            <li><a href="#">Lorem</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Kind</a>
                        <ul>
                            <li><a href="#">Lorem</a></li>
                            <li><a href="#">Lorem</a></li>
                            <li><a href="#">Lorem</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Location</a>
                        <ul>
                            <li><a href="#">Lorem</a></li>
                            <li><a href="#">Lorem</a></li>
                            <li><a href="#">Lorem</a></li>
                        </ul>
                    </li>
                </ul>
				
            </div>
			-->
        </div>
        
        <div class="gallery-sidebar-left">
            <div class="video-player-container" id="video-player">
			<?php if(!$wow_item->img_path){ ?>
				<img src="<?php echo base_url('userfiles/wow').'/news/roadshow_default.jpg';?>" width="100%" height="100%" />
			<?php } else { ?>
				<img src="<?php echo base_url('userfiles/wow').'/news/'.$wow_item->img_path;?>" width="100%" height="100%" />
			<?php } ?>
                
            </div>
        </div>
        <div class="desc-video-container">
            <div class="desc-title-container">
                <span class="span-desc-video-title"><?php echo $wow_item->news_title;?></span>
                <span class="span-desc-video-title small">by <?php echo $user_name;?></span>
            </div>
            <span class="span-desc-value"><?php echo $wow_item->news_text;?></span>
            
            <?php foreach($custom_field as $field): ?>
                <span class="span-desc-label"><?php echo $field->event_field;?></span>
                <span class="span-desc-value"><?php echo $field->fieldvalue;?></span>
            <?php endforeach; ?>
            
            
        </div>
        
        <!--
        <div style="width: 100%; height: auto; float : left;">
            <table align="center">
                <tr>
                    <td>
                        <ul class="gallery-paging">
                            <li><a href="#"><</a></li>
                            <li><a href="#" class="current">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">></a></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>-->
        
        
            
            
        
    </div>
</div>

<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>


<script>
<?php if($wow_item->video_path){ ?>	
    $(document).ready(function() { 
        //call jw player to handle video
        jwplayer('video-player').setup({
                file: '<?php echo base_url('userfiles/wow').'/news/'.$wow_item->video_path; ?>',
                image: '<?php echo base_url('userfiles/wow').'/news/'.$wow_item->img_path; ?>',
                autostart: true,
                'modes': [
                    {type: 'flash', src: "jwplayer.flash.swf"},
                    {type: 'html5'}
                ],
                width: 500,
                height: 300
        });
    });
	<?php } ?>

</script>
