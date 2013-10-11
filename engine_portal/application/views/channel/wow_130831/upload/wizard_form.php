<style type="text/css">
    .progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
    .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
    .progress-text { position:absolute; display:inline-block; top:3px; left:48%; }
    input, textarea {
        background: #f2f2f2;
        border : 1px solid #e3e3e3;
    }
    input[type="text"],input[type="submit"],input[type="reset"]{padding:10px;}
    input[type="submit"] {
        border: 0;
        background: url('<?php echo base_url();?>assets/wow/images/button_submit.png') no-repeat center center;
        text-indent: -9999em;
        width: 70px;
        height: 25px;
    }
    
    input[type="submit"]:hover {
        border: 0;
        background: url('<?php echo base_url();?>assets/wow/images/button_submit_hover.png') no-repeat center center;
        text-indent: -9999em;
        width: 70px;
        height: 25px;
    }
    input[type="reset"] {
        border: 0;
        background: url('<?php echo base_url();?>assets/wow/images/button_reset.png') no-repeat center center;
        text-indent: -9999em;
        width: 70px;
        height: 25px;
    }
    input[type="reset"]:hover {
        border: 0;
        background: url('<?php echo base_url();?>assets/wow/images/button_reset_hover.png') no-repeat center center;
        text-indent: -9999em;
        width: 70px;
        height: 25px;
    }
</style>

<script src="<?php echo base_url('assets/js/jquery.form.min.js'); ?>"></script>
<div class="container">
    <form id="frm_wow" name="frm_wow" method="post" enctype="multipart/form-data">
        <table class="table table-striped">
            <tr>
                <td><b>Judul</b></td>
                <td><input type="text" class="span9" name="judul" style="min-width: 350px;" placeholder="Video Wow"/></td>
            </tr>
            <tr>
                <td><b>Kategori</b></td>
                <td><input type="text" class="span9" name="kategori" style="min-width: 200px;" value="<?php echo $wow_event_name; ?>" /></td>
            </tr>
            <tr>
                <td><b>Genre</b></td>
                <!--<td><input type="text" class="span9" name="genre" style="min-width: 200px;" /></td>-->
                <td>
                    <select id="select-genre" name="genre">
                        <?php foreach($genres as $genre): ?>
                            <option value="<?php echo $genre->id; ?>"><?php echo $genre->name; ?>     
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Tags</b></td>
                <td><input type="text" class="span9" name="tags" style="min-width: 200px;" placeholder="wow" /></td>
            </tr>
            <tr>
                <td><b>Team</b></td>
                <td><input type="text" class="span9" name="team" style="min-width: 350px;" placeholder="Bagus-Sutradara, Marwan-Produser" /></td>
            </tr>
            <tr>
                <td><b>Deskripsi</b></td>
                <td><textarea class="span9" name="deskripsi" rows="5" cols="80" placeholder="video ini tentang channel wow"></textarea></td>
            </tr>
            <tr>
                <td><b>Pilih File Upload (.mp4)</b></td>
                <td><input type="file" name="video" /></td>
            </tr>
            <tr>
                <td><b>Pilih Thumbnail (.jpg)</b></td>
                <td><input type="file" name="thumbnail" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="SUBMIT DATA" />
                    <input type="reset" value="RESET" />
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="container">
    <div class="progress">
        <div class="bar"></div>
        <div class="progress-text"></div>
    </div>
</div>

<script>
    var wow_event_id = "<?php echo $wow_event_id; ?>";
    $(document).ready(function(){
        //loadGenre();
        var bar = $('.bar');
        var progressText= $('.progress-text');
        var options = { 
            beforeSubmit:  showRequest,  

            // other available options: 
            url:       '<?php echo site_url('ajax/wow');?>',
            type:      'post', 
            dataType:  'json',
            data: {
                func: 'saveWowForm',
                channel: wow_event_id
            },
            beforeSend: function() {
                //if (bar.css('display')=='none') bar.show();
                var percentVal = '0%';
                bar.width(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
                progressText.html('Uploading...');
            },
            success: function(data) {
                var percentVal = '100%';
                bar.width(percentVal);
                
                if (data['success']==false)
                    alert(data['message']);
                else{
                    //load finish page
                    $('div#upload-wizard').load('<?php echo site_url('wow/upload/wizard_loadfinish'); ?>/'+wow_event_id, function(){
                        $('h1#wow-wizard-title').html('Selesai');
                    });
                }
            }
        }; 

        // bind form using 'ajaxForm' 
        $('#frm_wow').ajaxForm(options); 
    });
    
    function showRequest(formData, jqForm, options){
        var form = jqForm[0];
        
        if (form.judul.value==''){
            alert('Judul tidak boleh kosong');
            return false;
        }
        if (form.kategori.value==''){
            alert('Kategori tidak boleh kosong');
            return false;
        }/*
        if (form.genre.value==''){
            alert('Genre tidak boleh kosong');
            return false;
        }*/
        if (form.tags.value==''){
            alert('Tags tidak boleh kosong');
            return false;
        }
        if (form.team.value==''){
            alert('Judul tidak boleh kosong');
            return false;
        }
        if (form.deskripsi.value==''){
            alert('Deskripsi tidak boleh kosong');
            return false;
        }
        var filename = form.video.value;
        var allowed_type = ['mp4','ogv','webm'];
        if (filename==''){
            alert('Belum memilih file video');
            return false;
        } else {
            var ftype = filename.split('.');
            var extension = ftype[ftype.length-1];
            if (allowed_type.indexOf(extension.toLowerCase())<0){
                setTimeout(function(){alert('Format '+ftype[ftype.length-1]+' tidak diperbolehkan.')}, 100);
                return false;
            }
        }

        var thumbname = form.thumbnail.value;
        var allowed_type_thumb = ['jpg'];
        if (thumbname!=''){
            var ftype = thumbname.split('.');
            var extension = ftype[ftype.length-1];
            if (allowed_type_thumb.indexOf(extension.toLowerCase())<0){
                setTimeout(function(){alert('Format '+ftype[ftype.length-1]+' tidak diperbolehkan.')}, 100);
                return false;
            }
        } else {
            alert('Belum memilih file thumbnail');
            return false;
        }
  
        return true; 
    }
    
</script>