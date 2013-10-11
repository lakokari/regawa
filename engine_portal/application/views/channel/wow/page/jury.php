<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />
<style>
    .biography-value-span ul {
        margin: 0;
        margin-left: -15px;
    }
</style>  



<div class="content-container">
    
    <div class="margin-container" style="margin-top: 80px;">
        <!--<div class="banner-container left">
            Banner Space160x600
        </div>
        <div class="banner-container right">
            Banner Space160x600
        </div>-->
        
        <div class="left-sidebar">
		<a href="<?php echo base_url();?>wow/channel/project?event=<?php echo $get_event_id; ?>">
            <img style="display: block;margin: auto; width : 300px;" src="<?php echo config_item('assets_wow');?>css/img/<?php echo $wow_event_img;?>">
		</a>
        </div>
        <div class="right-sidebar">
            <div class="statik-title-big">Jury</div>
            <div class="underline-red thin"></div>
            
            <?php foreach ($jury as $data): ?>
            <div class="biography-container">
                <div class="biography-photo-profile">
                    <img src="<?php echo config_item('assets_wow')?>css/img/<?php echo $data->avatar;?>">
                </div>
                <div class="biography-name-container">
                    <span class="biography-name-span"><?php echo $data->sure_name;?></span>
                    <span class="biography-job-span"><?php echo $data->occupation;?></span>
                </div>
                <div class="biography-name-container unborder">
				<?php if ($data->age!='0'){?>
                    <span class="biography-field-span">Umur</span>
                    <span class="biography-value-span"><?php echo $data->age;?></span>
				<?php } ?>
				<?php if ($data->creation){?>
                    <span class="biography-field-span">Karya</span>
                    <span class="biography-value-span"><?php echo $data->creation;?> </span>
				<?php } ?>
				<?php if ($data->motto){?>
                    <span class="biography-quote-span">&#8220; <?php echo $data->motto;?> &#8221;</span>
				<?php } ?>
                </div>
            </div>
            <div class="statik-content">
                <?php echo $data->description;?>
                <br><br>
                <table>
                    <tr>
						<?php if ($data->facebook_id){?>
                        <td><a href="https://www.facebook.com<?php echo $data->facebook_id;?>" target="_blank" class='footer-sosmed facebook'><?php echo $data->facebook_id;?></a></td>
						<?php } ?>
						<?php if ($data->tweeter_id){?>
                        <td><a href="https://www.twitter.com/<?php echo str_replace('@','',$data->tweeter_id);?>" target="_blank" class='footer-sosmed twitter'><?php echo $data->tweeter_id;?></a></td>
						<?php } ?>
					</tr>
                </table>
                <br><br>
            </div>
            <?php endforeach; ?>
            
            
<!--             <div class="biography-container">
                <div class="biography-photo-profile">
                    <img src="<?php echo config_item('assets_wow')?>css/img/sample-jury-1.png">
                </div>
                <div class="biography-name-container">
                    <span class="biography-name-span">Raditya dika</span>
                    <span class="biography-job-span">sutradara / komedian</span>
                </div>
                <div class="biography-name-container unborder">
                    <span class="biography-field-span">umur</span>
                    <span class="biography-value-span">26 Tahun</span>
                    <span class="biography-field-span">Karya</span>
                    <span class="biography-value-span">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec ullamcorper augue. </span>
                    <span class="biography-quote-span">&#8220; Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec ullamcorper augue. &#8221;</span>
                </div>
            </div>
            <div class="statik-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec ullamcorper augue. Phasellus elit turpis, rutrum varius sagittis commodo, tincidunt non magna. Fusce lobortis lobortis lorem, et elementum ligula luctus lobortis. Integer vel fermentum nibh. Vivamus augue lorem, pulvinar vitae gravida sed, ornare a velit. Nam vel vestibulum felis, nec dignissim nisl. Curabitur ut tellus elementum, pharetra turpis vel, ullamcorper augue. Curabitur sed purus et leo fermentum feugiat semper et arcu. Donec egestas, neque in suscipit mollis, felis lacus sodales tellus, eu malesuada mi purus pulvinar nibh. Morbi porttitor laoreet sapien, id tincidunt eros condimentum at.
                <br><br>
                <table>
                    <tr>
                        <td><a href='#' class='footer-sosmed facebook'>/radityarika</a></td>
                        <td><a href='#' class='footer-sosmed twitter'>@radityarika</a></td>
                    </tr>
                </table>
                <br><br>
            </div>
            
            <div class="biography-container">
                <div class="biography-photo-profile">
                    <img src="<?php echo config_item('assets_wow')?>css/img/sampel-image-1.jpg">
                </div>
                <div class="biography-name-container">
                    <span class="biography-name-span">Jury Lain</span>
                    <span class="biography-job-span">sutradara / producer</span>
                </div>
                <div class="biography-name-container unborder">
                    <span class="biography-field-span">umur</span>
                    <span class="biography-value-span">28 Tahun</span>
                    <span class="biography-field-span">Karya</span>
                    <span class="biography-value-span">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec ullamcorper augue. </span>
                    <span class="biography-quote-span">&#8220; Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec ullamcorper augue. &#8221;</span>
                </div>
            </div>
            <div class="statik-content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec ullamcorper augue. Phasellus elit turpis, rutrum varius sagittis commodo, tincidunt non magna. Fusce lobortis lobortis lorem, et elementum ligula luctus lobortis. Integer vel fermentum nibh. Vivamus augue lorem, pulvinar vitae gravida sed, ornare a velit. Nam vel vestibulum felis, nec dignissim nisl. Curabitur ut tellus elementum, pharetra turpis vel, ullamcorper augue. Curabitur sed purus et leo fermentum feugiat semper et arcu. Donec egestas, neque in suscipit mollis, felis lacus sodales tellus, eu malesuada mi purus pulvinar nibh. Morbi porttitor laoreet sapien, id tincidunt eros condimentum at.
                <br><br>
                <table>
                    <tr>
                        <td><a href='#' class='footer-sosmed facebook'>/radityarika</a></td>
                        <td><a href='#' class='footer-sosmed twitter'>@radityarika</a></td>
                    </tr>
                </table>
                <br><br>
            </div>
 -->            
            
            
        </div>
    </div>
</div>

<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>

