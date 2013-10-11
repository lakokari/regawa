<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />


<div class="content-container">
    
    <div class="margin-container" style="margin-top: 80px;">
        <!--
        <div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        <div class="left-sidebar">
            <img class="logo-wow-project" src="<?php echo config_item('assets_wow');?>css/img/wow-project-logo.png">
            <a class="upload-button" href="#"></a>
        </div>
        <div class="right-sidebar">
            <div class="title-event">WOW Project</div>
            <div class="underline-red"></div>
            <div class="desc-event">
                Uzone, be inspired here! Upload dan share video favorit kamu disini. Channel WOW Uzone dibuat untuk kamu yang kreatif dan ekspresif. Kamu bisa upload dan share video favorit kamu dengan mudah disini. <a href="#">Read More</a>
            </div>
            <div class="underline-red"></div>
            <div class="event-menu-container">
                
                <?php 
                if(isset($_GET['event'])) {
                    $get_event_id_url = $_GET['event'];
                    if($get_event_id_url == 1 OR $get_event_id_url == 2 OR $get_event_id_url == 3) {
                        $get_event_id_url = $get_event_id_url;
                    } else {
                        $get_event_id_url = 1;
                    }
                } else {
                    $get_event_id_url = 1;
                }
                ?>
                <?php $i = 1; ?>
                <?php foreach ($event_active as $event): ?>
                    <?php if($i == 1) { ?>
                        <a class="event-menu your-project <?php if($get_event_id_url == $i) { echo "current";} ?>" href="<?php echo base_url()."wow/channel/project?event=".$event->id; ?>" ></a>
                    <?php } elseif($i == 2) { ?>
                        <a class="event-menu ditial-idol <?php if($get_event_id_url == $i) { echo "current";} ?>" href="<?php echo base_url()."wow/channel/project?event=".$event->id; ?>"></a>
                    <?php } else { ?>
                        <a class="event-menu ten-second <?php if($get_event_id_url == $i) { echo "current";} ?>" href="<?php echo base_url()."wow/channel/project?event=".$event->id; ?>"></a>
                    <?php } ?>
                    
                        <?php $i++; ?>
                <?php endforeach; ?>
                
                <?php $j = 1; ?>
                <?php foreach ($event_active as $events): ?>
                    <?php if($j == 1 AND $get_event_id_url == 1) { ?>
                        <div class="circle-menu-container">
                            <?php foreach ($dropdown[$j] as $drops): ?>
                                <?php if ($drops->display_order >= 1) { ?>
                                    <?php if ($drops->content == NULL) { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/nominee/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                   <?php } elseif ($drops->content == "2") { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/roadshow/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } else { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/read') . '/index/' . $drops->id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } ?>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    <?php } elseif($j == 2 AND $get_event_id_url == 2) { ?>
                        <div class="circle-menu-container">
                            <?php foreach ($dropdown[$j] as $drops): ?>
                                <?php if ($drops->display_order >= 1) { ?>
                                    <?php if ($drops->content == NULL) { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/nominee/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } elseif ($drops->content == "1") { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/jury/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } elseif ($drops->content == "2") { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/roadshow/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } else { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/read') . '/index/' . $drops->id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } ?>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    <?php } elseif($j == 3 AND $get_event_id_url == 3){ ?>
                        <div class="circle-menu-container">
                            <?php foreach ($dropdown[$j] as $drops): ?>
                                <?php if ($drops->display_order >= 1) { ?>
                                    <?php if ($drops->content == NULL) { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/nominee/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } elseif ($drops->content == "1") { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/jury/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } elseif ($drops->content == "2") { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/channel') . '/roadshow/' . $drops->event_id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } else { ?>
                                        <a class="circle-menu" href="<?php echo base_url('wow/read') . '/index/' . $drops->id; ?>" data="<?php echo $drops->id; ?>"><?php echo $drops->title; ?></a>
                                    <?php } ?>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    <?php } ?>
                <?php $j++; ?>
                <?php endforeach; ?>
                
                    
                
                
            </div>
            
        </div>
    </div>
</div>


<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>
<script>
    var is_loggedin = '<?php echo $is_loggedin;?>';
    $('.upload-button').click(function (){
        if (is_loggedin==='yes'){
            window.location = '<?php echo base_url(); ?>wow/channel/upload';
        }else{
           alert('Anda harus login untuk upload');
           $('.tombol-panel-one').click();
        }
    });
	
    function show(id) {
        document.getElementById(id).style.display = "block";
    }
    
    function hide(id) {
        document.getElementById(id).style.display = "none";
    }
</script>
