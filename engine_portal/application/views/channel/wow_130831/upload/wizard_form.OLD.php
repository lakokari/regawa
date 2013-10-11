<style type="text/css">
    .progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
    .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
</style>

<script src="<?php echo base_url('assets/js/jquery.form.min.js'); ?>"></script>
<div class="container">
    <form id="frm_wow" name="frm_wow" method="post" enctype="multipart/form-data">
        <table class="table table-striped">
            <tr>
                <td>Judul</td>
                <td><input type="text" class="span9" name="judul" /></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td><input type="text" class="span9" name="kategori" /></td>
            </tr>
            <tr>
                <td>Tags</td>
                <td><input type="text" class="span9" name="tags" /></td>
            </tr>
            <tr>
                <td>Team</td>
                <td><input type="text" class="span9" name="team" /></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td><textarea class="span9" name="deskripsi"></textarea></td>
            </tr>
            <tr>
                <td>Pilih File Upload (.mp4)</td>
                <td><input type="file" name="video" /></td>
            </tr>
            <tr>
                <td>Pilih Thumbnail (.jpg)</td>
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
    </div>
</div>

<script>
    var wow_event_id = '<?php echo $wow_event_id; ?>';
    $(document).ready(function(){
        var bar = $('.bar');
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
        
        return true; 
    }
    
</script>