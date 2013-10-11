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
        <?php $this->table->add_row('Fullname',  form_input('sure_name', set_value('sure_name',$data->sure_name)));?>
        <?php $this->table->add_row('Occupation',  form_input('occupation', set_value('occupation', $data->occupation)));?>
        <?php $this->table->add_row('Facebook',  form_input('facebook_id', set_value('facebook_id', $data->facebook_id)));?>
        <?php $this->table->add_row('Twitter',  form_input('tweeter_id', set_value('tweeter_id', $data->tweeter_id)));?>
        <?php $this->table->add_row('Age',  form_input('age', set_value('age', $data->age)));?>
        <?php $this->table->add_row('Creation', form_textarea(array('name'=>'creation', 'value'=>set_value('content', $data->creation), 'rows'=>6, 'cols'=>80)));?>
        <?php $this->table->add_row('Motto', form_textarea(array('name'=>'motto', 'value'=>set_value('content', $data->motto), 'rows'=>6, 'cols'=>80)));?>
        <?php $this->table->add_row('Description', form_textarea(array('name'=>'description', 'value'=>set_value('content', $data->description), 'rows'=>6, 'cols'=>80)));?>

        <!-- avatar preview -->
        <?php $this->table->add_row('Avatar (*.JPG)', form_upload('avatar'));?>
        <?php if ($data->avatar):?>
        <?php $this->table->add_row('', '<img src="'.base_url().'userfiles/users/juri/avatar/'. $data->avatar.'" width="50" height="50" />');?>
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