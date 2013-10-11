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
<!-- if any errors -->
<?php }?>

<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open();?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Radio Name', form_input('radio_name', set_value('radio_name',$radio->radio_name)));?>
        <?php $this->table->add_row('Radio City', form_input('radio_city', set_value('radio_city',$radio->radio_city)));?>
        <?php $this->table->add_row('Radio Province', form_input('radio_province', set_value('radio_province',$radio->radio_province)));?>
        <?php $this->table->add_row('Radio Site', form_input('radio_site', set_value('radio_site',$radio->radio_site)));?>
        <?php $this->table->add_row('Live Stream', form_input('live_stream', set_value('live_stream',$radio->live_stream)));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/radio/items').'\';"'),''
              );
        ?>
        <?php form_hidden('id',$radio->id); ?>
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>
