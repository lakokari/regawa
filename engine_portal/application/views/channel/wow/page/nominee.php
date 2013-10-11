<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/gallery_nav.css" rel="stylesheet" type="text/css" />

<style>
.gallery-video-title {
    margin: 0px;
    padding: 3px 10px;
    bottom: 25px;
    position: absolute;
}

.gallery-video-date {
    margin: 0px;
    padding: 3px 10px;
    bottom: 9px;
    position: absolute;
    text-transform: capitalize;
}

a.btn {
    background-color: #d01d19;
    border-radius: 5px 5px 5px 5px;
    display: inline;
    height: auto;
    padding: 5px 10px;
    width: auto;
    font-family: Arial,Helvetica,sans-serif;
    margin: 0px 5px;
}

a.detail{
    background-color: #999;
    border-radius: 5px 5px 5px 5px;
    display: inline;
    height: auto;
    padding: 5px 10px;
    width: auto;
    font-family: Arial,Helvetica,sans-serif;
    margin: 0px 5px;
}

a.detail:hover {
    text-decoration: none;
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

        <?php
        $criteria_url='';
        if ($criteria!='' || $criteria!=NULL){
            $criteria_url='?criteria='.$criteria;
        }else{
            $criteria_url='';
        }
        ?>
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
                <form method="get" accept-charset="utf-8" action="<?php echo base_url()."wow/channel/nominee/".$event_id; ?>" />
            <input type="text" name="criteria" value="all" class="input-search" />
            <input type="submit" value="Search" class="btn-search"/>
        </form>
        <div class="gallery-header">
            <?php if($event_name == '10 Seconds') {?>
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $event_id; ?>">
                <div class="gallery-logo-event ten-seconds"></div>
			</a>
            <?php } elseif($event_name == 'Digital Idol') {?>
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $event_id; ?>">
                <div class="gallery-logo-event digital-idol"></div>
			</a>
            <?php } else {?>
			<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $event_id; ?>">
                <div class="gallery-logo-event your-project"></div>
			</a>
            <?php } ?>
                <div class="gallery-heading-title" style="width: auto;">Nominee</div>

            <div class="gallery-nav-container">
                <span class="gallery-nav-sort-span">sort by</span>
                <ul id="galleryNav">
                    <li><?php
                    if(isset($sort_by_vote)){
                        switch ($sort_by_vote) {
                            case 'desc' :
                                echo '<a class="sort_down" href="'.base_url().'wow/channel/nominee/'.$event_id.'/lowest_vote/'.$criteria_url.'">Vote</a>';
                                break;
                            case 'asc' :
                                echo '<a class="sort_up" href="'.base_url().'wow/channel/nominee/'.$event_id.'/highest_vote/'.$criteria_url.'">Vote</a>';
                                break;
                            default :
                                echo '<a href="'.base_url().'wow/channel/nominee/'.$event_id.'/highest_vote/'.$criteria_url.'">Vote</a>';
                                break;
                        }
                    } else {
                       echo '<a href="'.base_url().'wow/channel/nominee/'.$event_id.'/highest_vote/'.$criteria_url.'">Vote</a>';
                    }
                        ?>
                    </li>
                    <li><?php
                    if(isset($sort_by_date)){
                        switch ($sort_by_date) {
                            case 'desc' :
                                echo '<a class="sort_down" href="'.base_url().'wow/channel/nominee/'.$event_id.'/oldest_date/'.$criteria_url.'">Date</a>';
                                break;
                            case 'asc' :
                                echo '<a class="sort_up" href="'.base_url().'wow/channel/nominee/'.$event_id.'/newest_date/'.$criteria_url.'">Date</a>';
                                break;
                            default :
                                echo '<a href="'.base_url().'wow/channel/nominee/'.$event_id.'/newest_date/'.$criteria_url.'">Date</a>';
                                break;
                        }
                    } else {
                       echo '<a href="'.base_url().'wow/channel/nominee/'.$event_id.'/newest_date/'.$criteria_url.'">Date</a>';
                    }
                        ?>
                    </li>
                    <li><a href="#">Kind</a>
                        <ul>
                            <li><a href="<?php echo base_url()."wow/channel/nominee/".$event_id."/recent/".$criteria_url;?>">Recent Upload</a></li>
                            <li><a href="<?php echo base_url()."wow/channel/nominee/".$event_id."/recentplayed".$criteria_url;?>">Recent Played</a></li>
                            <li><a href="<?php echo base_url()."wow/channel/nominee/".$event_id."/favorite".$criteria_url;?>">Most Favorite</a></li>
                            <li><a href="<?php echo base_url()."wow/channel/nominee/".$event_id."/all".$criteria_url;?>">All Video</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Genre</a>
                        <ul>
                            <?php foreach ($get_genre->result() as $genre) { ?>
                                <li><a href="<?php echo base_url()."wow/channel/nominee/".$event_id."/genre-".$genre->id."-".$genre->name."/".$criteria_url;?>"><?php echo $genre->name; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="gallery-type-title">
            <?php echo $which_name; ?>
        </div>
        
        <?php $i=0; foreach ($items as $item):?>
        <div class="gallery-video-container">
            <div class="gallery-video-thumb">
                <a href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                    <img src="<?php echo $item->item_thumbnail;?>">
                    <div class="gallery-overlay-play-icon">
                        <div class="gallery-video-title"><?php echo $item->item_name;?></div>
                        <div class="gallery-video-date"><?php echo $item->created_by_name;?></div>
                    </div>
                </a>
            </div>
            <div class="gallery-vote-container">
                    <?php if($item->wowticket==1){ ?>
                        <div style="float:left; margin-top:-8px; margin-right:2px;">
                            <img src="<?php echo config_item('assets_url');?>img/star/star_nominee.png" width="35" height="35" title="Nominee">
                        </div>
                    <?php }else{

                    } ?>
                    <span style="color:#d01d19; float:right; margin-right:10px;"><?php echo $item->item_like_count; ?> Votes</span>
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
                    <div style="float:left;" style="margin-top:2px;">
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            Vote
                        </a>
                    </div>
                    <div style="float:left;" style="margin-top:2px;">
                        <a class="detail" href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                            Detail
                        </a>
                    </div>
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
