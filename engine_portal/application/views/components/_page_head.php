<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
   <meta charset="utf-8" />
   <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
		<meta name="description" content="Portal UZone yang merupakan Single eEntertainment Portal dari berbagai jenis konten, yaitu video, musik, eBook, apps Store, eRadio dan game." />        
		<meta name="keywords" content="uzone, uzone indonesia, digital, telkom, media, music, movie, useetv, apps, telkomspeedy, telkomstore, webstore, melon" />        
		<link rel="canonical" href="http://www.uzone.co.id/" />

		<meta property="og:type" content="blog" /> 
		<meta property="og:title" content="UZone – Educate, Enlight, Entertain" /> 
		<meta property="og:description" content=" Portal UZone yang merupakan Single eEntertainment Portal dari berbagai jenis konten, yaitu video, musik, eBook, apps Store, eRadio dan game." /> 
		<meta property="og:url" content="http://www.uzone.co.id/" />
		<meta property="og:site_name" content="UZone" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
   <!-- Mobile viewport optimized: h5bp.com/viewport -->
   <meta name="viewport" content="width=device-width">
<link rel="icon"  type="image/png" href="<?php echo config_item('assets_url'); ?>favicon.png">
   <title><?php if (isset($meta_title)) echo $meta_title;?></title>
	<style type="text/css">
	body {
		overflow-x:scroll;
		overflow-y:scroll;
		height:100%;
	}
	</style>
   
   <script src="<?php echo config_item('assets_url'); ?>js/jquery.min.10.js"></script>
   <?php $this->load->view('components/myjs');?>
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
    ga('create', 'UA-43134369-1', 'uzone.co.id');
    ga('send', 'pageview');
  
  </script> 
   <!-- remove or comment this line if you want to use the local fonts -->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro.css">
   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro.custom.css">
   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro-responsive.css">
   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro-icons.css">
   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro-ui-light.css">
   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/datepicker.css">
   <link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/animation-win8.css">
   <script src="<?php echo config_item('assets_url'). 'js/jwplugin.js';?>"></script>
   <?php $this->load->view('components/myjs'); ?>
   <script src="<?php echo config_item("assets_url"); ?>js/modernizr-2.6.2.min.js"></script>
   <script src="<?php echo config_item("assets_url"); ?>jwplayer/jwplayer.js"></script>
   <script type="text/javascript">jwplayer.key="6aMwqeMz0opU9trgteTwz6bLsKUOzlGvNCg64g==";</script>
	<style>
		.panorama-section img {
			height:100%;
			width:100%;
		}
		.panorama {
			background: #5a7080;
			margin-left:0;
			padding-left:75px;
			color:#fff;
		}
		.popover,.modal {
			color: rgb(51, 51, 51);
		}
		#logo {
			background: url("<?php echo config_item('assets_url'); ?>css/img/logo-beta.png") no-repeat left top transparent;
			border: 1em solid white;
			border-radius: 5px 5px 5px 5px;
			height: 43px;
			padding-left:78px;
			padding-top:35px;
		}
		#nav-bar {
			padding-top:0;
		}
		a#panorama-scroll-prev, a#panorama-scroll-next {
			color:#fff;
		}
		.metro .tile.square.image {
			margin:0;
			border:none;
			width:160px;
			height:160px;
		}
		.metro .tile.square.image img {
			max-width:160px;
			max-height:160px;
		}
		.metro .tile.wide.image {
			margin:0;
			border:none;
			width:320px;
			height:480px;
		}
		.metro .tile.wide.image img {
			max-width:320px;
			max-height:480px;
		}
		#menu-right {
			margin-top:100px;
		}
		div.leftmenu {
			position:fixed;
			z-index:9999;
			top: 50%;
			left:-165px;
		}
		div.leftmenu .dropdown-menu {
			position:relative;
			top:-100px;
		}
		div.leftmenu > a.btn {
			position:absolute;
			left:150px;
			z-index:99999;
			padding-left:30px;
                        background : #fff;
		}
		div.leftmenu .tombol{
			position:absolute;
			left:143px;
			z-index:99999;
			padding-left:22px;
			width : 50px;
			height : 20px;
		}
                
		.dropdown-menu {
			border : 0px solid white;
		}
	</style>
   <!-- Grab Google CDN's jQuery. fall back to local if necessary -->
   <script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
   <script>window.jQuery || document.write("<script src='<?php echo config_item('assets_url');?>js/jquery-1.10.0.min.js'>\x3C/script>")</script>

   <!--[if IE 7]>
   <script type="text/javascript" src="scripts/bootmetro-icons-ie7.js">
   <![endif]-->

   
</head>

<body>
    