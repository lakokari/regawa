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

<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open();?>
        <?php $this->table->set_template($table_tmpl);?>
        <?php $this->table->add_row('Content ID Token', form_input('content_id_token', set_value('content_id_token',$bookitem->content_id_token)));?>
        <?php $this->table->add_row('Book Name', form_input('name', set_value('name',$bookitem->name)));?>
        <?php $this->table->add_row('Book Author', form_input('author', set_value('author',$bookitem->author)));?>
        <?php $this->table->add_row('Category', form_dropdown('category_id', $groupcat, $bookitem->category_id));?>
        <?php $this->table->add_row('Publisher Name', form_input('sub_publisher_name', set_value('sub_publisher_name',$bookitem->sub_publisher_name)));?>
        <?php $this->table->add_row('Publish Date', form_input('publish_date', set_value('publish_date',$bookitem->publish_date), 'id="datepicker" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Book ISBN', form_input('isbn', set_value('isbn',$bookitem->isbn)));?>
        <?php $this->table->add_row('Book Price', form_input('price', set_value('price',$bookitem->price)));?>
        <?php $this->table->add_row('Book Description', form_textarea(array('name'=>'description', 'value'=>set_value('description',$bookitem->description), 'rows'=>6, 'cols'=>80)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/book/items').'\';"'),''
              );
        ?>
        <?php form_hidden('auto_id',$bookitem->auto_id); ?>
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>

<script>
$('#datepicker').datepicker();
</script>
