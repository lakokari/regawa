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
        <?php $this->table->add_row('Id',  form_input('id', set_value('id',$data->id),'class="span6"'));?>
        <?php $this->table->add_row('Vod Name',  form_input('vod_name', set_value('vod_name',$data->vod_name),'class="span6"'));?>
        <?php $this->table->add_row('Vod Description',  form_input('vod_description', set_value('vod_description',$data->vod_description),'class="span6"'));?>
        <?php $this->table->add_row('Vod Actor',  form_input('vod_actor', set_value('vod_actor',$data->vod_actor),'class="span6"'));?>
        <?php $this->table->add_row('Vod Director',  form_input('vod_director', set_value('vod_director',$data->vod_director),'class="span6"'));?>
        <?php $this->table->add_row('Vod Language',  form_input('vod_language', set_value('vod_language',$data->vod_language),'class="span6"'));?>
        <?php $this->table->add_row('Vod Year',  form_input('vod_year', set_value('vod_year',$data->vod_year),'class="span6"'));?>
        <?php $this->table->add_row('Vod Stream',  form_input('vod_stream', set_value('vod_stream',$data->vod_stream),'class="span6"'));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>