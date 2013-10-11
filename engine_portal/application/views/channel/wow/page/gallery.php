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
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
        <div class="gallery-header">
            <?php if($event_name == '10 Seconds') {?>
                <div class="gallery-logo-event ten-seconds"></div>
            <?php } elseif($event_name == 'Digital Idol') {?>
                <div class="gallery-logo-event digital-idol"></div>
            <?php } else {?>
                <div class="gallery-logo-event your-project"></div>
            <?php } ?>
            <div class="gallery-heading-title">gallery</div>
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
                            <?php /*foreach ($kota_video as $kota) { ?>
                                <li><a href="#"><?php echo $kota->fieldvalue?></a></li>
                            <?php }*/ ?>
                        </ul>
                    </li>
                </ul>
            </div>-->
        </div>
        
        <div style="width: 100%; height: auto; float: left; font-size: 20px; color : #fff; text-transform: uppercase; margin : 10px;">
            Recent <a class="show-all-gallery" href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/recent/1') ;?>">Show All</a>
        </div>
        
        <?php foreach ($recent_upload as $item):?>
        <div class="gallery-video-container">
            <div class="gallery-video-thumb">
                <a href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                    <img src="<?php echo $item->item_thumbnail;?>">
                    <div class="gallery-overlay-play-icon"></div>
                </a>
            </div>
            <div class="gallery-video-title"><?php echo $item->item_name;?></div>
            <div class="gallery-video-date">by @<?php echo $item->created_by_name;?></div>
            <div class="gallery-video-title">
                    <i class="like-num"><?php echo $item->item_like_count; ?></i> Likes
                    <?php if ($this->user_m->is_loggedin()) { ?>
                        <?php if ($can_like_dislike): ?>
                            <?php if ($item->user_can_like): ?>
                                <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-up-2"> Like</i>
                                </a>
                                <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-down-2"> Unlike</i>
                                </a>
                            <?php else: ?>
                                <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-down-2"> Unlike</i>
                                </a>

                                <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-up-2">Like</i>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2">Like</i>
                        </a>
                    <?php } ?>
                </div>
        </div>
        <?php endforeach;?>
        
        <div style="width: 100%; height: auto; float: left; font-size: 20px; color : #fff; text-transform: uppercase; margin : 10px;">
            Most Favorite <a class="show-all-gallery" href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/favorite/1') ;?>">Show All</a>
        </div>
        
        <?php foreach ($top_rating as $top):?>
        <div class="gallery-video-container">
            <div class="gallery-video-thumb">
                <a href="<?php echo site_url('wow/channel/detail/'.$top->id); ?>">
                    <img src="<?php echo $top->item_thumbnail;?>">
                    <div class="gallery-overlay-play-icon"></div>
                </a>
            </div>
            <div class="gallery-video-title"><?php echo $top->item_name;?></div>
            <div class="gallery-video-date">by @<?php echo $top->created_by_name;?></div>
            <i class="like-num"><?php echo $top->item_like_count;?></i> Likes
                <?php if ($this->user_m->is_loggedin()) { ?>
                    <?php if ($top->user_can_like): ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $top->id; ?>', this);">
                            <i class="icon-thumbs-up-2"> Like</i>
                        </a>
                        <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $top->id; ?>', this);">
                            <i class="icon-thumbs-down-2"> Unlike</i>
                        </a>
                    <?php else: ?>
                        <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $top->id; ?>', this);">
                            <i class="icon-thumbs-down-2"> Unlike</i>
                        </a>

                        <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $top->id; ?>', this);">
                            <i class="icon-thumbs-up-2"> Like</i>
                        </a>
                    <?php endif; ?>
                <?php } else { ?>
                    <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                        <i class="icon-thumbs-up-2"> Like</i>
                    </a>
                <?php } ?>
        </div>
            
        <?php endforeach;?>
        
        <div style="width: 100%; height: auto; float: left; font-size: 20px; color : #fff; text-transform: uppercase; margin : 10px;">
            All Video <a class="show-all-gallery" href="<?php echo site_url('wow/channel/galleryall/'. $event_id.'/all/1') ;?>">Show All</a>
        </div>
        <?php foreach ($all_video as $all_video):?>
        <div class="gallery-video-container">
            <div class="gallery-video-thumb">
                <a href="<?php echo site_url('wow/channel/detail/'.$all_video->id); ?>">
                    <img src="<?php echo $all_video->item_thumbnail;?>">
                    <div class="gallery-overlay-play-icon"></div>
                </a>
            </div>
            <div class="gallery-video-title"><?php echo $all_video->item_name;?></div>
            <div class="gallery-video-date">by @<?php echo $all_video->created_by_name;?></div>
            <div class="gallery-video-title">
                <i class="like-num"><?php echo $all_video->item_like_count;?></i> Likes
                    <?php if($this->user_m->is_loggedin()) { ?>
                        <?php if ($all_video->user_can_like):?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-up-2"> Like</i>
                        </a>
                        <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-down-2"> Unlike</i>
                        </a>
                        <?php else:?>
                        <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-down-2"> Unlike</i>
                        </a>

                        <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $all_video->id;?>', this);">
                            <i class="icon-thumbs-up-2"> Like</i>
                        </a>
                        <?php endif;?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2"> Like</i>
                        </a>
                    <?php } ?>
            </div>
        </div>
        <?php endforeach;?>
        
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
