<!-- load page html header -->
<?php $this->load->view('cms/components/_page_head');?>

<!-- load mainmenu navigation -->
<?php $this->load->view('cms/components/_page_navigation');?>

<!-- load main content -->
<?php !$subview || $this->load->view($subview);?>

<!-- load page html footer closed -->
<?php $this->load->view('cms/components/_page_tail');?>
    