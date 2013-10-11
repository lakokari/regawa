<style>
    #sidr-right * {color: #fff;}
</style>
<div style="width: 220px; padding: 20px;">
    <?php $retUrl = strstr(str_replace('/', '-', $this->uri->uri_string()),'auth')?'home':str_replace('/', '-', $this->uri->uri_string()) ; ?>
        <?php if ($this->user_m->is_loggedin()): ?>
        <div class="row-fluid">
            <div class="span12">
                <div style="font-size: 25px; color : #fff; margin-bottom: 30px;"><a style="font-size: 25px; color : #fff;" href="<?php echo site_url('auth/logout/' . $retUrl); ?>">Logout</a></label></div>
                <p>Username : <?php echo $this->session->userdata('username'); ?></p>
                <p>Name : <?php echo $this->session->userdata('name'); ?></p>
                <p>Email : <?php echo $this->session->userdata('email'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="row-fluid">
            <div class="span12">
                <div style="font-size: 25px; color : #fff; margin-bottom: 30px;">Login</div>
                <?php $this->load->view('login/socialmedia'); ?>
            </div>
        </div>
        <br>

        <?php endif; ?>
            <div style="width : auto;height : auto;padding-bottom : 30px;font-size : 12px;position : absolute;bottom : 0px;">
                <p>Best viewed with : <br>
                   Chrome v28, Firefox v23, Safari for Mac v6.0.5<br>
                   Resolution 1280 x 800 pixels
                </p>

                 <p>Contact Us : info@uzone.co.id<br>
                 Copyright &copy; Telkom Indonesia 2013<br>All Rights Reserved</p>
           </div>
    </div>