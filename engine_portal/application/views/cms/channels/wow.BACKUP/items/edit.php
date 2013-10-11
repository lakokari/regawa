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
        <?php $this->table->add_row('Item Name',  form_input('item_name', set_value('item_name',$data->item_name)));?>
        <?php $this->table->add_row('Category', form_dropdown('category_id', $categories, $data->category_id));?>
        <?php $this->table->add_row('Item Description',  form_input('item_description', set_value('item_description',$data->item_description)));?>
        <?php $this->table->add_row('Approved', form_dropdown('approved', array(0=>'No',1=>'Yes'), array($data->approved)));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>