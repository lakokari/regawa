
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
        <?php 
		echo form_open_multipart();?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Stream Type', form_dropdown('streamtype', $options, $streams->streamtype));?>
		<?php $this->table->add_row('TV Code', form_dropdown('tvcode', $grouptvcode, $streams->tvcode));?>
        <?php $this->table->add_row('URL Streaming',  form_input('url_streaming', set_value('url_streaming',$streams->url_streaming)));?>
        <?php form_hidden('id', set_value('id',$streams->id));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/tv/streams').'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>

