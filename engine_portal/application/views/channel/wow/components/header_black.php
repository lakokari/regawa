<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43134369-1', 'uzone.co.id');
  ga('send', 'pageview');

</script>
<div class="header">
    <div class="margin-container" style="height: 115px;">
        <a href="<?php echo base_url();?>" class="logo"></a>
        <!--<a href="<?php echo base_url();?>wow/channel" class="wow-logo"></a>-->
		<a href="<?php echo base_url()?>wow/channel" class="channel-title">
            WOW
        </a>
        <div class="user-info-status">
            <?php if ($this->user_m->is_loggedin()) { ?>
            <a href="#" class="user-info"><?php echo $this->session->userdata('name'); ?> </a> <img src="<?php echo $this->session->userdata('avatar'); ?>" width="30" height="30" align="right" valign="absmiddle"/>
            <?php } else { ?>
                Welcome, Guest
            <?php } ?>
        </div>
    </div>
    
</div>
<div class="coolmenu-container">
    <div class="menu-bg">
        <div class="margin-container" style="height: 43px;">
            <ul id="coolMenu">
                <?php $i = 1; ?>
                <?php foreach ($event_active as $event): ?>
                    <li><a href="<?php 
					if($event->id == 1) {
						echo base_url()."wow/read/index/1";
					} elseif($event->id == 2) {
						echo base_url()."wow/read/index/12";
					} else {
						echo base_url()."wow/read/index/7";
					}
					?>"><?php if($event->id == 1) { echo "Wow Project"; } else {echo $event->name; }?></a>
                        <ul>
                            <?php foreach ($dropdown[$i] as $drop): ?>
                                <?php if ($drop->display_order >= 1) { ?>
                                    <?php if ($drop->content == NULL) { ?>
                                        <li><a href="<?php echo base_url('wow/channel') . '/nominee/' . $drop->event_id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                                    <?php } elseif ($drop->content == "1") {?>
                                        <li><a href="<?php echo base_url('wow/channel') . '/jury/' . $drop->event_id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                                    <?php } elseif ($drop->content == "2") {?>
                                        <li><a href="<?php echo base_url('wow/gallery') . '/index/' . $drop->event_id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                                    <?php } elseif ($drop->content == "3") {?>
                                        <li><a href="<?php echo base_url('wow/channel') . '/nominee/' . $drop->event_id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                                    <?php } elseif ($drop->content == "6") 
                                        /*scedhule menu*/
                                        {?>
                                        <li><a href="<?php echo base_url('wow/channel') . '/schedule/' . $drop->event_id; ?>"><?php echo $drop->title; ?></a></li>                                                                                
                                    <?php } elseif ($drop->content == "comingsoon") {?>                                        
                                        <li><a href="<?php echo base_url('wow/channel') . '/comingsoon/' ?>"><?php echo $drop->title; ?></a></li>                                                                                
                                    <?php } else { ?>
                                        <li><a href="<?php echo base_url('wow/read') . '/index/' . $drop->id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php $i++; ?>
                <?php endforeach; ?>
				<?php if ($this->user_m->is_loggedin()):?>
                    <li><a href="<?php echo site_url('wow/channel/mygallery');?>">My Project</a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <div class="submenu-bg"></div>
</div>