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
        <div class="left-container">
            <div id="nav">
                <ul>
                    <?php foreach($left_menu as $left): ?>
                        <?php if($left->display_order >= 1) { ?>
                            <?php if($left->content !== "") { ?>
                                <li><a href="<?php echo base_url().'wow/read/index/'.$left->id; ?>"><?php echo $left->title; ?></a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo base_url().'wow/channel/gallery/'.$left->event_id; ?>"><?php echo $left->title; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="wrap-container">
            
        </div>
        <div class="right-container">
            <div class="full-width-container">
                <div class="title-big-container"><?php echo $category_title; ?></div>
            </div>
            <p>
                <?php echo $content; ?>
            </p>
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
</script>

</body>
</html>
