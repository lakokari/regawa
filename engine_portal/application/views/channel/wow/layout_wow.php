<?php 
//test update by wicak lagi ya
//load page head
$this->load->view('channel/wow/components/page_head');
$this->load->view('channel/wow/components/panel_menu_left');
//load header
$this->load->view('channel/wow/components/header');

//load page content
if (isset($page))$this->load->view($page); 

//load panel menu left & right
 
$this->load->view('channel/wow/components/panel_menu_right'); 
 
//load page tail
$this->load->view('channel/wow/components/page_tail');
?>
