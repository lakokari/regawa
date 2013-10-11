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
        <?php $this->table->add_row('Title',  form_input('title', set_value('title',$data->title)));?>
        <?php $this->table->add_row('Event', form_dropdown('event_id', $list_event, $data->event_id));?>
        <?php $this->table->add_row('Banner (*.JPG 160*600)', form_upload('banner', '', 'id=banner'));?>
        <?php if ($data->image):?>
        <?php $this->table->add_row('', '<img src="'.base_url().'userfiles/wow/banner/'. $data->image.'" width="50" height="50" />');?>
        <?php endif;?>
        <?php $this->table->add_row('Image Alt',  form_input('image_alt', set_value('image_alt',$data->image_alt)));?>
        <?php $this->table->add_row('Hyperlink',  form_input('hyperlink', set_value('hyperlink',$data->hyperlink)));?>
        <?php $this->table->add_row('Start Date',  form_input('start_date', set_value('start_date',$data->start_date), 'id="startdate" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Stop Date',  form_input('stop_date', set_value('stop_date',$data->stop_date), 'id="stopdate" data-date="" data-date-format="yyyy-mm-dd"'));?>
        <?php $this->table->add_row('Text Banner',  form_input('banner_text', set_value('banner_text',$data->banner_text)));?>
        <?php //$this->table->add_row('Text Banner', form_textarea(array('name'=>'banner_text', 'value'=>set_value('banner_text', $data->banner_text), 'rows'=>6, 'cols'=>80)));?>

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
$('#startdate').datepicker();
$('#stopdate').datepicker();
    $(document).ready(function(){
        var url = window.URL || window.webkitURL;
        $("#banner").change(function(e) {
            if( this.disabled ){
                alert('Your browser does not support File upload.');
            }else{
                var chosen = this.files[0];
                var image = new Image();
                image.onload = function() {
                    //alert('Width:'+this.width +' Height:'+ this.height+' '+ Math.round(chosen.size/1024)+'KB');
                    var width = this.width;
                    var height = this.height;
                    if ((width == 160) && (height == 600)){

                    } else {
                        alert('allowed image size: 160 * 600');
                    }
                };
                image.onerror = function() {
                    alert('Not a valid file type: '+ chosen.type);
                };
                image.src = url.createObjectURL(chosen);                    
             }
        });
    });
</script>