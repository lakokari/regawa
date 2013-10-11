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

<!-- datepicker bootstrap -->
<script src="<?php echo config_item('assets_url').'js/bootstrap-datepicker.js'; ?>"></script>
<link href="<?php echo config_item('assets_url').'css/datepicker.css';?>" rel="stylesheet" media="screen" />

<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open_multipart();?>
        <?php echo form_hidden('retUrl', set_value('retUrl',$retUrl));?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Category', form_dropdown('category_id', $options, $data->category_id));?>
        <?php $this->table->add_row('Event Name',  form_input('name', set_value('name',$data->name)));?>
        <?php $this->table->add_row('Slug',  form_input('slug', set_value('slug',$data->slug)));?>
        <?php
            $startdate = explode(" ", $data->start_date);
            $stopdate = explode(" ", $data->stop_date);
        ?>
        <?php $this->table->add_row('Start Date',  form_input('start_date', set_value('start_date',$startdate[0]), 'id="startdate" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Stop Date',  form_input('stop_date', set_value('stop_date',$stopdate[0]), 'id="stopdate" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Allowed File Type',  form_input('allowed_movie_type', set_value('allowed_movie_type',$data->allowed_movie_type)));?>
        <?php $this->table->add_row('Max File Size (MB)',  form_input('max_movie_size', set_value('max_movie_size',$data->max_movie_size)));?>
        <!-- image_small -->
        <?php $this->table->add_row('Image Small (*.JPG)', form_upload('image_small'));?>
        <?php if ($data->image_small):?>
        <?php $this->table->add_row('', '<img src="'.config_item('userfiles').'wow/event/'. $data->image_small.'" width="50" height="50" />');?>
        <?php endif;?>
        <!-- image_big -->
        <?php $this->table->add_row('Image Big (*.JPG)', form_upload('image_big'));?>
        <?php if ($data->image_big):?>
        <?php $this->table->add_row('', '<img src="'.config_item('userfiles').'wow/event/'. $data->image_big.'" width="50" height="50" />');?>
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
<script>
$('#startdate').datepicker();
$('#stopdate').datepicker();
</script>