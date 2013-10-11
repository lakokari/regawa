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
        <?php $this->table->add_row('Code',  form_input('code', set_value('code',$data->code),'class="span6"'));?>
        <?php $this->table->add_row('Name',  form_input('name', set_value('name',$data->name),'class="span6"'));?>
        <?php $this->table->add_row('Description',  form_input('description', set_value('description',$data->description),'class="span6"'));?>
        <?php $this->table->add_row('Actor',  form_input('actor', set_value('actor',$data->actor),'class="span6"'));?>
        <?php $this->table->add_row('Director',  form_input('director', set_value('director',$data->director),'class="span6"'));?>
        <?php $this->table->add_row('Language',  form_input('language', set_value('language',$data->language),'class="span6"'));?>
        <?php $this->table->add_row('Package Code',  form_input('package_code', set_value('package_code',$data->package_code),'class="span6"'));?>
        <?php $this->table->add_row('Content Type',  form_input('content_type', set_value('content_type',$data->content_type),'class="span6"'));?>
        <?php $this->table->add_row('Year',  form_input('year', set_value('year',$data->year),'class="span6"'));?>
        <?php $this->table->add_row('Length',  form_input('length', set_value('length',$data->length),'class="span6"'));?>
        <?php $this->table->add_row('Can Download',  form_input('can_download', set_value('can_download',$data->can_download),'class="span6"'));?>
        <?php $this->table->add_row('Can Play Online',  form_input('can_onlineplay', set_value('can_onlineplay',$data->can_onlineplay),'class="span6"'));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>