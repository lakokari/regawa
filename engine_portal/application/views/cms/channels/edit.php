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
        <?php $this->table->add_row('Channel Name',  form_input('name', set_value('name',$channel->name)));?>
        <?php $this->table->add_row('Channel Title',  form_input('title', set_value('title',$channel->title)));?>
        <?php $this->table->add_row('Channel Description',  form_input('description', set_value('description',$channel->description)));?>
        <?php $this->table->add_row('Channel Order',  form_input('sort', set_value('sort',$channel->sort)));?>
        <?php 
              $radio_yes = array(
                    'name'        => 'showed',
                    'id'          => 'showed',
                    'value'       => 1,
                    'checked'     => ($channel->showed==1)
              );
              $radio_no = array(
                    'name'        => 'showed',
                    'id'          => 'showed',
                    'value'       => 0,
                    'checked'     => ($channel->showed==0)
              );
              $this->table->add_row(
                      'Channel Showed',  
                      form_radio($radio_yes).' Yes '. form_radio($radio_no).' No '
              );
        ?>
        <?php $this->table->add_row('Has Featured', form_dropdown('hasFeatured', array('y'=>'Yes','n'=>'N') ,$channel->hasFeatured));?>
        <?php $this->table->add_row('Channel Cover Image (*.JPG, 203 x 188px)', form_upload('cover',  set_value('cover')));?>
        <?php if ($channel->cover):?>
        <?php $this->table->add_row('', '<img src="'.site_url(config_item('channel_img_url')).'/thumbs/'. $channel->cover.'" width="50" height="50" />');?>
        <?php endif;?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/channels').'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>