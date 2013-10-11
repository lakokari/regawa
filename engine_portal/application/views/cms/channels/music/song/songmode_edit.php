<link rel="stylesheet" type="text/css" media="screen"
     href="<?php echo config_item('assets_url'); ?>css/datepicker.css">


    <script type="text/javascript"
     src="<?php echo config_item('assets_url'); ?>js/bootstrap-datepicker.js"></script>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
        <?php echo form_open_multipart();?>
        <?php $this->table->set_template($table_tmpl);?>
		<?php $this->table->add_row('Song ID',  form_input('songId', set_value('songId',$channel->songId),'id="songId"'));?>
		<?php $this->table->add_row('PlayTime',  form_input('playtime', set_value('playtime',$channel->playtime)));?>
		<?php $this->table->add_row('bitRateCd',  form_input('bitRateCd', set_value('bitRateCd',$channel->bitRateCd)));?>
		<?php $this->table->add_row('contentId',  form_input('contentId', set_value('contentId',$channel->contentId)));?>
		<?php $this->table->add_row('sampling',  form_input('sampling', set_value('sampling',$channel->sampling)));?>
		<?php $this->table->add_row('codecTypeCd',  form_input('codecTypeCd', set_value('codecTypeCd',$channel->codecTypeCd)));?>
		<?php $this->table->add_row('fileSize',  form_input('fileSize', set_value('fileSize',$channel->fileSize)));?>
		<?php $this->table->add_row('originalFileName',  form_input('originalFileName', set_value('originalFileName',$channel->originalFileName)));?>
		<?php $this->table->add_row('fullFilePath',  form_input('fullFilePath', set_value('fullFilePath',$channel->fullFilePath)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/music/songmode').'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		}).on('changeDate', function(ev) {
			$(this).val($(this).val().replace(/-/g,''));
		});

		$('#songId').autocomplete({
			source: "<?php echo base_url('cms/music/getsongid')?>"
		});
    });



	
</script>