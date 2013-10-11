<!DOCTYPE html>
<html lang="en">
<head>
<title>UZone - WoW Competition</title>
<script src="<?php echo config_item('assets_url'); ?>js/jquery.min.10.js"></script>
<?php $this->load->view('components/myjs');?>

<link href="<?php echo config_item('assets_wow'); ?>css/layout.css" rel="stylesheet" type="text/css" />

<!-- custom scrollbar like Mac -->
<link href="<?php echo config_item('assets_wow'); ?>antiscroll/antiscroll.css" rel="stylesheet" />
<script src="<?php echo config_item('assets_wow'); ?>antiscroll/deps/jquery.js"></script>
<script src="<?php echo config_item('assets_wow'); ?>antiscroll/deps/jquery-mousewheel.js"></script>
<script src="<?php echo config_item('assets_wow'); ?>antiscroll/antiscroll.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43134369-1', 'uzone.co.id');
  ga('send', 'pageview');

</script>

</head>
<body>