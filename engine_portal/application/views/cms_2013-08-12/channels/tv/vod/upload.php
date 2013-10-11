<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
    </div>
</section>

<!-- if any errors -->
<?php if(validation_errors() || $this->session->flashdata('error')){?>
<section id="update-error">
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo validation_errors(); ?>
        <strong><?php echo $this->session->flashdata('error');?></strong>
    </div>
</section>
<?php }?>

<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open_multipart();?>
        <?php echo form_hidden('retUrl', set_value('retUrl',$retUrl));?>
        
        <?php $this->table->set_template($table_tmpl);?>
        
        <?php $this->table->add_row('Image', form_upload('vod_image'));?>
        <?php if ($item->vod_small_image1!=''):?>
        <?php $this->table->add_row('',  '<img src="'. base_url(config_item('userfiles')).'/tv/tv_vod/'.$item->vod_small_image1.'" />');?>
        <?php endif;?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>