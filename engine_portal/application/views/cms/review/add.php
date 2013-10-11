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

<!-- datepicker bootstrap -->
<script src="<?php echo site_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<link href="<?php echo site_url('assets/css/datepicker.css');?>" rel="stylesheet" media="screen" />

<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open();?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Channel Name', form_dropdown('channel_name', $groupchannel, $itemreview->channel_name));?>
        <?php $this->table->add_row('Item Id', form_input('item_id', set_value('item_id', $itemreview->item_id)));?>
        <?php $this->table->add_row('Reviewer Id',  form_input('reviewer_id', set_value('reviewer_id', $itemreview->reviewer_id)));?>
        <?php $this->table->add_row('Review DateTime', form_input('review_datetime', set_value('review_datetime', $itemreview->review_datetime), 'id="datepicker" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Review Text', form_textarea(array('name'=>'review_text', 'value'=>set_value('review_text', $itemreview->review_text), 'rows'=>6, 'cols'=>80)));?>
        
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/review').'\';"'),''
              );
        ?>
        <?php form_hidden('item_id',$itemreview->item_id); ?>
        <?php //form_hidden('channel_name',$itemreview->channel_name); ?>
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>
<script>
$('#datepicker').datepicker();
</script>