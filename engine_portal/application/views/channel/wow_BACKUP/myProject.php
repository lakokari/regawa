<?php 
//load page head html
$this->load->view('channel/wow/components/page_head'); 
$this->load->view('channel/wow/components/slide_left_menu');
?>
<div id="content">
    <div id="header">
        <div class="logo">
            <span class="main"><img src="<?php echo config_item('assets_wow'); ?>images/logo.png" /></span>
            <span class="sub"><a href="<?php echo base_url(); ?>wow/channel"><img src="<?php echo config_item('assets_wow'); ?>images/logo_wow.png" /></a></span>
        </div>
		<div class="welcome">
			<?php if($this->user_m->is_loggedin()) { ?>
				<div class="name-user">Welcome, <a href="#" class="user"><?php echo $this->session->userdata('name'); ?></a></div>
				<div class="avatar-user">
					<img src="<?php echo $this->session->userdata('avatar'); ?>" width="30" height="30" />
				</div>
			<?php } else { ?>
				<span>Welcome, <a href="#" class="profile">Guest</a></span>
			<?php } ?>
		</div>
    </div>
    
</div>
    <!-- MENU -->
<div id="content">
    <div id="menu">
    	<ul id="navbar">
            <li><a href="#">What's Wow?</a>
                <ul>
                    <?php foreach($categories_wow as $cat_wow): ?>
                        <?php if($cat_wow->display_order >= 1){ ?>
                            <?php if($cat_wow->content == NULL){ ?>
                                <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$cat_wow->category_id; ?>" data="<?php echo $cat_wow->id; ?>"><?php echo $cat_wow->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url('wow/read').'/index/'.$cat_wow->id; ?>" data="<?php echo $cat_wow->id; ?>"><?php echo $cat_wow->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="#">10 Seconds Movie</a>
                <ul>
                    <?php foreach($categories_10s as $cat_10s): ?>
                        <?php if($cat_10s->display_order >= 1){ ?>
                            <?php if($cat_10s->content == NULL){ ?>
                                <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$cat_10s->category_id; ?>" data="<?php echo $cat_10s->id; ?>"><?php echo $cat_10s->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url('wow/read').'/index/'.$cat_10s->id; ?>" data="<?php echo $cat_10s->id; ?>"><?php echo $cat_10s->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="#">Digital Idol</a>
                <ul>
                    <?php foreach($categories_di as $cat_di): ?>
                        <?php if($cat_di->display_order >= 1){ ?>
                            <?php if($cat_di->content == NULL){ ?>
                                <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$cat_di->category_id; ?>" data="<?php echo $cat_di->id; ?>"><?php echo $cat_di->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url('wow/read').'/index/'.$cat_di->id; ?>" data="<?php echo $cat_di->id; ?>"><?php echo $cat_di->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        </ul>
        
        <!-- UPLOAD HERE -->
        <?php $this->load->view('channel/wow/upload/index');?>
        <!-- END of UPLOAD HERE -->
    </div>
    <!-- END of MENU -->
</div>    
<!-- CONTENT BOTTOM -->
<div class="page">
    <div class="content-container">
            
        <div class="right-container">
            <div class="full-width-container">
                <div class="title-big-container red"> My Gallery</div>
            </div>
            <div class="full-width-container">
                <!--<div class="title-gallery">Recent Uploads</div>
                <div class="showall-gallery"><a href="#">Show All</a></div>-->
            </div>
            <?php foreach ($items as $item):?>
            <div class="gallery-container">
                
                <div class="gallery-thumb-container" title="Play video" onclick="playVideo('<?php echo $item->id;?>','<?php echo $item->item_url;?>','<?php echo $item->item_thumbnail;?>');">
                <a href="javascript:void(0);">    
                    <img src="<?php echo $item->item_thumbnail;?>" />
                    <div class="gallery-play-button"></div>
                </a>
                </div>
                <div class="gallery-tittle-container"><?php echo $item->item_name;?></div>
                <div class="gallery-description-container"><?php echo $item->item_description;?></div>
                
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div class="content-container">
    <div id="footer">
        <div class="copy">Copyright &copy; 2013 <strong>UZone</strong> - All rights reserved.</div>
        <div class="logotelkom"><img src="<?php echo config_item('assets_wow'); ?>images/bytelkom.png" /></div>
    </div>
</div>

<div id="element_to_pop_up">
    <a class="b-close">x</a>
    <div id="wow-player">WOW VIDEO</div>
</div>

<!-- END of CONTENT BOTTOM -->

<!-- SIDR -->
<?php $this->load->view('channel/wow/slide_menu_panel'); ?>
<!-- END SIDR -->

<script src="<?php echo config_item("assets_url"); ?>jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="6aMwqeMz0opU9trgteTwz6bLsKUOzlGvNCg64g==";</script>
<script>
    $(document).ready(function() {
        $('.tombol-panel-one').sidr({
            name: 'sidr-right',
            side: 'right',
            body: ''
        });
        
        $('.tombol-panel').sidr({
            name: 'sidr-right',
            side: 'right',
            body: ''
        });
        
        $('.tombol-panel-one').click(function(){
            $('.container-panel').show();
        });

        
        
        
        $('.tombol-panel-one').show();
        $('.tombol-panel').show();
    });
	
	function playVideo(id, video_url, img_url){
		var container = document.getElementById('wow-player');
        container.innerHTML= '';
        
        jwplayer('wow-player').setup({
            file: video_url,
            image: img_url,
            autostart: true,
            'modes': [
                {type: 'flash', src: "jwplayer.flash.swf"},
                {type: 'html5'}
            ],
			width: 630,
            height: 480
            
        });
		
		
        $('#element_to_pop_up').bPopup({
            modalClose: false,
            opacity: 0.8,
            positionStyle: 'fixed', //'fixed' or 'absolute'
            onClose: function() { document.getElementById('wow-player').innerHTML = ''; }
        });
		
	}
    
</script>

</body>
</html>
