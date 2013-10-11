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
        <?php $this->table->add_row('Category Name',  form_input('category_name', set_value('category_name',$data->category_name)));?>
        <?php $this->table->add_row('Category Title',  form_input('category_title', set_value('category_title', $data->category_title)));?>
        <?php $this->table->add_row('Synopsis Category', form_textarea(array('name'=>'synopsis_category', 'value'=>set_value('content', $data->synopsis_category), 'rows'=>6, 'cols'=>80)));?>
        <?php $this->table->add_row('Content Preview', form_textarea(array('name'=>'content_preview', 'value'=>set_value('content', $data->content_preview), 'rows'=>6, 'cols'=>80)));?>
        <!-- icon-preview -->
        <?php $this->table->add_row('Icon Preview (*.JPG)', form_upload('icon'));?>
        <?php if ($data->icon_preview):?>
        <?php $this->table->add_row('', '<img src="'.config_item('userfiles').'wow/category/'. $data->icon_preview.'" width="50" height="50" />');?>
        <?php endif;?>
        <!-- image preview -->
        <?php $this->table->add_row('Image Preview (*.JPG)', form_upload('image'));?>
        <?php if ($data->image_preview):?>
        <?php $this->table->add_row('', '<img src="'.config_item('userfiles').'wow/category/'. $data->image_preview.'" width="50" height="50" />');?>
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