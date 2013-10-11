<div class="channel-top-space"></div>

<div class="container-fluid">
    <!-- if any errors -->
    <?php if(validation_errors() || $this->session->flashdata('error')){?>
    <div class="row-fluid" id="update-error">
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <?php echo validation_errors(); ?>
            <strong><?php echo $this->session->flashdata('error');?></strong>
        </div>
    </div>
    <?php }?>
    
    <form method="post" action="<?php echo site_url('wow/channel/uploaddetail');?>" enctype="multipart/form-data">
        <input type="hidden" name="filename" value="<?php echo set_value('filename', $filename) ;?>" />
        <table class="table table-striped">
            <tr>
                <td>Cover Image</td>
                <td><input type="file" name="item_thumbnail" class="span3" /></td>
            </tr>
            <tr>
                <td>Nama Video</td>
                <td><input type="text" name="item_name" value="<?php echo set_value('item_name');?>" class="span3" /></td>
            </tr><!--
            <tr>
                <td>Tipe Video</td>
                <td>
                    <select id="category_id" name="category_id" class="span3">
                        <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat->category_id; ?>"><?php echo $cat->category_title; ?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>-->
            <tr>
                <td>Deskripsi</td>
                <td><textarea name="item_description" rows="4" cols="20"><?php echo set_value('item_description'); ?></textarea></td>
            </tr>
            <tr>
                <td>Tag Line</td>
                <td><input type="text" name="tag_line" value="<?php echo set_value('tag_line');?>"  class="span3"/></td>
            </tr>
        </table>
        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
        <input type="submit" id="btnSubmit" name="btnSubmit" value="Update Movie Info" class="btn btn-primary" style="background-color:#bd362f;border-color:#bd362f;" />
        <input type="button" id="btnCancel" name="btnCancel" value="Remove Upload File" class="btn btn-primary" style="background-color:#bd362f;border-color:#bd362f;" />
    </form>
    
    
</div>
<script>
var orig_fname = "<?php echo $this->session->userdata('original_filename'); ?>";
$(document).ready(function(){
    if(orig_fname){
        $('#video-upload').hide();
        $('#video-name').show();
        showVidName();
    } else {
        $('#video-upload').show();
        $('#video-name').hide();
    }
});

function showVidName(){
    $('#vid-name').empty();
    var s = "<p>"+orig_fname+"</p>";
    $('#vid-name').append(s);
}
</script>