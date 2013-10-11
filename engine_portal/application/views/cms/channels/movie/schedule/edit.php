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
        <?php $this->table->set_template($table_tmpl);?>
        <?php $js = 'id="city_id"'; ?>
        <?php $this->table->add_row('Select City',  form_dropdown('city_id', $options, 0, $js));?>
         <?php $this->table->add_row('Select Theater','<select name="theater_id" id="theater_id">
                                                    <option value="">Select Theater</option>
                                    </select>');
         ?>
         <?php $js1 = 'id="categories"'; ?>
        <?php $this->table->add_row('Select Movie Category',  form_dropdown('categories', $options1, 0, $js1));?>
         <?php $this->table->add_row('Movie Title','<select name="item_id" id="item_id">
                                                    <option value="">Select Movie</option>
                                    </select>');
         ?>
         <?php $this->table->add_row('Schedule Date',  form_input('schedule_date', set_value('schedule_date',$data->schedule_date),'class="span6"'));?>
         <?php $this->table->add_row('Schedule Time',  form_input('schedule_time', set_value('schedule_time',$data->schedule_time),'class="span6"'));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('btn_cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  $retUrl.'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>

<script>
    $(document).ready(function(){

        $("#city_id").change(function(){
            var city_id = $("#city_id").val();
            $.ajax({
               type : "POST",
               url  : "<?php echo base_url(); ?>cms/movie/schedule_get_theater",
               data : "city_id=" + city_id,
               success: function(data){
                   $("#theater_id").html(data);
               }
            });
        });

        $("#categories").change(function(){
            var categories = $("#categories").val();
            $.ajax({
               type : "POST",
               url  : "<?php echo base_url(); ?>cms/movie/schedule_get_movie",
               data : "categories=" + categories,
               success: function(data){
                   $("#item_id").html(data);
               }
            });
        });

    });

</script>