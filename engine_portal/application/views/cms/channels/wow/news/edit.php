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
        <?php $this->table->add_row('Event', form_dropdown('item_id', $list_event, $data->item_id));?>
        <?php $this->table->add_row('News Title',  form_input('news_title', set_value('news_title',$data->news_title)));?>
        <?php
            $newsdatetime = explode(" ", $data->news_datetime);
        ?>
        <?php $this->table->add_row('News Date',  form_input('news_datetime', set_value('news_datetime',$newsdatetime[0]), 'id="newsdatetime" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('News Text', form_textarea(array('name'=>'news_text', 'value'=>set_value('news_text', $data->news_text), 'rows'=>6, 'cols'=>80)));?>
        <?php $this->table->add_row('Type', form_dropdown('type', $list_type, $data->type));?>
        <?php $this->table->add_row('Image (*.JPG)', form_upload('image'));?>
        <?php if ($data->img_path):?>
        <?php $this->table->add_row('', '<img src="'.config_item('userfiles').'wow/news/'. $data->img_path.'" width="50" height="50" />');?>
        <?php endif;?>
        <?php $this->table->add_row('Video (*.MP4)', form_upload('video'));?>
        <?php if ($data->video_path):?>
        <?php $this->table->add_row('', '<img src="'.config_item('userfiles').'wow/news/'. $data->video_path.'" width="50" height="50" />');?>
        <?php endif;?>
        <?php echo form_hidden('is_active', set_value('is_active',$data->is_active));?>
        
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
$('#newsdatetime').datepicker();
</script>