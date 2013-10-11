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
        <?php echo form_hidden('retUrl', set_value('retUrl',$retUrl));?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php
                $options = array(
                  '1'  => 'Pc',
                  '2'    => 'Mobile'
                );
        ?>
        <?php $this->table->add_row('Parent Id', form_dropdown('parent_id', $options));?>
        <?php $this->table->add_row('Category Name',  form_input('category_name', set_value('category_name',$data->category_name)));?>
        <?php $this->table->add_row('Icon Url',  form_input('icon_url', set_value('icon_url', $data->icon_url)));?>
        <?php $this->table->add_row('Categori Id',  form_input('category_id', set_value('category_id', $data->category_id)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>