<!-- SLIDING MENU -->
<link rel="stylesheet" href="<?php echo config_item('assets_wow'); ?>js/sidr/stylesheets/jquery.sidr.dark.custom.css">

<script src="<?php echo config_item('assets_wow'); ?>js/sidr/jquery.sidr.min.js"></script>
<div id="sidr-right">
    <div class="tombol-panel" style="position: absolute; top : 150px; left: 0px;">
        <a href="#"><img src="<?php echo config_item('assets_wow'); ?>images/login-menu.png" /></a>
    </div>
    <div class="container-panel">
        <?php $this->load->view('channel/wow/login_wow'); ?>
    </div>
</div>

<div class="tombol-panel-one">
    <a href="#"><img src="<?php echo config_item('assets_wow'); ?>images/login-menu.png" /></a>
</div>