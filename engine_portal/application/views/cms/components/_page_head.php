<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($cms_title)?$cms_title:'UZone CMS';?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8" /> 
        <link rel="shortcut icon" href="<?php echo config_item('assets_url').'favicon.png';?>" />
        <script src="<?php echo config_item('assets_url').'js/jquery.js'; ?>"></script>
        <link href="<?php echo config_item('assets_url').'css/bootstrap.min.css';?>" rel="stylesheet" media="screen" />
        <link href="<?php echo config_item('assets_url').'css/bootstrap-responsive.min.css';?>" rel="stylesheet" media="screen" />
        <script src="<?php echo config_item('assets_url').'js/bootstrap.min.js'; ?>"></script>
        
        <!-- override some bootstrap styles -->
        <link href="<?php echo config_item('assets_url').'css/cms.css';?>" rel="stylesheet" media="screen" />
        
        <!-- load function js helper -->
        <?php $this->load->view('cms/myjs'); ?>
    </head>
    <body style="margin-top: 40px;">