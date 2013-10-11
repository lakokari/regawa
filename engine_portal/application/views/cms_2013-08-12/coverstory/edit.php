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
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Name', form_input('name',  set_value('name', $cs_row->name)));?>
        <?php $this->table->add_row('Title', form_input('title',  set_value('title', $cs_row->title)));?>
        <?php $this->table->add_row('Sort Order', form_input('sort',  set_value('sort', $cs_row->sort)));?>
        <?php $this->table->add_row('Visible', form_dropdown('showed',  array(0=>'No',1=>'Yes'),array($cs_row->showed)));?>
        <?php $this->table->add_row('Target Url', form_input('target_url',  set_value('target_url', $cs_row->target_url)));?>
        <?php $this->table->add_row('Cover Image (*.jpg)', form_upload('image_url'));?>
        <?php if ($cs_row->image_url):?>
        <?php $this->table->add_row('', '<img src="'.  base_url('images/cover_story/'.$cs_row->image_url).'" width="60" />');?>
        <?php endif;?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.history.back();"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>