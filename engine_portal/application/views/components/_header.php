
   <!--[if lt IE 7]>
   <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
   <![endif]-->
	<style>
		.btn {
			background : #d31821;
			color : #fff; 
		}
		a.link-title-up {
			color : #666;
			text-decoration: none;
		}
		a.link-title-up:hover {
			color : #666;
			text-decoration: underline;
		}
		#header-container a.header-dropdown {
			font-size: 18px;
			padding-left: 10px;
		}
                .user-info-status {
                    width: 200px;
                    height: 30px;
                    float : left;
                    text-align: right;
                    padding-top: 18px;
                    position: absolute;
                    top : 0px;
                    right: 65px;
                }
                
                
               
	</style>
   <div id="wrap">
	   <div id="content-wrap">  <!-- div content-wrap add by alex 8/5/2013 -->
   
      <!-- Header
      ================================================== -->
      <div id="nav-bar" class="">
         <div class="pull-left">
            <div id="header-container">
			   <?php if(!$active_menu): ?>
                <div id="logo"><h1 style="margin-left: 15px; font-size: 35px;"><a class="link-title-up" href="<?php echo base_url();?>">UZone</a></h1></div>
                <?php else: ?> 
				<div id="logo"><h1 style="margin-left: 15px; font-size: 35px;"><a class="link-title-up" href="<?php echo base_url();?><?php echo strtolower($active_menu)?>/channel"><?php if($active_menu == 'tv'){ echo 'TV'; } else { echo ucwords($active_menu); }?></a></h1></div>
				<?php echo $this->load->view('components/dropdown/'.$active_menu)?> <!-- edited by alex 8/7/2013 -->
				<?php endif; ?><!-- edited by Esgi 2013/08/20 -->
            </div>
         </div>

         <div class="pull-right">
             
             <div id="top-info" class="pull-right">
                 <div class="user-info-status">
                     Welcome <a id='user'>
                         <?php if ($this->user_m->is_loggedin()): ?>
                             
                             <span class="user"><?php echo ucfirst($this->session->userdata('name')); ?></span>
                             <img src="<?php echo $this->session->userdata('avatar'); ?>" width="30" height="30" />
                         <?php else: ?>
                             <i class='icon-user'></i>Guest
                         <?php endif; ?>
                     </a>
                 </div>
                 <a id="settings" href="#" class="win-command pull-right">
                     <div class="icon-settings-uzone"></div>
                 </a>
             </div>
		 <div class="pull-right" id='menu-right'>
                     <div class="input-append" style='margin-bottom:0;' id="search-box">
                            <?php if(ucwords($active_menu) == 'Radio') { ?>
                                <!-- <form action="<?php echo base_url(); ?>radio/channel" method="GET">
                                    <input class="span2" type="text" id="appendedInputButton" name="search_podcast" placeholder="Search...">
                                    <button class="btn" type="submit">Go!</button> -->
                                </form>
                            <?php } else { ?>
				<!-- <input class="span2" id="appendedInputButton" type="text" placeholder='Search...'> 
				<button class="btn" type="button" onclick="javascript:searchMe(this);">Go!</button>-->
                            <?php } ?>
			</div>
			
		 </div>
      </div>
      </div>