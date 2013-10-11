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
        <?php $this->table->set_template($table_tmpl);?>
        <?php
                $options = array(
                  '1'  => 'XXI',
                  '2'    => 'Blitz',
                  '3'    => 'Other'
                );
        ?>
        <?php $this->table->add_row('Type', form_dropdown('type', $options));?>
        <?php $this->table->add_row('city', form_dropdown('city_id', $city));?>
        <?php $this->table->add_row('name',  form_input('name', set_value('name',$data->name),'class="span6"'));?>
        <?php $this->table->add_row('Address',  form_input('Address', set_value('Address',$data->Address),'class="span6"'));?>
        <?php $this->table->add_row('phone',  form_input('phone', set_value('phone',$data->phone),'class="span6"'));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>