<?php 
//load page head html
$this->load->view('channel/wow/components/page_head'); 
?>
<?php 
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
    <!-- SLIDER -->
    <div id="slider">
        <div id="slider-code">
            <a href="#" class="buttons prev">left</a>
            <div class="viewport">
                <ul class="overview">
                    <li><img src="<?php echo config_item('assets_wow'); ?>images/picture7.jpg"></li>
                    <li><img src="<?php echo config_item('assets_wow'); ?>images/picture7.jpg"></li>
                    <li><img src="<?php echo config_item('assets_wow'); ?>images/picture7.jpg"></li>
                    <li><img src="<?php echo config_item('assets_wow'); ?>images/picture7.jpg"></li>
                </ul>
            </div>
            <a href="#" class="buttons next">right</a>
            <ul class="pager">
                <li><a rel="0" class="pagenum" href="#">Getting Started</a></li>
                <li><a rel="1" class="pagenum" href="#">Movie Project</a></li>
                <li><a rel="2" class="pagenum" href="#">Music Project</a></li>
                <li><a rel="3" class="pagenum" href="#">Your Project</a></li>
            </ul>
        </div>        
    </div>
    <!-- END of SLIDER -->
</div>
<!-- CONTENT BOTTOM -->
<div id="bottom">
    <div id="boxes">
        <div class="box">
            <?php foreach($previews as $preview): ?>
                <div class="kotak-1">
                    <span><img src="<?php echo config_item('assets_wow').'images/'.$preview->image_preview; ?>" /></span>
                    <span class="title">
                        <span class="icon"><img src="<?php echo config_item('assets_wow').'images/'.$preview->icon_preview; ?>" /></span>
                        <span class="text"><?php echo $preview->category_title; ?></span>
                    </span>
                    <span class="deskripsi">
                        <?php 
                            $preview = $preview->synopsis_category."...<a href='".base_url('wow/read/category').'/'.$preview->category_id."'>Read More</a>";
                        ?>
                        <?php echo $preview; ?>
                    </span>
                </div>
            <?php endforeach; ?>
            <?php foreach($tips_main as $tips): ?>
                <div class="kotak-4">
                    <span class="isi">
                        <span class="judul">
                            <?php echo $tips->title; ?>
                        </span>
                        <span class="desc">
                            <?php
                                $max_length = 320;
                                $length_tips = strlen($tips->content);
                                if ($length_tips > $max_length){
                                    $prev = substr($tips->content, 0, $max_length)."...<a href='".base_url('wow/read/index').'/'.$tips->id."'>Read More</a>";
                                } else {
                                    $prev = $tips->content;
                                }
                            ?>
                            <?php echo $prev; ?>
                        </span>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="footer" style="margin-top: 30px;">
            <div class="copy">Copyright &copy; 2013 <strong>UZone</strong> - All rights reserved.</div>
            <div class="logotelkom"><img src="<?php echo config_item('assets_wow'); ?>images/bytelkom.png" /></div>
        </div>
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
<?php $this->load->view('channel/wow/components/page_tail'); ?>

