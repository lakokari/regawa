
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
        <?php $this->table->add_row('Category ID',  form_dropdown('category_id', $items, $channel->id_category));?>
		<?php $this->table->add_row('TV Name',  form_input('tv_name', set_value('tv_name',$channel->tv_name)));?>
		<?php $this->table->add_row('TV code',  form_input('tv_code', set_value('tv_code',$channel->tv_code)));?>
		<?php $this->table->add_row('TV Description',  form_textarea('tv_description', set_value('tv_description',$channel->tv_description)));?>
		<?php $this->table->add_row('small_logo1',  form_input('small_logo1', set_value('small_logo1',$channel->small_logo1)));?>
		<?php $this->table->add_row('small_logo2',  form_input('small_logo2', set_value('small_logo2',$channel->small_logo2)));?>
		<?php $this->table->add_row('big_logo1',  form_input('big_logo1', set_value('big_logo1',$channel->big_logo1)));?>
		<?php $this->table->add_row('big_logo2',  form_input('big_logo2', set_value('big_logo2',$channel->big_logo2)));?>
		<?php $this->table->add_row('Live Stream',  form_input('live_stream', set_value('live_stream',$channel->live_stream)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/tv').'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>

