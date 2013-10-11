<?php 
//load page head html
$this->load->view('channel/wow/components/page_head'); 
?>
<?php $this->load->view('channel/wow/components/slide_left_menu'); ?>

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

<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />

<style>
    /* custom tab content */
    ul.tabs {
        height: 24px;
    }

    div.tabcontents {
        padding-top: 10px;
        padding-left: 0px;
        padding-right: 0px;
        background : none;
        border-radius: 0 2px 2px 2px;
        -webkit-border-top-right-radius: 10px;
        -webkit-border-top-left-radius: 10px;
        -moz-border-radius-topright: 10px;
        -moz-border-radius-topleft: 10px;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
    }
</style>

<div class="page">
    <div class="content-container">
        <div id="gallery">
            <div class="full-width-container">
                <div class="title-big-container"><?php echo $wow_item->item_name;?> //</div> 
                <div class="title-big-container red"> &nbsp;by <?php echo $wow_item->created_by_name;?></div>
            </div>
            <div class="gallerydetail-player-container">
                <div id="video-player"><img src="<?php echo $wow_item->item_thumbnail;?>" width="500" height="300" /></div>
				<div><!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style ">
						<a class="addthis_counter addthis_pill_style"></a>
						<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
						<a class="addthis_button_tweet"></a>
					</div>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51de9ac26202a940"></script>
					<!-- AddThis Button END -->
				</div>
            </div>
            <div class="gallerydetail-detail-container">
                <ul class="tabs" persist="true">
                    <li>
                        <a rel="desc" href="#desc" data-toggle="tab">Deskripsi</a>
                    </li>
                    <li>
                        <a rel="castncrue" href="#castncrue" data-toggle="tab">Info</a>
                    </li>

                </ul>
		<div class="tabcontents">
                    <div id="desc" class="tabcontent">
                        <?php echo $wow_item->item_description;?>
                    </div>

                    <div id="castncrue" class="tabcontent">
                        <table class="table">
                            <?php foreach($custom_field as $field): ?>
                            <tr>
                                <td><?php echo $field->event_field;?></td>
                                <td><?php echo $field->fieldvalue;?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
		</div>
            </div>
            
            
            <div class="full-width-container" style="margin-top : 20px;">
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
                                <i class="icon-thumbs-up-2"> Vote</i>
                            </a>
                            <?php endif;?>
                        <?php endif;?>
                    <?php } else { ?>
                        <a class="btn btn-mini like" href="javascript:void(0);" onclick="mustLogin();">
                            <i class="icon-thumbs-up-2"> Vote</i>
                        </a>
                    <?php } ?>
                    
                   
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
            
            //call jw player to handle video
            jwplayer('video-player').setup({
                file: '<?php echo $wow_item->item_url;?>',
                image: '<?php echo $wow_item->item_thumbnail;?>',
                autostart: true,
                'modes': [
                    {type: 'flash', src: "jwplayer.flash.swf"},
                    {type: 'html5'}
                ],
		width: 500,
                height: 300
            
            });
            
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
