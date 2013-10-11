<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js'); ?>"></script>

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
        <?php 
        echo form_open_multipart();?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('TV Code', form_dropdown('tvcode', $grouptvcode, $schedule->tvcode));?>
        <?php $this->table->add_row('Schedule ID',  form_input('schedule_genid', set_value('schedule_genid',$schedule->schedule_genid)));?>
        <?php $this->table->add_row('Category', form_dropdown('category', $groupcategory, $schedule->category));?>
        <?php $this->table->add_row('Date',  form_input('date', set_value('date',$schedule->date), 'class="datepicker" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Jam',  form_input('jam', set_value('jam',$schedule->jam)));?>
        <?php $this->table->add_row('Acara',  form_input('acara', set_value('acara',$schedule->acara)));?>
        <?php $this->table->add_row('Start Time',  form_input('start_time', set_value('start_time',$schedule->start_time)));?>
        <?php $this->table->add_row('End Time',  form_input('end_time', set_value('end_time',$schedule->end_time)));?>
        <?php $this->table->add_row('File Status', form_dropdown('file_status', $groupfilestatus, $schedule->file_status));?>
        <?php $this->table->add_row('TVOD Stream',  form_input('tvod_stream', set_value('tvod_stream',$schedule->tvod_stream)));?>
        <?php form_hidden('id', set_value('id', $schedule->id)); ?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/tv/schedules').'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>
<script>
$('.datepicker').datepicker();
</script>
