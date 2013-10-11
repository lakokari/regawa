<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>UZone - WoW Competition</title>

       
<script src="<?php echo config_item('assets_url'); ?>js/jquery.min.10.js"></script>
<script src="<?php echo config_item('assets_url'). 'js/jquery.form.min.js'; ?>"></script>

<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro.css" />
<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro.custom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro-icons.css" />
<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro-ui-light.css" />

<!-- bootsrap file upload -->
<!-- di comment oleh robert 31 agustus 2013
<script src="<?php echo config_item('assets_url'); ?>js/bootstrap-fileupload.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/bootstrap-fileupload.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>css/jquery.fileupload-ui.css">

<script src="<?php echo config_item('assets_url'); ?>js/jquery.js"></script>
-->

<link href="<?php echo config_item('assets_wow'); ?>style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo config_item('assets_wow'); ?>custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>js/popup/jquery.bpopup.min.js"></script>
<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>js/jquery.tinycarousel.js"></script>
<script type="text/javascript" src="<?php echo config_item('assets_wow'); ?>js/website.js"></script>

<script type="text/javascript">         
    $(document).ready(function(){               
        
        $('#slider-code').tinycarousel({ pager: true });
        
        //create_sfEls_Hover();
    });
    
    function create_sfEls_Hover(){
        var sfEls = document.getElementById("navbar").getElementsByTagName("li");
        for (var i=0; i<sfEls.length; i++) {
            sfEls[i].onmouseover=function() {
                this.className+=" hover";
            }
            
            sfEls[i].onmouseout=function() {
                this.className=this.className.replace(new RegExp(" hover\\b"), "");
            }
        }
    }
</script>
</head>
<body>