<link rel="stylesheet" type="text/css" media="screen"
     href="<?php echo config_item('assets_url'); ?>css/datepicker.css">


    <script type="text/javascript"
     src="<?php echo config_item('assets_url'); ?>js/bootstrap-datepicker.js">
    </script>
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
		$hidden = array('channel_name' => $this->uri->segment(4));
		echo form_open_multipart('','',$hidden);?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Item Id',  form_dropdown('item_id', $items, $channel->item_id));?>
        <?php $this->table->add_row('News Title',  form_input('news_title', set_value('news_title',$channel->news_title)));?>
		
		<?php $this->table->add_row('News Datetime', form_input('news_datetime', set_value('name',$channel->news_datetime),'class="datepicker"'));?>
		<?php $this->table->add_row('News Text',  form_textarea('news_text', set_value('news_text',$channel->news_text)));?>
		<?php $this->table->add_row('News By',  form_input('news_by', set_value('news_by',$channel->news_by)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/news/index/'.$channel->channel_name).'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>


<script type="text/javascript">
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	});
    </script>