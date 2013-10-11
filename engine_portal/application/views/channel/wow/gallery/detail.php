<?php
if (!defined('TYPE_VIDEO')){
    define ('TYPE_VIDEO', 'video');
}
if (!defined('TYPE_IMAGE')){
    define ('TYPE_IMAGE', 'image');
}
?>
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
</style>

<div class="content-container">
    
    <div class="margin-container" style="margin-top: 60px;">
        <div class="gallery-header">
            <!--<div class="gallery-logo-event <?php echo $event_item->slug;?>"></div>-->
            <div class="gallery-heading-title" style="font-size:30px;width:100%;"><a href="javascript:window.history.back();"><?php echo $event_item->name; ?> Gallery</a></div>
        </div>    
        
        <div class="gallery-sidebar-left">
            <div class="video-player-container" id="video-player">
                <img src="<?php echo $gallery_item->cover_image;?>" width="100%" height="100%" />
            </div>
        </div>
        <div class="desc-video-container">
            <div class="desc-title-container">
                <span class="span-desc-video-title"><?php echo $gallery_item->title;?></span>
                <span class="span-desc-video-title small">Date: <?php echo indonesia_date_format('D, d M Y', strtotime($gallery_item->date_time));?></span>
            </div>
            <span class="span-desc-value"><?php echo $gallery_item->bodyText;?></span>

            <div class="sosmed-gallery">

                <a class="gallery-share" rel="nofollow" href="javascript://" onclick="return fbs_click('<?php echo site_url('wow/gallery/detail/'.TYPE_VIDEO.'/'.$gallery_item->id); ?>');">
                    <img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-fbshare-circle.png'; ?>" width="80px"/>
                </a>

                <a class="gallery-twitter" href="https://twitter.com/share?url=<?php echo site_url('wow/gallery/detail/'.TYPE_VIDEO.'/'.$gallery_item->id); ?>&text=<?php echo $gallery_item->title.' by UZone';?>"  target="_blank">
                    <img src="<?php echo config_item('assets_wow').'css/img/icon-sosmed-tweet-circle.png'; ?>" width="80px"/>
                </a>		

            </div>    
        </div>
    </div>
</div>
<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>
<script>
    $('#myslider1').swipePlanes();
    $(document).ready(function() { 
        //call jw player to handle video
        jwplayer('video-player').setup({
				primary: 'flash',
				startparam: "start",
                file: '<?php echo config_item('userfiles'). "wow/gallery/video/". $gallery_item->file_name; ?>',
                image: '<?php echo config_item('userfiles'). "wow/gallery/image/". $gallery_item->cover_image; ?>',
                //autostart: true,
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
