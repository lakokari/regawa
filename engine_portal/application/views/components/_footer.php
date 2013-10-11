<?php $retUrl = strstr(str_replace('/', '-', $this->uri->uri_string()),'auth')?'home':str_replace('/', '-', $this->uri->uri_string()) ; ?>


   <div id="footer"></div>
        </div> <!-- div content-wrap add by alex 8/5/2013 -->
   </div>
   <div id="charms" class="win-ui-dark slide">   
      <div id="theme-charms-section" class="charms-section">
         <div class="charms-header">
            <a href="#" class="close-charms win-backbutton"></a>
            <h2>Settings</h2>
         </div>
         <?php if ($is_loggedin):?>
          <div class="row-fluid">
            <div class="span12">
                <label for="win-theme-select"><a href="<?php echo site_url('auth/logout/'. $retUrl);?>">Logout</a></label>
                <p>Username : <?php  echo $this->session->userdata('username'); ?></p>
                <p>Name : <?php  echo $this->session->userdata('name'); ?></p>
                <p>Email : <?php  echo $this->session->userdata('email'); ?></p>
            </div>
         </div>
          <?php else: ?>
         <div class="row-fluid">
            <div class="span12">
                <?php $this->load->view('login/socialmedia');?>
            </div>
         </div>
         <br>

         <?php endif;?>
     <div style="width : auto;height : auto;padding-bottom : 30px;font-size : 12px;position : absolute;bottom : 0px;">
 <p>Best viewed with : <br>
 Chrome v28, Firefox v23, Safari for Mac v6.0.5<br>
 Resolution 1280 x 800 pixels
 </p>
  
 <p>Contact Us : info@uzone.co.id<br>
 Copyright &copy; Telkom Indonesia 2013<br>All Rights Reserved</p>
 
     </div>        
      </div>
   </div>
   <div class="leftmenu">
	 <div class="tombol">
            <a href="#" title="Click to Expand Panel Menu"><img src="<?php echo config_item("assets_url");?>css/img/button-panel-menu-click-here.png"></a>
	 </div>        
	 <ul class="dropdown-menu show" id='byfeature'>
            <li><a href='<?php echo base_url()?>'>Home</a></li>
            <?php foreach($channels as $category): ?>
            <li><a href='<?php echo base_url($category->name.'/channel')?>'><?php if($category->name == 'tv'){ echo 'TV'; } else { echo ucwords($category->name); }?></a></li> <!-- edited by alex 8/7/2013 -->
            <?php endforeach; ?>
	 </ul>
   </div>
<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/bootmetro-panorama.js"></script>
<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/bootmetro-pivot.js"></script>
<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/bootmetro-charms.js"></script>
<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/holder.js"></script>
<script type="text/javascript" src="<?php echo config_item("assets_url");?>js/demo.js"></script>
<script> 
     $(document).click( function(){
        $(".leftmenu").stop().animate({left:'-165px'});
        $('.tombol').click( function(event){
            event.stopPropagation();
            if($(".leftmenu").css('left')=='0px'){

                $(".leftmenu").animate({left:'-165px'});
            }else{

                $(".leftmenu").animate({left:'0px'});
            }
         });
         
         $('.panorama').panorama({
		 showscrollbuttons: true,
		 keyboard: true,
		 parallax: true
	  });
	  $('#pivot').pivot();
     });
</script> 