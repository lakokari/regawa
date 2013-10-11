<!DOCTYPE html>
<html lang="en">
<head>
<title>UZone - WoW Competition</title>
<script src="<?php echo config_item('assets_url'); ?>js/jquery.min.10.js"></script>
<script src="<?php echo config_item('assets_url'). 'js/jquery.form.min.js'; ?>"></script>
<?php 
$this->load->view('components/myjs');
//load themes page
echo '<link href="'.config_item('assets_wow').'css/wall-themes-'.$themes.'.css" rel="stylesheet" type="text/css" />';
?>
<link href="<?php echo config_item('assets_wow'); ?>css/layout-black.css" rel="stylesheet" type="text/css" />
<link href="<?php echo config_item('assets_wow'); ?>css/layout.custom.css" rel="stylesheet" type="text/css" />

<link href="<?php echo config_item('assets_wow'); ?>css/cool_menu.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro-icons.css" />
</head>
<body>