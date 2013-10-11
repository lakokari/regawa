<script type="text/javascript" src="<?php echo config_item('assets_url');?>js/jquery.cycle2.min.js" />
<script>
    $(function () {
        $('.antiscroll-wrap').antiscroll({
            autoHide: true
        });
    });
</script>
<style>
    /* to define width & heught container scrollbar */
    .box, .box .antiscroll-inner {
        width: 360px;
        height: 395px;
    }
    .antiscroll-scrollbar-vertical {
        margin-top: 5px;
        right: 5px;
    }
	
	#banner-container {
    width: 360px;
    height: 332px;
    float: left;
	text-align: right;
	}
	
	#banner-container img {
    width: 100%;
    height: 100%;
	}
	    /* ******************* untuk banner ****************************** */
	    /*
	        these are just the default styles used in the Cycle2 demo pages.  
	        you can use these styles or any others that you wish.
	    */
	
	    /* pager */
	    .cycle-pager { 
	        text-align: center;
	        width: 100%;
	        z-index: 500;
	        position: absolute;
	        /*top: 10px;*/
	        /*overflow: hidden;*/
	    }
	
	    .cycle-pager span { 
	        font-family: arial;
	        font-size: 50px;
	        width: 16px;
	        height: 16px; 
	        display: inline-block;
	        color: #666;
	        cursor: pointer; 
	    }
	    .cycle-pager span.cycle-pager-active { color: #d31821;}
	    .cycle-pager > * { cursor: pointer;}
	
	
	    /* ******************* untuk banner ****************************** */
	
	.highlight-detail-title, .highlight-detail-from {        
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .right-header-container {
        width: auto;
    }
    
    .button-upload {
        float: right;
    }
	
</style>
    

<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_wow.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/layout.custom.css" rel="stylesheet" type="text/css" />
<div class="body-container">
    <div class="header-container">
        <a href="<?php echo base_url(); ?>" class="logo"></a>
        <!--<a href="<?php echo base_url(); ?>wow/channel" class="wow-logo"></a>-->
		<a href="<?php echo base_url()?>wow/channel" class="channel-title">
            WOW
        </a>
               
        <div class="right-header-container">
            <table align="right" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <div class="name-user" style="
						display: inline-block;;
						font-size: 14px;
						margin-right: 5px;
                                 ">
                                <?php if($this->user_m->is_loggedin()) { ?>
                                Welcome, <b><?php echo $this->session->userdata('name'); ?></b>
                                <?php } else { ?>
                                Welcome, <b>Guest</b>
                                <?php } ?>
                             
                            </div> 
                        </td>
                        <td>
                            <?php if($this->user_m->is_loggedin()) { ?>
                            <img src="<?php echo $this->session->userdata('avatar'); ?>" width="30" height="30">
                            <?php } ?>
                        </td>
                        <td><a href="#" class="wow-icon-settings"></a></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <a href="#" class="button-upload"></a>
                        </td>  
                    </tr>
                </tbody>
            </table>	          
        </div>
        
    </div>
    <div class="widget-container">
        <div class="widget-left">
            <div class="project-tabs">
                <a href="#"><div class="project-tabs-heading">wow project</div></a>
                <div id="project-tabs-nav">
                    <ul>
                        <?php foreach ($event_active as $event) { ?>
                        <li><a href="<?php echo base_url()."wow/channel/project?event=".$event->id; ?>"><i class="<?php if($event->id == '1') {
                                echo "icon-camera";                            
                            }elseif($event->id == '2') {
                                echo "icon-music-white";   
                            } else {
                                echo "icon-play-small";
                            }
                            ?>"></i><?php if($event->name == 'Wow Project') { echo "Your Project"; } else { echo $event->name; }?></a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
			<!--
            <div class="banner-container">
                <img src="<?php echo config_item('assets_wow'); ?>css/img/wow-10-second-banner-new.png">
            </div>
			-->
			<div class="cycle-slideshow" data-cycle-pager=".cycle-pager" data-cycle-timeout=3000 id="banner-container" data-cycle-slides="#content">
                            <?php foreach ($sliding_banner->result() as $banner) {?>
			        <div id="content">
			            <a href="<?php echo $banner->hyperlink; ?>">
                                        <img src="<?php echo config_item('userfiles') .'wow/banner/'.$banner->image; ?>">
                                    </a>
			                
			            <div class="banner-info-text">
			                <?php echo $banner->banner_text; ?>
			            </div>
			            <div class="cycle-pager"></div>
			        </div>
			    <?php } ?>
			</div>
        </div>
        <div class="widget-center">
            <?php foreach ($top_rating as $top) {?>
            <div class="highlight-video-container-margined">
                <div class="highlight-video">
                    <div class="highlight-video-thumb">
                        <img src="<?php echo config_item('userfiles') .'wow/thumbnail/'. $top->item_thumbnail;?>">
                        <?php if($top->event_id == 1) { ?>
                        <div class="overlay-type-camera-icon"></div>
                        <?php }elseif($top->event_id == 2) {  ?>
                        <div class="overlay-type-music-icon"></div>
                        <?php } else { ?>
                        <div class="overlay-type-play-icon"></div>
                        <?php } ?>
						<div class="most-favorite-video-title"><?php 
							if($top->event_id == 1) { 
								echo "Your Project";
							}elseif($top->event_id == 2) { 
								echo "Digital Idol";
							} else {
								echo "10 Seconds";
							}
							?>
						</div>
						<div class="most-favorite-video-label">Most Favorite</div>
                        <a href="<?php echo site_url('wow/channel/detail/'.$top->id); ?>"><div class="overlay-play-icon"></div></a>
                    </div>
                   					<?php if ($this->user_m->is_loggedin()) { ?>
                        <?php if ($can_like_dislike): ?>
                            <?php if ($top->user_can_like): ?>
                                <a class="social-button like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $top->id; ?>', this);">
                                    Vote
                                </a>
                                <a class="social-button unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $top->id; ?>', this);">
                                    Unvote
                                </a>
                            <?php else: ?>
                                <a class="social-button unlike" href="javascript:void(0);" onclick="unlike('<?php echo $top->id; ?>', this);">
                                    Unvote
                                </a>

                                <a class="social-button like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $top->id; ?>', this);">
                                    Vote
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } else {?>
					        <a class="social-button like" href="javascript:void(0);" onclick="mustLogin();">Vote</a>
					<?php } ?>
					
                    <a rel="nofollow" href="javascript://" onclick="return fbs_click('<?php echo site_url('wow/channel/detail/'.$top->id); ?>');" class="social-button">Share</a>
                    <a href="https://twitter.com/share?url=<?php echo site_url('wow/channel/detail/'.$top->id); ?>&text=<?php echo $top->item_name.' by '.$top->created_by_name;?>" class="social-button tweet"  target="_blank">Tweet</a>
                    <a href="#" class="vote-count">Vote <i class="vote-count-value"><?php echo $top->item_like_count;?></i></a>
                </div>
                <div class="highlight-detail-container">
                    <div class="highlight-detail-title">
                        <a title="<?php echo $top->item_name;?>" href="<?php echo site_url('wow/channel/detail/'.$top->id); ?>"><?php echo $top->item_name;?></a>
                    </div>
                    <div class="highlight-detail-from">
                        <a title="<?php echo $top->created_by_name;?>" href="<?php echo site_url('wow/channel/detail/'.$top->id); ?>"><?php echo $top->created_by_name;?></a>
						<?php 
						if ($top->created_by_client_app=='facebook'){
								echo '<span class="detail-user-img"><img src="https://graph.facebook.com/'.$top->created_by_client_userid.'/picture"/></span>';
						}
						?>
					</div>
                    <a href="<?php echo site_url('wow/channel/detail/'.$top->id); ?>" class="button-more"></a>
                </div>
            </div>
            <?php } ?>

            

        </div>
        <div class="widget-right">
            <div class="title-widget-right">
                recently <a>upload</a>
            </div>
            <div class="etalase-container box-wrap antiscroll-wrap">
                <div class="box">
                    <div class="antiscroll-inner">
                        <div class="box-inner">
                            
                            <div class="etalase-heading-up">
                                <div class="etalase-tittle-text">Digital Idol</div>
                                <div class="etalase-show-all"><a href="<?php echo base_url()?>wow/channel/nominee/2">Show All</a></div>
                            </div>
                            <?php foreach($recent_upload_di as $recent_di) { ?>
                            <div class="etalase-items">
                                <div class="etalase-video-thumb">                                    
                                    <img src="<?php echo config_item('userfiles') .'wow/thumbnail/'. $recent_di->item_thumbnail;?>">
                                    <a href="<?php echo site_url('wow/channel/detail/'.$recent_di->id); ?>"><div class="etalase-overlay-play-small"></div></a>
                                </div>
                                <div class="etalase-title-item">
                                    <div class="etalase-title-from"><?php echo $recent_di->created_by_name;?></div>
									    <?php foreach($datakota as $kota) { ?>
										<?php if ($kota->id_items == $recent_di->id){
											echo '<div class="etalase-title-kota">'.$kota->fieldvalue.'</div>';											
										}
										?>
									<?php } ?>
                                    <!--<div class="etalase-title-kota">Boyolali</div>-->
                                    <div class="etalase-title-judul">"<?php echo $recent_di->item_name;?>"</div>
                                </div>
                                <div class="etalase-time"><?php echo date('g:i',strtotime($recent_di->upload_date));?></div>
                            </div>
                            <?php } ?>

                            <div class="etalase-heading">
                                <div class="etalase-tittle-text">10 Seconds</div>
                                <div class="etalase-show-all"><a href="<?php echo base_url()?>wow/channel/nominee/3">Show All</a></div>
                            </div>
                            
                            <?php foreach($recent_upload_ts as $recent_ts) { ?>
                            <div class="etalase-items">
                                <div class="etalase-video-thumb">
                                    <img src="<?php echo config_item('userfiles') .'wow/thumbnail/'. $recent_ts->item_thumbnail;?>">
                                    <a href="<?php echo site_url('wow/channel/detail/'.$recent_ts->id); ?>"><div class="etalase-overlay-play-small"></div></a>
                                </div>
                                <div class="etalase-title-item">
                                    <div class="etalase-title-from"><?php echo $recent_ts->created_by_name;?></div>
										<?php foreach($datakota as $kota) { ?>
										<?php if ($kota->id_items == $recent_ts->id){
											echo '<div class="etalase-title-kota">'.$kota->fieldvalue.'</div>';											
										}
										?>
									<?php } ?>
                                    <!--<div class="etalase-title-kota">Boyolali</div>-->
                                    <div class="etalase-title-judul">"<?php echo $recent_ts->item_name;?>"</div>
                                </div>
                                <div class="etalase-time"><?php echo date('g:i',strtotime($recent_ts->upload_date));?></div>
                            </div>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap-container">
		<div class="title-widget-right">
                <a>WOW Project</a> latest update
        </div>
	</div>
</div>
<div class="slider-container">
    <div id="myslider1" class="myslider1">
        <div id="myslider-content">
            
            <?php foreach ($wow_news->result() as $news) {?>
            <div class='slide1 container-item'>
				<?php if($news->img_path){?>
                <a href="<?php echo base_url().'wow/read/news/'.$news->id; ?>">
                    <img class="rounded" src="<?php echo config_item('userfiles')."wow/news/".$news->img_path; ?>">
                </a>
				<?php }?>
                <div class="news-container">
                    <a href="<?php echo base_url().'wow/read/news/'.$news->id; ?>"><div class="slider-title-news"><?php echo $news->news_title; ?></div></a>
                    <div class="slider-date-news"><?php echo date_format(date_create($news->news_datetime), 'g:ia \o\n l jS F Y'); ?></div>
                    <div class="slider-desc-news"><?php echo substr($news->news_text, 0, 150); ?>..</div>
                </div>
            </div>
            <?php } ?>
			
        </div>
    </div>
</div>
<div class="footer-container">
    <a href='<?php echo site_url('wow/read/index/1'); ?>' class='footer-link-page'>About Us</a>
    <a href='<?php echo site_url('wow/channel/contact'); ?>' class='footer-link-page'>Contact Us</a>
    <a href='<?php echo site_url('wow/read/index/6'); ?>' class='footer-link-page unborder'>FAQ</a>
    <a href='https://twitter.com/UZoneIndonesia' target="_blank" class='footer-sosmed twitter'>@UzoneIndonesia</a>
    <a href='https://www.facebook.com/UZoneIndonesia' target="_blank" class='footer-sosmed facebook'>/UzoneIndonesia</a>
    
</div>



<script>
	
    $('#myslider1').swipePlanes();

    
    var is_loggedin = '<?php echo $is_loggedin;?>';
    $('.button-upload').click(function (){
        if (is_loggedin==='yes'){
            window.location = '<?php base_url(); ?>channel/upload';
        }else{
           alert('Anda harus login untuk upload');
           $('.tombol-panel-one').click();
        }
    });
    
	function fbs_click(uridetail) 
	{ 
		u=location.href; 
		t=document.title; 
		window.open('http://www.facebook.com/sharer.php?u='+uridetail,'sharer', 'toolbar=1, status=1, width=600, height=400'); return false; 
	} 
    function likeIncrease(wow_id, obj){
        $.post("<?php echo site_url('ajax/wow'); ?>",{func:'increaseLike',id:wow_id},function(data){
            if (parseInt(data['success'])==1){                
                //hide like button
                $(obj).hide();
                
                //update current like num
                $(obj).parent().find('i.vote-count-value').text(data['current_like_count']);
                
                //show unlike button
                $(obj).parent().find('a.unlike').show();
            }
        },'json');
    }
    
    function unlike(wow_id, obj){
        $.post("<?php echo site_url('ajax/wow'); ?>",{func:'unLike',id:wow_id},function(data){
            if (parseInt(data['success'])==1){                
                //hide like button
                $(obj).hide();
                
                //update current like num
                $(obj).parent().find('i.vote-count-value').text(data['current_like_count']);
                
                //show like button
                $(obj).parent().find('a.like').show();
            }
        },'json');
    }
	
	function mustLogin(){
        var x;
        var r=confirm("Maaf Anda harus login untuk memberikan like");
        if (r==true) {
            $('.tombol-panel-one').click();
        } else {
            return;
        }
    }
	
</script> 
