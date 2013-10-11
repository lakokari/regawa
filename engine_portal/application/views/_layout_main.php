<!-- load page header -->
<?php $this->load->view('components/_page_head');?>

<!-- load body header -->
<?php $this->load->view('components/_header');?>

<!-- main body -->
<?php if (isset($subview))$this->load->view($subview); ?>

<!-- load footer -->
<?php $this->load->view('components/_footer');?>

<!-- load page tail -->
<?php $this->load->view('components/_page_tail');?>
        
    