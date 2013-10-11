<!DOCTYPE HTML>
    <!--[if lt IE 7 ]> <html lang="en" class="ie ie6"> <![endif]--> 
    <!--[if IE 7 ]>	<html lang="en" class="ie ie7"> <![endif]--> 
    <!--[if IE 8 ]>	<html lang="en" class="ie ie8"> <![endif]--> 
    <!--[if IE 9 ]>	<html lang="en" class="ie ie9"> <![endif]--> 
    <!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
		<?php
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
        header('Location: http://m.uzone.co.id');
        ?>
        <meta charset="utf-8">
        <title><?php echo $meta_title; ?></title>
		<meta name="description" content="Portal UZone yang merupakan Single eEntertainment Portal dari berbagai jenis konten, yaitu video, musik, eBook, apps Store, eRadio dan game." />        
		<meta name="keywords" content="uzone, uzone indonesia, digital, telkom, media, music, movie, useetv, apps, telkomspeedy, telkomstore, webstore, melon" />        
		<link rel="canonical" href="http://www.uzone.co.id/" />

		<meta property="og:type" content="blog" /> 
		<meta property="og:title" content="UZone – Educate, Enlight, Entertain" /> 
		<meta property="og:description" content=" Portal UZone yang merupakan Single eEntertainment Portal dari berbagai jenis konten, yaitu video, musik, eBook, apps Store, eRadio dan game." /> 
		<meta property="og:url" content="http://www.uzone.co.id/" />
		<meta property="og:site_name" content="<?php echo $meta_title; ?>" />

        <meta http-equiv="X-UA-Compatible" content="chrome=1">
        <link rel="icon"  type="image/png" href="<?php echo config_item('assets_url'); ?>favicon.png">
        
        <link rel="stylesheet" type="text/css" href="<?php echo config_item('assets_url'); ?>css/style_panel_channel.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo config_item('assets_url'); ?>css/component.css" />
        
        
        <link rel="stylesheet" type="text/css" href="<?php echo config_item('assets_url'); ?>js/vegas/jquery.vegas.css">
        <link rel="stylesheet" type="text/css" href="<?php echo config_item('assets_url'); ?>css/styles.css">
        
        <!-- <script src="http://code.jquery.com/jquery-1.10.0.min.js"></script> -->
        <script src='<?php echo config_item('assets_url');?>js/jquery-1.10.0.min.js'></script>
        <!-- <script>window.jQuery || document.write("<script src='<?php echo config_item('assets_url');?>js/jquery-1.10.0.min.js'>\x3C/script>")</script> -->
        
        <script src="<?php echo config_item('assets_url'); ?>js/modernizr.custom.js"></script>
        <script type='text/javascript'>//<![CDATA[ 
            $(window).load(function(){

                $('#click').click( function(event){
                    event.stopPropagation();
                    $("#panel").animate({width:'toggle'},500);         
                });

                $('#panel').click( function(event){
                    event.stopPropagation();
                });

                $(document).click( function(){
                    $("#panel").hide(450);
                });
                $('#click').click();
                setTimeout(function() {
                      $('#click').click();
                }, 2000);
            });//]]>  

        </script>

<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>css/supersized/supersized.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>css/supersized/supersized.shutter.css" type="text/css" media="screen" />
				
		<script type="text/javascript" src="<?php echo config_item('assets_url'); ?>js/supersized/supersized.3.2.7.min.js"></script>
		<script type="text/javascript" src="<?php echo config_item('assets_url'); ?>js/supersized/supersized.shutter.min.js"></script>





		
		<script type="text/javascript">			
			jQuery(function($){				
				$.supersized({				
					// Functionality
					slide_interval          :   3000,
					transition              :   1, 			
					transition_speed		:	700,
					// Components							
					slide_links				:	'blank',
					slides 					:  	[	
													<?php foreach($home_wall as $wall){ ?>





														{image : '<?php echo config_item('image_url').'wall-home/'.$wall->file_name;?>'},
													<?php } ?>

												]					
				});
			});		    
			</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43134369-1', 'uzone.co.id');
  ga('send', 'pageview');

</script>
</head>
<body id="home">

	<div id="controls-wrapper" class="load-item">
		<div id="controls">
			
			<!--Navigation-->
			<ul id="slide-list"></ul>
			
		</div>
	</div>
<!-- main body -->
<?php if (isset($subview))$this->load->view($subview); ?>


<!-- load page tail -->
<?php $this->load->view('components/_page_tail');?>
        
    