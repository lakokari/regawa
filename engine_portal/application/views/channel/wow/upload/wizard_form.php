<style type="text/css">
    .progress { position:relative; width:95%;  height:20px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
    .bar-progress { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
    .progress-text { position:absolute; display:inline-block; top:3px; left:48%; }
    input, textarea {
        background: #f2f2f2;
        border : 1px solid #e3e3e3;
    }
    input[type="text"],input[type="submit"],input[type="reset"]{padding:2px;}
    
	
	input[type="button"],input[type="reset"],input[type="submit"] {
        border : 0px;
        border-radius : 5px;
        background: #d31821;
        color : #fff;
        width: 70px;
        height: 22px;
        font-size: 11px;
        font-weight: bold;
        text-transform : uppercase;
    }
    input[type="button"]:hover, input[type="reset"]:hover ,input[type="submit"]:hover {
        border : 0px;
        border-radius : 5px;
        background: #EB2B34;
        color : #fff;
        width: 70px;
        height: 22px;
        font-size: 11px;
        font-weight: bold;
        text-transform : uppercase;
    }
    
		
	input[type=file] {
		width: auto;
		height: 32px;
		min-width: 100px;
		min-height: 20px;
		color: #666;
		padding:0;
		margin: 0px 8px 0px 8px;
		background-clip: padding-box;
		float : left;
	}

    .file-info{float:left;width:100%;color:#666;}
    table.tabel-upload {padding-top:5px; border-spacing:0;}
    table.tabel-upload td {padding:0;}
   
   .kecil {
   	width: 600px;
   } 
   .info-upload {
	float : right;
	width : auto;
	height : auto;
	text-align : right;
   }
</style>

<div class="container kecil" style="margin-top:10px;">
    <form id="frm_wow" name="frm_wow" method="post" enctype="multipart/form-data">
        <table class="tabel-upload">
            <tr>
                <td><b>Judul *</b></td>
                <td><input type="text" class="span6" name="judul" placeholder="Video Wow"/></td>
            </tr>
            <tr>
                <td><b>Kategori *</b></td>
                <td><input readonly="readonly" type="text" class="span6" name="kategori" value="<?php echo $wow_event_name; ?>" /></td>
            </tr>
            <tr>
                <td><b>Genre *</b></td>
                <td>
                    <select id="select-genre" name="genre" class="span6" style="width: 447px;">
                        <?php foreach($genres as $genre): ?>
                            <option value="<?php echo $genre->id; ?>"><?php echo $genre->name; ?>     
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Tags *</b></td>
                <td><input type="text" class="span6" name="tags" placeholder="wow" /></td>
            </tr>
            <?php 
            $loop = 1;
            foreach($fields as $field): ?>
            <tr>
                <td><b><?php echo $field->event_field; ?></b></td>
                <td><input type="text" class="span6" id="<?php echo $field->id_event_field; ?>" name="custom_field[]" placeholder="<?php echo $field->event_field; ?>" style="min-width: 200px;" /></td>
            </tr>
            <?php 
            $loop++;
            endforeach; ?>
            <tr>
                <td><strong>Deskripsi</strong></td>
                <td><textarea style="resize: none;" class="span6" name="deskripsi" rows="3" cols="80" placeholder="video ini tentang channel wow"></textarea></td>
            </tr>
            <tr>
                <td><strong>Pilih File Upload *</strong></td>
                <td>
                    <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="wow" />
                    <input type="file" id="video" name="video" />
                    <div class="info-upload">
						(<?php echo isset($allowed_movie_type)?$allowed_movie_type:'mp4'; ?> | max size: <?php echo isset($max_file_size)?ceil($max_file_size/1024/1024):0; ?> MB)
					</div>
                    <div class="file-info"></div>
                </td>
            </tr>
            <tr>
                <td><strong>Pilih Thumbnail *</strong></td>
                <td>
                    <input type="file" id="thumbnail" name="thumbnail" />
                    <div class="info-upload">(.jpg)(max size: 5MB)</div>
                    <div class="file-info"></div>
                </td>
            </tr>
            <tr nowrap="true">
                <td colspan="2"><input type="checkbox" id="setuju" name="setuju" />
                    Dengan mengklik berarti peserta setuju dengan <a href="<?php echo site_url('wow/read/index/'.$toc_id) ;?>" target="_blank">syarat dan ketentuan</a>
		</td>
            </tr>
            <tr>
                <td colspan="2">
				<br>
                    <input class="upload" id="btn-submit" type="submit" value="SUBMIT" disabled="true" />
                    <input class="upload" id="btn-reset" type="reset" value="RESET" />
                    <input class="back" type="button" value="CANCEL" onclick="startWizard(false);" />
                    
                    <input class="cancel-upload" type="button" value="CANCEL UPLOAD" onclick="cancelUpload();" style="display:none; width: 110px;"  />
                </td>
            </tr>
        </table>
    </form>
</div>

<div class="container kecil">
    <div class="progress">
        <div class="bar-progress"></div>
        <div class="progress-text"></div>
    </div>
</div>

<script>
    var wow_event_id = "<?php echo $wow_event_id; ?>";
    var allowed_movie_type = "<?php echo isset($allowed_movie_type)?$allowed_movie_type:'mp4'; ?>";
    var allowed_thumb_type = 'jpg';
    var allowed_movie_size = '<?php echo isset($max_file_size)?$max_file_size:1024*1024*10;?>';
    var allowed_thumb_size = 1024*1024*4; // 4 MB
    
    $(document).ready(function(){
        //loadGenre();
        var bar = $('.bar-progress');
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
                progressText.html(percentVal);
            },
            success: function(data) {
                var percentVal = 'Wait to complete...';
                bar.width(percentVal);
                
                if (data['success']==false)
                    alert(data['message']);
                else{
                    //load finish page
                    $('div#upload-wizard').load('<?php echo site_url('wow/upload/wizard_loadfinish'); ?>/'+wow_event_id, function(){
                        $('h1#wow-wizard-title').html('Upload Anda telah berhasil');
                    });
                }
            },
            error: function (data){ 
                alert('Upload failed');
            }
            
        }; 
        
        
        // bind form using 'ajaxForm' 
        $('#frm_wow').ajaxForm(options); 
        
        
        $('input[type="file"]').change(function(){
            var theName = $(this).attr('name');
            var file_size = this.files[0].size;
            var file_type = this.files[0].type || 'unknown type';
            var last_modified = this.files[0].lastModifiedDate.toLocaleDateString() || 'n/a';
            
            //get file name
            var file_name = $(this).val();
            var file_extension_arr = file_name.split('.');
            var file_ext = file_extension_arr[file_extension_arr.length-1];
            
            var allowed_type = '';
            if (theName==='video'){
                //check file type
                allowed_type = allowed_movie_type.split(',');
                //check file size
                if (typeof file_size!=='undefined' && file_size > allowed_movie_size){
                    alert('Ukuran file anda melebih dari yang diijinkan. Pastikan ukuran file upload anda maks ' + parseInt(allowed_movie_size/1024/1024)+' MB');
                    $(this).val('');
                    return;
                }
            }else{
                allowed_type = allowed_thumb_type.split(',');
                
                //check file size
                if (typeof file_size!=='undefined' && file_size > allowed_thumb_size){
                    alert('Ukuran file anda melebih dari yang diijinkan. Pastikan ukuran file upload anda maks ' + parseInt(allowed_thumb_size/1024/1024)+' MB');
                    $(this).val('');
                    return;
                }
            }
            
            if (allowed_type.indexOf(file_ext.toLowerCase())<0){
                alert('Tipe file anda "' + file_ext+'" tidak diijinkan. Silahkan upload file dengan tipe '+ allowed_type.join(','));
                $(this).val('');
            }
            
            $(this).next('.file-info').html('<strong>'+ file_name + '</strong>'+ ' ( ' + file_type + ' ) ' + ' -- ' + file_size + ' bytes -- lastmodified ' + last_modified);
        });
        
        //setuju
        $('#setuju').click(function(){
            var checked = $(this).is(':checked');
            if (checked)
                $('input#btn-submit').removeAttr('disabled');
            else
                $('input#btn-submit').attr('disabled', 'disabled');
                
                
        });
        $('input#btn-reset').click(function(){
            $('#setuju').attr('checked', false);
            $('input#btn-submit').attr('disabled', 'disabled');
        });
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
        }
        if (form.tags.value==''){
            alert('Tags tidak boleh kosong');
            return false;
        }
        
        
        if (form.video.value==''){
            alert('Anda belum memilih video untuk upload');
            return false;
        }
        if (form.thumbnail.value==''){
            alert('Anda belum memilih image untuk upload');
            return false;
        }
        
        //disable all button
        $('.upload').attr('disabled',true);
        $('.back').attr('disabled',true);
        //show button cancel upload
        $('.cancel-upload').show();
        
        return true; 
    }
    
    function cancelUpload(){
        //enable button submit and reset and cancel, hide button cancel upload
        $('.cancel-upload').hide();
        $('.upload').attr('disabled',false);
        $('.back').attr('disabled',false);
        
        //send post cancel upload
        $.post("<?php echo site_url('ajax/wow');?>",{func:'cancelUpload'});
        
        goNext(wow_event_id);
    }
    
</script>