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
        <?php $this->table->add_row('Package Id',  form_input('package_id', set_value('package_id',$data->package_id),'class="span6"'));?>
        <?php $this->table->add_row('Package Name',  form_input('package_name', set_value('package_name',$data->package_name),'class="span6"'));?>
        <?php $this->table->add_row('Category', form_dropdown('category', $category, $data->category));?>
        <?php $this->table->add_row('Description',  form_input('description', set_value('description',$data->description),'class="span6"'));?>
        <?php $this->table->add_row('Developer or Publisher',  form_input('developer_or_publisher', set_value('developer_or_publisher',$data->developer_or_publisher),'class="span6"'));?>
        <?php $this->table->add_row('Developer or Publisher Site',  form_input('developer_or_publisher_site', set_value('developer_or_publisher_site',$data->developer_or_publisher_site),'class="span6"'));?>
        <?php $this->table->add_row('Telkomstore Link',  form_input('telkomstore_link', set_value('telkomstore_link',$data->telkomstore_link),'class="span6"'));?>
        <?php $this->table->add_row('Icon Url',  form_input('icon_url', set_value('icon_url',$data->icon_url),'class="span6"'));?>
        <?php $this->table->add_row('version',  form_input('version', set_value('version',$data->version),'class="span6"'));?>
        <?php $this->table->add_row('price',  form_input('price', set_value('price',$data->price),'class="span6"'));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>