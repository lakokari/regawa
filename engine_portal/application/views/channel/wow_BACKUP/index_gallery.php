<?php 
//load page head html
$this->load->view('channel/wow/components/page_head'); 
$this->load->view('channel/wow/components/slide_left_menu');
?>
<div id="content">
    <div id="header">
        <div class="logo">
            <span class="main"><img src="<?php echo config_item('assets_wow'); ?>images/logo.png" /></span>
            <span class="sub"><img src="<?php echo config_item('assets_wow'); ?>images/logo_wow.png" /></span>
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
            <li><a href="#">What's Wow?</a>
            	<ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Rules</a></li>
                    <li><a href="#">Upload</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">Video Gallery</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </li>
            <li><a href="#">10 Seconds Movie</a>
            	<ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Rules</a></li>
                    <li><a href="#">Upload</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">Video Gallery</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </li>
            <li><a href="#">Digital Idol</a>
            	<ul>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Rules</a></li>
                    <li><a href="#">Upload</a></li>
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">Video Gallery</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </li>
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
                    <li><a class="current" href="#">About</a></li>
                    <li><a href="#">Rules</a></li>
                    <li><a href="#">How to Join</a></li>
                    <li><a href="#">Schedule</a></li>
                    <li><a href="#">Video Galery</a></li>
                </ul>
            </div>
        </div>
        <div class="wrap-container">
            
        </div>
        <div class="right-container">
            <div class="full-width-container">
                <div class="title-big-container">10 Seconds Movie //</div> <div class="title-big-container red"> &nbsp;About</div>
            </div>
            <div class="full-width-container">
                <div class="title-gallery">Recent Uploads</div>
                <div class="showall-gallery"><a href="#">Show All</a></div>
            </div>
            <div class="gallery-container">
                
            </div>
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
<!-- SLIDING MENU -->
 <link rel="stylesheet" href="<?php echo config_item('assets_wow'); ?>js/sidr/stylesheets/jquery.sidr.dark.css">
<!-- Include jQuery -->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.js"></script>
<!-- Include the Sidr JS -->
<script src="<?php echo config_item('assets_wow'); ?>js/sidr/jquery.sidr.min.js"></script>
<a id="right-menu" href="#right-menu"><img src="<?php echo config_item('assets_wow'); ?>images/login-menu.png" /></a>
<script>
$(document).ready(function() {
$('#right-menu').sidr({
name: 'sidr-right',
side: 'right'
});
});
</script>

</body>
</html>
