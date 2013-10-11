<?php $retUrl = strstr(str_replace('/', '-', $this->uri->uri_string()),'auth')?'home':str_replace('/', '-', $this->uri->uri_string()) ; ?>

<!-- FB Login button -->
<a href="<?php echo site_url('auth/fb_login_init').'/'.$retUrl;?>">
    <img src="<?php echo config_item('assets_url'). 'img/facebook-login.png';?>" />
</a>

<!-- Twitter Logi button -->
<a href="<?php echo site_url('auth/tw_login_init') .'/'.$retUrl;?>">
    <img src="<?php echo config_item('assets_url'). 'img/twitter-login.png';?>" />
</a>