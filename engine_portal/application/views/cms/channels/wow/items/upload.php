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
        <?php echo form_hidden('id', set_value('id',$data->id));?>
        <?php echo form_hidden('retUrl', set_value('retUrl',$retUrl));?>
        <?php $this->table->set_template($table_tmpl);?>
        
        <?php $this->table->add_row('Item File', form_upload('item_url'));?>
        <?php if ($data->item_url!=''):?>
        <?php $this->table->add_row('',  $data->item_url);?>
        <?php endif;?>
        
        <?php $this->table->add_row('Cover Image', form_upload('item_thumbnail'));?>
        <?php if ($data->item_thumbnail!=''):?>
        <?php $this->table->add_row('',  '<img src="'. base_url(config_item('userfiles')).'/wow/thumbnail/'.$data->item_thumbnail.'" width="40" />');?>
        <?php endif;?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>