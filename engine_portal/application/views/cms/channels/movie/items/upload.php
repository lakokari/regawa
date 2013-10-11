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
        
        <?php $this->table->add_row('Video File (*.mp4)', form_upload('item_url_mpeg'));?>
        <?php if ($item->item_url_mpeg!=''):?>
        <?php $this->table->add_row('',  $item->item_url_mpeg);?>
        <?php endif;?>
        
        <?php $this->table->add_row('Video File (*.webm)', form_upload('item_url_webm'));?>
        <?php if ($item->item_url_webm!=''):?>
        <?php $this->table->add_row('',  $item->item_url_webm);?>
        <?php endif;?>
        
        <?php $this->table->add_row('Video File (*.ogv)', form_upload('item_url_ogg'));?>
        <?php if ($item->item_url_ogg!=''):?>
        <?php $this->table->add_row('',  $item->item_url_ogg);?>
        <?php endif;?>
        
        <?php $this->table->add_row('Cover Image', form_upload('item_thumbnail'));?>
        <?php if ($item->item_thumbnail!=''):?>
        <?php $this->table->add_row('',  '<img src="'. base_url(config_item('userfiles')).'/movie/thumbnail/'.$item->item_thumbnail.'" width="40" />');?>
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