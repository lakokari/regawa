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
        <?php echo form_hidden('channel_id', $feature_item->channel_id);?>
        <?php echo form_hidden('category_id', $feature_item->category_id);?>
        <?php echo form_hidden('item_id', $feature_item->item_id);?>
        
        <?php echo form_hidden('offset', $offset);?>
        <?php echo form_hidden('limit', $limit);?>
        
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Item Name',  $feature_item->name);?>
        <?php $this->table->add_row('Item Feature Image (*.JPG, 600 x 400px)', form_upload('cover'));?>
        <?php if ($feature_item->cover):?>
        <?php $this->table->add_row('', '<img src="'.site_url('images/feature_list').'/'.$channel_name.'/'. $feature_item->cover.'" width="150" />');?>
        <?php endif;?>
        <?php 
        if ($retpage)
            $url_page = site_url('/cms/'.  my_urldecode($retpage).'/'.$feature_item->channel_id);
        else
            $url_page = site_url('/cms/items/index/'.$feature_item->channel_id.'/'.$feature_item->category_id).'/'.$offset.'/'.$limit;
        $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''. $url_page .'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>