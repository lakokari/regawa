<?php 
//load page head
$this->load->view('channel/wow/components/page_head_black');

//load panel menu left
$this->load->view('channel/wow/components/panel_menu_left');

//load header
$this->load->view('channel/wow/components/header_black');

//load page content
if (isset($page))$this->load->view($page); 

//load panel menu right
$this->load->view('channel/wow/components/panel_menu_right'); 
 
//load page tail
$this->load->view('channel/wow/components/page_tail');
?>
