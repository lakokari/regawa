<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />

<script src="<?php echo config_item("assets_url"); ?>jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="6aMwqeMz0opU9trgteTwz6bLsKUOzlGvNCg64g==";</script>

<style>
.sosmed-gallery
{
	margin-top:50px;
	padding-top:50px;
	text-align:center;
	text-decoration:none;
}
.sosmed-gallery img
{
	padding:10px;
	border:none;
	
}
a.like{
text-decoration:none;
}
a.unlike{
text-decoration:none;
}
a.gallery-share{
text-decoration:none;
}
a.gallery-twitter{
text-decoration:none;
}

.gallery-heading-title {
    color: rgb(255, 255, 255);
    float: left;
    font-size: 44px;
    height: 57px;
    margin: 0px;
    padding: 25px;
    text-transform: uppercase;
    width: 100%;
}
</style>

<div class="content-container">
    
    <div class="margin-container" style="margin-top: 60px;">
        <!--<div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
        <div class="gallery-header">
<!--             <div class="gallery-logo-event <?php
            switch ($event_id) {
                case '1' :
                    echo "your-project";
                    break;
                case '2' : 
                    echo "digital-idol";
                    break;
                default :
                    echo "ten-seconds";
                    break;
            }
            ?>"></div> -->
            <div class="gallery-heading-title"><a href="javascript:window.history.back();">My Project</a></div>
            <!--<div class="gallery-nav-container">
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
            </div>-->
        </div>
        
        <div class="gallery-sidebar-left">
            <div class="video-player-container" id="video-player">
                <img src="<?php echo $wow_item->item_thumbnail;?>" width="100%" height="100%" />
            </div>
            <div class="video-status-rank-container">
                <div class="vote-container">
                    <span class="vote-rank-label">Vote</span>
                    <span class="vote-rank-value"><i id="vote-count"><?php echo $wow_item->item_like_count;?></i> VOTES</span>
                </div>
                <div class="rank-container">
                    <span class="vote-rank-label">rank</span>
                    <span class="vote-rank-value">
						<?php foreach ($rank_video as $rank) {
                            echo $rank->rank;
                        } ?> <span style="color : #7e7e7e;">FROM</span> <?php echo $total_rank_video; ?>
					</span>
                </div>
            </div>
        </div>
        <div class="desc-video-container">
            <div class="desc-title-container">
                <span class="span-desc-video-title"><?php echo $wow_item->item_name;?></span>
                <span class="span-desc-video-title small">oleh <?php echo $wow_item->created_by_name;?></span>
            </div>
            <span class="span-desc-value"><?php echo $wow_item->item_description;?></span>
            
            <?php foreach($custom_field as $field): ?>
                <span class="span-desc-label"><?php echo $field->event_field;?></span>
                <span class="span-desc-value"><?php echo $field->fieldvalue;?></span>
            <?php endforeach; ?>

            <br>
            <b>Event</b>
            <span class="span-desc-value"><?php echo $event_name;?></span>
            
        			<div class="sosmed-gallery">
			<?php if ($this->user_m->is_loggedin()) { ?>
                        <?php if ($can_like_dislike): ?>
                            <?php if ($wow_item->user_can_like): ?>
                                <a class="like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $wow_item->id; ?>', this);">
                                    <img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-vote-circle.png'; ?>" width="80px"/>
                                </a>
                                <a class="unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $wow_item->id; ?>', this);">
                                    <img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-unvote-circle.png'; ?>" width="80px"/>
                                </a>
                            <?php else: ?>
                                <a class="unlike" href="javascript:void(0);" onclick="unlike('<?php echo $wow_item->id; ?>', this);">
                                    <img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-unvote-circle.png'; ?>" width="80px"/>
                                </a>

                                <a class="like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $wow_item->id; ?>', this);">
                                    <img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-vote-circle.png'; ?>" width="80px"/>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } else {?>
					        <a class="like" href="javascript:void(0);" onclick="mustLogin();"><img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-vote-circle.png'; ?>" width="80px"/></a>
					<?php } ?>
				
				<a class="gallery-share" rel="nofollow" href="javascript://" onclick="return fbs_click('<?php echo site_url('wow/channel/detail/'.$wow_item->id); ?>');">
				<img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-fbshare-circle.png'; ?>" width="80px"/>
				</a>
				
				<a class="gallery-twitter" href="https://twitter.com/share?url=<?php echo site_url('wow/channel/detail/'.$wow_item->id); ?>&text=<?php echo $wow_item->item_name.' by '.$wow_item->created_by_name;?>"  target="_blank">
				<img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-tweet-circle.png'; ?>" width="80px"/>
				</a>		
				
				</div>    
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
    $('#myslider1').swipePlanes();
    $(document).ready(function() { 
        //call jw player to handle video
        jwplayer('video-player').setup({
                file: '<?php echo $wow_item->item_url; ?>',
                image: '<?php echo $wow_item->item_thumbnail; ?>',
                autostart: true,
                'modes': [
                    {type: 'flash', src: "jwplayer.flash.swf"},
                    {type: 'html5'}
                ],
                width: 500,
                height: 300
        });
    });
    
    function likeIncrease(wow_id, obj){
        $.post("<?php echo site_url('ajax/wow'); ?>",{func:'increaseLike',id:wow_id},function(data){
            if (parseInt(data['success'])==1){                
                //hide like button
                $(obj).hide();
                
                //update current like num
                //$('i#vote-count').parent().find('i#vote-count').text(data['current_like_count']);
                document.getElementById("vote-count").innerHTML = data['current_like_count'];
				
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
                //$(obj).parent().find('i#vote-count').text(data['current_like_count']);
				document.getElementById("vote-count").innerHTML= data['current_like_count'];
                
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
	
	function fbs_click(uridetail) 
	{ 
		u=location.href; 
		t=document.title; 
		window.open('http://www.facebook.com/sharer.php?u='+uridetail,'sharer', 'toolbar=1, status=1, width=600, height=400'); return false; 
	} 
</script>
