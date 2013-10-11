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
        <?php echo form_open();?>
        <?php echo form_hidden('id', $roleuser->id);?>
        <?php echo form_hidden('role', $roleuser->role);?>
        <?php echo form_hidden('group_id', $roleuser->group_id);?>
        <?php if ($this->user_m->super_id()==$roleuser->group_id):?>
        <legend>Change role does not affect Group Super Admin</legend>
        <?php endif;?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Group Name', $group->group);?>
        <?php $this->table->add_row('Role Name', $role->role);?>
        <?php $this->table->add_row('Enabled', form_dropdown('enabled',array(1=>'Yes',0=>'No'),array($roleuser->enabled)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel', 'Cancel','class="btn btn-primary" onclick="window.history.back();"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>