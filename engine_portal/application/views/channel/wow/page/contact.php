<!-- slide panel item-->
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />
<style>
    input, textarea , select{
        background: #181717;
        border : 1px solid #232222;
    }
	input[type="text"],input[type="submit"],input[type="reset"]{padding:2px;}
	
	.errormsg
	{
		font-size:12px;
		padding-left:5px;
	}

	.title-address{
		padding-top:100px;
		font-weight:bold;
	}
	#addr-sosmed a{
		float:left;
		
	}
</style>



<div class="content-container">
    
    <div class="margin-container" style="margin-top: 80px;">
        <a href="<?php echo base_url();?>wow/channel/upload" class="upload-button-red"></a>
        
		<div class="statik-title-big">Contact Us</div>
		
		 <div class="left-sidebar">
			<br/>
			<span class="title-address">Head Office:</span><br/><br/>
			<span>Gedung Menara Multimedia</span><br/>
			<span>Jalan Kebon Sirih No. 10-12</span><br/>
			<span>Jakarta Pusat - 10110</span><br/><br/>
			<div id="addr-sosmed">
			<a href='https://twitter.com/UZoneIndonesia' target="_blank" class='footer-sosmed twitter'>@UzoneIndonesia</a>
			<a href='https://www.facebook.com/UZoneIndonesia' target="_blank" class='footer-sosmed facebook'>/UzoneIndonesia</a>
			</div>
		 </div>
        <div class="right-sidebar">
		
		
		<div class="rule"></div>
		
		<div class="contactform">
		<?php echo '<div class="errormsg">'.str_replace(array("The","is required"),array("","harus diisi"),validation_errors()).'</div>'; ?>
		<table id="contact">
		<?php
			echo form_open(current_url(), array('id' => 'form', 'name' => 'form', 'autocomplete' => 'on'));
			echo form_open('wow/channel/contact') . "<br />"; 
			echo "<tr><td>".form_label('Name * ', 'name'). "</td><td>" . form_input('name', set_value('name'),'maxlength="40"') . "</td></tr>";
			echo "<tr><td>".form_label('Email * ', 'email'). "</td><td>" . form_input('email', set_value('email'),'maxlength="50"') . "</td></tr>";
			echo "<tr><td>".form_label('Phone * ', 'phone'). "</td><td>" . form_input('phone', set_value('phone'),'maxlength="30"') . "</td></tr>";

			$data = array(
				'name' => 'content',
				'id' => 'content',
				'value' => set_value('content'),
				'rows' => '6',
				'cols' => '70',
				'style' => 'margin: 0; padding: 0;',
				);
			
			echo "<tr><td>".form_label('Content * ', 'content'). "</td><td>" . form_textarea($data) . "</td></tr>";
			echo "<tr><td>".$captcha['image']. "</td><td>" .form_input('confirmCaptcha', set_value('confirmCaptcha')) . "</td></tr>";

			echo "<tr><td>".form_submit('submit', 'Kirim Pesan') . "</td></tr>";
			echo form_close();
		?>
		</table>
		</div>
            
            
        </div>
    </div>
</div>

<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>