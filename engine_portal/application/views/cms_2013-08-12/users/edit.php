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
        <?php $this->table->add_row('Group', form_dropdown('group_id', $groups, $data->group_id));?>
        <?php $this->table->add_row('Username',  form_input('u_name', set_value('u_name',$data->u_name)));?>
        <?php $this->table->add_row('Set Active',  form_dropdown('is_activeYN', array('y'=>'Yes','n'=>'No'),array($data->is_activeYN)));?>
        <?php $userid || $this->table->add_row('Password', form_password('u_password'));?>
        <?php $userid || $this->table->add_row('Password Confirmation', form_password('u_password_conf'));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel', 'Cancel','class="btn btn-primary" onclick="window.history.back();"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>