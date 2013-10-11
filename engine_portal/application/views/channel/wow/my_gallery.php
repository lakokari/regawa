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
                <div class="title-big-container"><?php echo $this->session->userdata('name'); ?> //</div> <div class="title-big-container red"> &nbsp;Gallery</div>
            </div>
            <?php $i=0; foreach ($items as $item):?>
            
            <div class="gallery-container">
                <div class="gallery-thumb-container">
                    <a title="Play video" href="<?php echo site_url('wow/channel/detail/'.$item->id); ?>">
                        <img src="<?php echo $item->item_thumbnail;?>" />
                        <div class="gallery-play-button"></div>
                    </a>
                </div>
                <div class="gallery-tittle-container"><?php echo $item->item_name;?></div>
                <div class="gallery-description-container"><?php echo $item->item_description;?></div>
            
            </div>
            <?php $i++; endforeach;?>
            <?php if ($pagination):?>
            <div class="gallery-pagging-container pagination-centered">
                <?php echo $pagination;?>
            </div>
            <?php endif;?>
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
