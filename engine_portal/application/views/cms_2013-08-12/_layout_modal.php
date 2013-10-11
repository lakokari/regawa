<!-- load page header -->
<?php $this->load->view('components/_page_head'); ?>

<!-- load main navigation -->
<?php $this->load->view('components/_header'); ?>
<div class="modal show" role="dialog" style="border-radius:10px; margin-right:360px; margin-left:-340px; margin-top:-295px;">
    <?php $this->load->view($subview);?>

    <div class="modal-footer">
        &copy; <?php echo date('Y'); ?>&nbsp;&nbsp;&nbsp; <?php echo $site_title; ?>

    </div>
</div>
<!-- load footer -->
<?php $this->load->view('components/_footer'); ?>
<!-- page tail -->
<?php $this->load->view('components/_page_tail'); ?>