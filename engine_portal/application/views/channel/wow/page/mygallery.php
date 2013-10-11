<style type="text/css">
    .nominee {
        background: url('<?php echo config_item('assets_wow');?>css/img/overlay-play-icon2.png') no-repeat center center;
        width: 280px;
        height: 180px;
        background-position: center center;
        background-repeat: no-repeat;
        position: absolute;
        z-index: 99;
        top: 0px;
        left: 0px;
        opacity: 0.5;
    }
    .nominee:hover{
        opacity: 1;
    }
</style>
<!-- slide panel item-->
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />




<div class="content-container">
    
    <div class="margin-container" style="margin-top: 60px;">
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
        <form method="get" accept-charset="utf-8" action="<?php echo site_url('wow/channel/mygallery/'.$pagenum); ?>" />
            <input type="text" name="criteria" placeHolder="<?php echo $criteria?$criteria:'all'; ?>" class="input-search" />
            <input type="submit" value="Search" class="btn-search"/>
	</form>
        <div class="gallery-header">
<!--             <?php if(isset($event_name) && $event_name == '10 Seconds') {?>
                <div class="gallery-logo-event ten-seconds"></div>
            <?php } elseif(isset($event_name) && $event_name == 'Digital Idol') {?>
                <div class="gallery-logo-event digital-idol"></div>
            <?php } else {?>
                <div class="gallery-logo-event your-project"></div>
            <?php } ?> -->
                <div class="gallery-heading-title" style="width: auto;">My Project</div>

            <div class="gallery-nav-container">
                <span class="gallery-nav-sort-span">sort by</span>
                <?php if (isset($size)&&$size > 0):?>
                <ul id="galleryNav">
                    <?php 
                    $base_url_order = site_url('wow/channel/mygallery/1') . (isset($criteria)&&$criteria ? '?criteria='.$criteria.'&':'?');
                    if (isset($ordertype)&&$ordertype=='desc'){
                        $class_name = 'sort_down';
                        $base_url_order .='ordertype=asc';
                    }else{
                        $class_name = 'sort_up';
                        $base_url_order .='ordertype=desc';
                    }
                    ?>
                    
                    <li>
                    <?php if ($orderby=='vote'): ?>
                        <a class="<?php echo $class_name;?>" href="<?php echo $base_url_order .'&orderby=vote';?>">Vote</a>
                    <?php else: ?>
                        <a href="<?php echo $base_url_order .'&orderby=vote';?>">Vote</a>
                    <?php endif;?>
                    </li>
                    <li>
                    <?php if ($orderby=='date'): ?>
                        <a class="<?php echo $class_name;?>" href="<?php echo $base_url_order .'&orderby=date';?>">Date</a>
                    <?php else: ?>
                        <a href="<?php echo $base_url_order .'&orderby=date';?>">Date</a>
                    <?php endif;?>
                    </li>
                </ul>
                <?php endif;?>
            </div>
        </div>
        
        <div class="gallery-type-title">My Project</div>
        
        <?php $i=0; foreach ($items as $item):?>
        <div class="gallery-video-container">
            <div class="gallery-video-thumb">
                <a href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                    <img src="<?php echo $item->item_thumbnail;?>">
                    <div class="<?php echo $item->nominee==1?'nominee':'gallery-overlay-play-icon'; ?>"></div>
                </a>
            </div>
            <div class="gallery-video-title"><?php echo $item->item_name;?></div>
            <div class="gallery-video-date">by @<?php echo $item->created_by_name;?></div>
            <div class="gallery-vote-container">
                    <i class="like-num"><?php echo $item->item_like_count; ?></i> Votes
                    <?php if ($this->user_m->is_loggedin()) { ?>
                        <?php if ($can_like_dislike): ?>
                            <?php if ($item->user_can_like): ?>
                                <a class="btn btn-mini like" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-up-2"> Vote</i>
                                </a>
                                <a class="btn btn-mini unlike" style="display:none;" href="javascript:void(0);" onclick="unlike('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-down-2"> Unvote</i>
                                </a>
                            <?php else: ?>
                                <a class="btn btn-mini unlike" href="javascript:void(0);" onclick="unlike('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-down-2"> Unvote</i>
                                </a>

                                <a class="btn btn-mini like" style="display:none;" href="javascript:void(0);" onclick="likeIncrease('<?php echo $item->id; ?>', this);">
                                    <i class="icon-thumbs-up-2">Vote</i>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2">Vote</i>
                        </a>
                    <?php } ?>
                </div>
        </div>
        <?php $i++; endforeach;?>
        
       
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
<?php  if (isset($page))$this->load->view('channel/wow/page/footer'); ?>
<script>    
	
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
