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
        <?php $this->table->add_row('Category Name', form_dropdown('category_id', $groupcat, $genradio->category_id));?>
        <?php $this->table->add_row('Genre Name', form_input('genre_name', set_value('genre_name',$genradio->genre_name)));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/radio/genres').'\';"'),''
              );
        ?>
        <?php form_hidden('id',$genradio->id); ?>
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>
