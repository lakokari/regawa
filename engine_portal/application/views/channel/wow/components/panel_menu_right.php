<!-- SLIDING MENU -->
<link rel="stylesheet" href="<?php echo config_item('assets_wow'); ?>sidr/stylesheets/jquery.sidr.dark.custom.css">

<script src="<?php echo config_item('assets_wow'); ?>sidr/jquery.sidr.min.js"></script>

<div id="sidr-right">
    <div class="tombol-panel" style="position: absolute; top : 150px; left: 0px;">
        <a href="#"><img src="<?php echo config_item('assets_wow'); ?>images/login-menu.png" /></a>
    </div>
    <div class="container-panel">
        <?php $this->load->view('channel/wow/components/login_wow'); ?>
    </div>
</div>

<div class="tombol-panel-one">
    <a href="#"><img src="<?php echo config_item('assets_wow'); ?>images/login-menu.png" /></a>
</div>

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
        
        $('.wow-icon-settings').sidr({
            name: 'sidr-right',
            side: 'right',
            body: ''
        });
        
        $('.tombol-panel-one').click(function(){
            $('.container-panel').show();
        });
        
        $('.wow-icon-settings').click(function(){
            $('.container-panel').show();
        });
       
		
	$('.tombol-panel-one').show();
        $('.tombol-panel').show();
		
    });
</script>