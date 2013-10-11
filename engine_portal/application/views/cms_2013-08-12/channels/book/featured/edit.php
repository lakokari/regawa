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
        <?php $this->table->add_row('Book Name', form_input('name', set_value('name',$featured->name)));?>
        <?php $this->table->add_row('Book Author', form_input('author', set_value('author',$featured->author)));?>
        <?php $this->table->add_row('Amount Chaged', form_input('amount_charged', set_value('amount_charged',$featured->amount_charged)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/book/items').'\';"'),''
              );
        ?>
        <?php form_hidden('id',$featured->id); ?>
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>
