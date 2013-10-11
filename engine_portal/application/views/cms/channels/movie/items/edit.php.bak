<link rel="stylesheet" type="text/css" media="screen" ref="<?=base_url()?>assets/css/datepicker.css">
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>

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
        <?php echo form_hidden('retUrl', set_value('retUrl',$retUrl));?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Item Name',  form_input('item_name', set_value('item_name',$data->item_name),'class="span6"'));?>
        <?php $this->table->add_row('Category', form_multiselect('categories[]', $categories, explode(',', $data->categories),'class="span6"'));?>
        <?php $this->table->add_row('Subcategory', form_multiselect('subcategories[]', $subcategories, explode(',', $data->subcategories),'class="span6"'));?>
        <?php $this->table->add_row('Item Description',  form_input('item_description', set_value('item_description',$data->item_description),'class="span6"'));?>
        <?php $this->table->add_row('Publisher Name',  form_input('publisher_name', set_value('publisher_name',$data->publisher_name),'class="span6"'));?>
        <?php $this->table->add_row('Published Year',  form_input('published_year', set_value('published_year',$data->published_year),'class="span6"'));?>
		<?php $this->table->add_row('Release Date',  form_input('release_date', set_value('release_date',$data->release_date), "class='datepicker'"));?>
        <?php $this->table->add_row('Synopsis',  form_input('synopsis', set_value('synopsis',$data->synopsis),'class="span6"'));?>
        <?php $this->table->add_row('Writer',  form_input('scene_writer', set_value('scene_writer',$data->scene_writer),'class="span6"'));?>
        <?php $this->table->add_row('Director',  form_input('director', set_value('director',$data->director),'class="span6"'));?>
        <?php $this->table->add_row('Cast & Crew',  form_input('cast_crew', set_value('cast_crew',$data->cast_crew),'class="span6"'));?>
        <?php $this->table->add_row('Url Full Movie',  form_input('url_full_movie', set_value('url_full_movie',$data->url_full_movie),'class="span6"'));?>
        <?php $this->table->add_row('Coming Soon', form_dropdown('coming_soonYN', array('y'=>'Yes','n'=>'No'), $data->coming_soonYN));?>
        <?php $this->table->add_row('New Release',  form_dropdown('new_releaseYN', array('y'=>'Yes','n'=>'No'), $data->new_releaseYN));?>
        <?php $this->table->add_row('ItemTag',  form_input('tag', set_value('tag',$data->tag),'class="item-lookup"'));?>
        <?php $this->table->add_row('Paid Count',  form_input('view_paid_count', set_value('view_paid_count',$data->view_paid_count),'class="span2"'));?>
        <?php $this->table->add_row('View Count',  form_input('view_count', set_value('view_count',$data->view_count),'class="span2"'));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>085691825478
        <?php echo form_close();?>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        
        //set tag ajax lookup
    });
</script>