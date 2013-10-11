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
    <!-- MENU -->
    <div id="menu">
    	<ul id="navbar">
            <?php $this->load->view('channel/wow/components/dropdown'); ?>
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
        <div id="gallery">
            <div class="full-width-container">
                <div class="title-big-container"><?php echo isset($event_name)?$event_name:'';?> //</div> <div class="title-big-container red"> &nbsp;Gallery</div>
            </div>
            <!-- RECENT UPLOAD -->
            <div class="full-width-container">
                <div class="title-gallery">Recent Uploads</div>
                <div class="showall-gallery"><a href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/recent/1') ;?>">Show All</a></div>
            </div>
            <?php foreach ($recent_upload as $item):?>
            <div class="gallery-container">
                
                <div class="gallery-thumb-container">
                    <a title="Play video" href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                        <img src="<?php echo $item->item_thumbnail;?>" />
                        <div class="gallery-play-button"></div>
                    </a>
                </div>
                <div class="gallery-share-container">
                    <i class="like-num"><?php echo $item->item_like_count;?></i> Votes
                    <?php if($this->user_m->is_loggedin()) { ?>
                         <?php if ($can_like_dislike):?>
                            <?php if ($item->user_can_like):?>
                            <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-up-2"> Vote</i>
                            </a>
                            <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-down-2"> Unvote</i>
                            </a>
                            <?php else:?>
                            <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-down-2"> Unvote</i>
                            </a>

                            <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-up-2">Vote</i>
                            </a>
                            <?php endif;?>
                        <?php endif;?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2">Vote</i>
                        </a>
                    <?php } ?>
                    
                   
                </div>
                <div class="gallery-tittle-container"><?php echo $item->item_name;?></div>
                <div class="gallery-description-container">by @<?php echo $item->created_by_name;?></div>
                
            </div>
            <?php endforeach;?>
            <!-- END OF RECENT UPLOAD -->
            
            <!-- RECENT PLAYED -->
            <div class="full-width-container">
                <div class="title-gallery">Recent Played</div>
                <div class="showall-gallery"><a href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/recentplayed/1') ;?>">Show All</a></div>
            </div>
            <?php foreach ($recent_played as $item):?>
            <div class="gallery-container">
                
                <div class="gallery-thumb-container">
                    <a title="Play video" href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                        <img src="<?php echo $item->item_thumbnail;?>" />
                        <div class="gallery-play-button"></div>
                    </a>
                </div>
                <div class="gallery-share-container">
                    <i class="like-num"><?php echo $item->item_like_count;?></i> Votes
                    <?php if($this->user_m->is_loggedin()) { ?>
                         <?php if ($can_like_dislike):?>
                            <?php if ($item->user_can_like):?>
                            <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-up-2"> Vote</i>
                            </a>
                            <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-down-2"> Unvote</i>
                            </a>
                            <?php else:?>
                            <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-down-2"> Unvote</i>
                            </a>

                            <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id;?>', this);">
                                <i class="icon-thumbs-up-2">Vote</i>
                            </a>
                            <?php endif;?>
                        <?php endif;?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2">Vote</i>
                        </a>
                    <?php } ?>
                    
                   
                </div>
                <div class="gallery-tittle-container"><?php echo $item->item_name;?></div>
                <div class="gallery-description-container">by @<?php echo $item->created_by_name;?></div>
                
            </div>
            <?php endforeach;?>
            <!-- END ECENT PLAYED -->
            
            <!-- MOST FAVORITE -->
            <div class="full-width-container" style="margin-top : 20px;">
                <div class="title-gallery">Most Favorite</div>
                <div class="showall-gallery"><a href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/favorite/1') ;?>">Show All</a></div>
            </div>
            <?php foreach ($top_rating as $top):?>
            <div class="gallery-container">
                
                <div class="gallery-thumb-container">
                    <a title="Play video" href="<?php echo site_url('wow/channel/detail/'.$top->id); ?>">
                        <img src="<?php echo $top->item_thumbnail;?>" />
                        <div class="gallery-play-button"></div>
                    </a>
                </div>
                <div class="gallery-share-container">
                    <i class="like-num"><?php echo $top->item_like_count;?></i> Votes
                    <?php if($this->user_m->is_loggedin()) { ?>
                        <?php if ($top->user_can_like):?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $top->id;?>', this);">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                        <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $top->id;?>', this);">
                            <i class="icon-thumbs-down-2"> Unvote</i>
                        </a>
                        <?php else:?>
                        <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $top->id;?>', this);">
                            <i class="icon-thumbs-down-2"> Unvote</i>
                        </a>

                        <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $top->id;?>', this);">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                        <?php endif;?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                    <?php } ?>
                    
                </div>
                <div class="gallery-tittle-container"><?php echo $top->item_name;?></div>
                <div class="gallery-description-container">by @<?php echo $item->created_by_name;?></div>
                
            </div>
            <?php endforeach;?>
            <!-- END MOST FAVORITE -->
            
            <!-- RANDOM VIDEO -->
            <div class="full-width-container" style="margin-top : 20px;">
                <div class="title-gallery">All video</div>
                <div class="showall-gallery"><a href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/all/1') ;?>">Show All</a></div>
            </div>
            <?php foreach ($all_video as $all_video):?>
            <div class="gallery-container">
                
                <div class="gallery-thumb-container">
                    <a title="Play video" href="<?php echo site_url('wow/channel/detail/'.$all_video->id); ?>">
                        <img src="<?php echo $all_video->item_thumbnail;?>" />
                        <div class="gallery-play-button"></div>
                    </a>
                </div>
                <div class="gallery-share-container">
                    <i class="like-num"><?php echo $all_video->item_like_count;?></i> Votes
                    <?php if($this->user_m->is_loggedin()) { ?>
                        <?php if ($all_video->user_can_like):?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                        <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-down-2"> Unvote</i>
                        </a>
                        <?php else:?>
                        <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-down-2"> Unvote</i>
                        </a>

                        <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                        <?php endif;?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                    <?php } ?>
                </div>
                <div class="gallery-tittle-container"><?php echo $all_video->item_name;?></div>
                <div class="gallery-description-container">by @<?php echo $item->created_by_name;?></div>
                
            </div>
            <?php endforeach;?>
            <!-- END RANDOM VIDEO -->
            
        </div>
    </div>
</div>
<div class="content-container">
    <div id="footer">
        <div class="copy">Copyright &copy; 2013 <strong>UZone</strong> - All rights reserved.</div>
        <div class="logotelkom"><img src="<?php echo config_item('assets_wow'); ?>images/bytelkom.png" /></div>
    </div>
</div>


<!-- END of CONTENT BOTTOM -->

<!-- SIDR -->
<?php $this->load->view('channel/wow/slide_menu_panel'); ?>
<!-- END SIDR -->

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
	
	
	
    function likeIncrease(wow_id, obj){
        $.post("<?php echo site_url('ajax/wow'); ?>",{func:'increaseLike',id:wow_id},function(data){
            if (parseInt(data['success'])==1){                
                //hide like button
                $(obj).hide();
                
                //update current like num
                $(obj).parent().find('i.like-num').text(data['current_like_count']);
                
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
                $(obj).parent().find('i.like-num').text(data['current_like_count']);
                
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

</body>
</html>
