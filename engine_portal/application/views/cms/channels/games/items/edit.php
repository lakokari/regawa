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
        <!--<strong><?php echo $this->session->flashdata('error');?></strong>-->
    </div>
</section>
<!-- if any errors -->
<?php }?>

<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open();?>
        <?php $this->table->set_template($table_tmpl);?>
        
        <?php $this->table->add_row('Game Name', form_input('title', set_value('title',$games->title)));?>
        <?php $this->table->add_row('Description', form_input('description', set_value('description',$games->description)));?>
        <?php $this->table->add_row('Width', form_input('width', set_value('width',$games->width)));?>
        <?php $this->table->add_row('Height', form_input('height', set_value('height',$games->height)));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/games/items').'\';"'),''
              );
        ?>
        <?php $this->table->add_row(form_hidden('autoId',$games->autoId)); ?>
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>
