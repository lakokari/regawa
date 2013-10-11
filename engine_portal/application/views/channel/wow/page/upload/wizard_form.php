<style type="text/css">

    .tabel-upload input,.tabel-upload textarea ,.tabel-upload select{
        background: #181717;
        border : 1px solid #232222;
    }
    .tabel-upload select {
        padding: 10px 5px  !important;
        height: 42px;
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
	
	.btn-submit{
        border : 0px;
        border-radius : 5px;
        background: #d31821;
        color : #fff;
        width: 70px;
        height: 22px;
        font-size: 11px;
        font-weight: bold;
        text-transform : uppercase;
		float:left;
		margin-right:10px;
    }

	.btn-cancel-upload{
        border : 0px;
        border-radius : 5px;
        background: #d31821;
        color : #fff;
        width: 120px;
        height: 22px;
        font-size: 11px;
        font-weight: bold;
        text-transform : uppercase;
		float:left;
		margin-right:10px;
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
	float : left;
	margin-left : 20px;
	padding-bottom:20px;
   } 

   .banner-upload {
       width: 530px;
       height: 400px;
       float : left;
   }
   .banner-upload img {
       width: 100%;
       height: 100%;
   }
   
   #total, #uplcomp
{
	height: 350px;
	margin: 5px auto;
	width: 730px;
	padding: 5px;
	font-size: small;
	border: 2px dashed rgba(0,0,0,0.2);
}
#total
{
	background: url('<?php echo base_url()."userfiles/wow/banner/banner_upload.jpg";?>') center;
}
#log, #status, #remaining {
		font-size: small;
		color: #fff;
		margin-top:4px;
}


	div.progressbar {
	margin: 5px 0;
	position:relative; 

	border: 1px solid #fff;
	border-radius: 6px;
	-o-border-radius: 6px;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;    
	}
		
	.progressbar span {
	background-color: #ff0000; width:0%; height:20px; border-radius: 3px;

























	}
.progressbar .progress-text{  display:inline-block; top:3px; left:48%; padding:0 auto; font-size: 12px; color:#fff; float:left; position:absolute;}
div.upload {
    width: 166px;
    height: 166px;
	position: relative;
    background: url('<?php echo config_item('assets_wow').'css/img/upload-button.png'; ?>');
    overflow: hidden;
	margin:0 auto -150px auto ;
	top:147px;
	position:relative;
	cursor:pointer;cursor:hand
}
div.upload:hover {
	background: url('<?php echo config_item('assets_wow').'css/img/upload-button-hover.png'; ?>');
}

div.upload #fileToUpload {
    display: block !important;
    width: 166px !important;
    height: 166px !important;
    opacity: 0 !important;
    overflow: hidden !important;
	cursor:pointer;cursor:hand
}

div.info-upload {
	text-align:center;
	position: relative;
    overflow: hidden;
	margin:0 auto 0 auto ;
	top:300px;
	position:relative;
	cursor:pointer;cursor:hand
}

</style>

<h1 class="pop-up-title">
<?php 	if ($wow_event_id==2){ 
			echo "Upload Your Music";
		} else if($wow_event_id==3){
			echo "Upload Your Video";
		}

?>
</h1>
<div id="container">
	<div class="banner-upload">
					<div class="upload">
						<input type="file" id="fileToUpload" multiple="multiple" name="video"/>
					</div>
					<div class="info-upload">
						(<?php echo isset($allowed_movie_type)?$allowed_movie_type:'mp4'; ?> | max size: <?php echo isset($max_file_size)?ceil($max_file_size/1024/1024):0; ?> MB)
					</div>
					
					<div id="total"> </div>
					
					<button id="upload_btn" class="btn-submit">Submit</button>
					<button id="reset_btn" class="btn-submit" onclick="resetUpload()">Reset</button>
					<button id="cancel_btn" class="btn-cancel-upload" onclick="cancelUpload()" >Cancel Upload</button><br/>

					<div class="progressbar" id="pb">
					<span></span>
					<div class="progress-text">80</div>   
					</div>
					<div id="log"></div>
					<!--
					<div id="status"></div>
					<div id="remaining"></div>
					-->
					<div id="uplcomp"></div>
	</div>
	


	
	<div class="container kecil" style="margin-top:10px;">
		        <table class="tabel-upload">
            <tr>
                <td><b>Judul *</b></td>
                <td><input type="text" class="span6" name="judul" id="judul" placeholder="Video Wow"/></td>
            </tr>
			<!--
            <tr>
                <td><b>Kategori *</b></td>
                <td><input readonly="readonly" type="text" class="span6" name="kategori" id="kategori" value="<?php //echo $wow_event_name; ?>" /></td>
            </tr>
			-->
            <tr>
                <td><b>Kategori *</b></td>
                <td>
                    <select id="select-genre" name="genre"  class="span6" style="width: 447px;">
                        <?php foreach($genres as $genre): ?>
                            <option value="<?php echo $genre->id; ?>"><?php echo $genre->name; ?>     
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
			<!--
            <tr>
                <td><b>Tags *</b></td>
                <td><input type="text" class="span6" name="tags" id="tags" placeholder="wow" /></td>
            </tr>
			-->
            <?php 
            $loop = 0;
            foreach($fields as $field): ?>
            <tr>
                <td><b><?php echo $field->event_field; ?></b></td>
                <td><input type="text" class="span6" name="custom_field[]" id="custom_field<?php echo $loop; ?>" placeholder="<?php echo $field->event_field; ?>" style="min-width: 200px;" /></td>
            </tr>
            <?php 
            $loop++;
            endforeach; ?>
            <tr>
                <td><strong>Deskripsi</strong></td>
                <td><textarea style="resize: none;" class="span6" name="deskripsi" id="deskripsi" rows="3" cols="80" placeholder="video ini tentang channel wow"></textarea></td>
            </tr>
			<tr>
				<td>
					<input type="checkbox" id="setuju" name="setuju" />
                    Dengan mengklik berarti peserta setuju dengan <a href="<?php echo site_url('wow/read/index/'.$toc_id) ;?>" target="_blank">syarat dan ketentuan</a>
				</td>
			</tr>

        </table>
		

	</div>
</div>

<script>
    var wow_event_id = "<?php echo $wow_event_id; ?>";
    var allowed_movie_type = "<?php echo isset($allowed_movie_type)?$allowed_movie_type:'mp4'; ?>";
    var allowed_thumb_type = 'jpg';
    var allowed_movie_size = '<?php echo isset($max_file_size)?$max_file_size:1024*1024*10;?>';
    //var allowed_movie_size =1024*1024*4000;
	var iBytesUploaded = 0;
	var iBytesTotal = 0;
	var iPreviousBytesLoaded = 0;
    var options = '';
$( document ).ready( function() {

var count = 0;
var percentComplete = 0;
var upfiles = 0;
var cancel = document.getElementById("cancel_btn");

	$(".progressbar").hide();
	$("#cancel_btn").hide();
	$('#upload_btn').prop("disabled", true);

	$( '#container' ).on( 'upload', '#fileToUpload' , function( ) {
	
		var $this = $(this);
		if ( typeof upfiles[count] === 'undefined') return false;

			var data = new FormData();
			var file = upfiles[count];
			data.append( 'video', file );
			data.append( 'channel', <?php echo $wow_event_id; ?> );
			data.append( 'judul'	, 	$( '#judul' ).val() );
			//data.append( 'kategori'	, 	$( '#kategori' ).val()  );
			//data.append( 'tags'		, 	$( '#tags' ).val()  );
			data.append( 'team'		, 	0  );
			data.append( 'deskripsi', 	$( '#deskripsi' ).val()  );
			data.append( 'genre'	, 	document.getElementById("select-genre").value  );
			data.append('func', 'saveWowForm');			
<?php 
            $loop = 0;
            foreach($fields as $field): ?>
			data.append( 'custom_field<?php echo $loop; ?>'	, 	$( '#custom_field<?php echo $loop; ?>' ).val()  );
            <?php 
            $loop++;
            endforeach; 
			?>

		currfile = file.name;
		fileext = currfile.substr( -3 );

	if( fileext == "php" || fileext == ".js" ) {
			count++;
			$( '#uplcomp' ).append( 'File not allowed - ' + file.name + '<br />' );
			$this.trigger('upload');
	} else {
  
		$.ajax({
			url: '<?php echo site_url('ajax/wow/saveWowForm');?>',
			type:'POST',
			data: data ,
			contentType: false,
			processData: false,
			beforeSend: function( ) {
				$('#log').text( 'Uploading ' + file.name );
				$(".progressbar").show();
				$("#cancel_btn").show();
				$('#reset_btn').prop("disabled", true);
			},
			xhr: function() {  
				var xhr = $.ajaxSettings.xhr();
				if(xhr.upload){
					xhr.upload.addEventListener( 'progress', showProgress, false);
				}
				/*
					cancel.addEventListener("click", function(){
						xhr.abort();
					}, false);
				*/
				return xhr;
			},
			success: function( data ) {                
                if (data['success']==false)
                    alert(data['message']);
                else{
                    //load finish page
                    $('div#upload-wizard').load('<?php echo site_url('wow/upload/wizard_loadfinish'); ?>/'+wow_event_id, function(){
                        $('h1#wow-wizard-title').html('Upload Anda telah berhasil');
                    });
                }
			},
			error: function( ){ 
				alert( "Upload Canceled or Failed"); 
			}
		},3600);
	}
 
	});



		$( '#total' ).bind( 'dragover',function(event) {
			event.stopPropagation();	
			event.preventDefault();	
		});

	$( '#total' ).bind( 'drop',function(event) {
		
		event.stopPropagation();	
		event.preventDefault();
		
		if( upfiles == 0 ) 
				upfiles = event.originalEvent.dataTransfer.files;
		else {
			if( confirm( "Anda akan mengupload "+ event.originalEvent.dataTransfer.files[count].name +"?" ) == true ) {

				upfiles = event.originalEvent.dataTransfer.files;
				$( '#fileToUpload' ).val('');
			}
			else
				return;
		}
		$( "#fileToUpload" ).trigger( 'change' );
		});



		
		$("#upload_btn").click( function() { 

     
			if (document.getElementById("judul").value==''){
				alert('Judul tidak boleh kosong');
				return false;
			}else if (document.getElementById("setuju").checked == false){
				alert('Anda harus menyetujui syarat dan ketentuan');
				return false;
			}else{

	
			if ( upfiles ) {
				$( '#fileToUpload' ).trigger('upload'); // trigger the first 'upload' - custom event.
				$(this).prop("disabled", true);
			}
			else {
				alert( "Please select a file" );
				return;
			}
		}
			
		});

		
		$( "#fileToUpload" ).change( function() {
			
			var fileIn = $( "#fileToUpload" )[0];

			if( !upfiles ) 
				upfiles = fileIn.files; 
			else {
				if( fileIn.files.length > 0 ) {
					if( confirm( "Anda akan mengupload " + fileIn.files[count].name +"?" ) == true )

						upfiles = fileIn.files; 
					else 
						return; 
				}
			} 
				
			$( '#total' ).html( '<b> File yang akan diupload </b>:' );
			$('#upload_btn').prop("disabled", false);
			
			$(upfiles).each( function(index, file) {
				size = Math.round( file.size / 1024 );
				if( size > 1024 ) 
					size =  Math.round( size / 1024 ) + ' mb';
				else
					size = size + ' kb';		
				$( '#total' ).append( file.name + " ( " + size + " ) <br />" );
			});
		            var theName = $(this).attr('name');
            var file_size = upfiles[count].size;
            var file_type = upfiles[count].type || 'unknown type';
			var last_modified = upfiles[count].lastModifiedDate.toLocaleDateString() || 'n/a';
            
            //get file name
            var file_name = upfiles[count].name;
            var file_extension_arr = file_name.split('.');
            var file_ext = file_extension_arr[file_extension_arr.length-1];
            
            var allowed_type = '';
            if (theName==='video'){
                //check file type
                allowed_type = allowed_movie_type.split(',');
                //check file size
                if (typeof file_size!=='undefined' && file_size > allowed_movie_size){
                    alert('Ukuran file anda melebih dari yang diijinkan. Pastikan ukuran file upload anda maks ' + parseInt(allowed_movie_size/1024/1024)+' MB');
					$( '#fileToUpload' ).val('');
					$( '#total' ).text(' ');
					$('#upload_btn').prop("disabled", true);
                    return;
                }
            }
            
            if (allowed_type.indexOf(file_ext.toLowerCase())<0){
                alert('Tipe file anda "' + file_ext+'" tidak diijinkan. Silahkan upload file dengan tipe '+ allowed_type.join(','));
                   $( '#fileToUpload' ).val('');
					$( '#total' ).text(' ');
					$('#upload_btn').prop("disabled", true);
					return;
            }
            
            $(this).next('.file-info').html('<strong>'+ file_name + '</strong>'+ ' ( ' + file_type + ' ) ' + ' -- ' + file_size + ' bytes -- lastmodified ' + last_modified);		
		});
	});



		function showProgress(evt) {
			if (evt.lengthComputable) {










				var iCB = evt.loaded;
				var iDiff = iCB - iPreviousBytesLoaded;

				// if nothing new loaded - exit
				if (iDiff == 0)
					return;

				iPreviousBytesLoaded = iCB;
				iDiff = iDiff * 2;
				var iBytesRem = evt.total - iPreviousBytesLoaded;
				var secondsRemaining = iBytesRem / iDiff;

				// update speed info
				var iSpeed = iDiff.toString() + 'B/s';
				if (iDiff > 1024 * 1024) {
					iSpeed = (Math.round(iDiff * 100/(1024*1024))/100).toString() + 'MB/s';
				} else if (iDiff > 1024) {
					iSpeed =  (Math.round(iDiff * 100/1024)/100).toString() + 'KB/s';
				}
				//$( '#remaining' ).text( secondsToTime(secondsRemaining) + 'Remaining  ' );
				
				percentComplete = (evt.loaded / evt.total) * 100;
				$('#pb span').animate(	
					{ width: percentComplete + '%' }, 
					{ step: function(now) {
								$('.progress-text').text(Math.round(now) + '% ' + secondsToTime(secondsRemaining) + 'Remaining');
							}, duration: 10
					}
				);
				
				//$( '#status' ).text( 'Uploaded  ' + Math.round( evt.loaded / 1024 ) + ' kb of   ' + Math.round( evt.total / 1024 ) + ' kb' );

			}  

		}

		function secondsToTime(secs) { // we will use this function to convert seconds in normal time format
			var hr = Math.floor(secs / 3600);
			var min = Math.floor((secs - (hr * 3600))/60);
			var sec = Math.floor(secs - (hr * 3600) -  (min * 60));

			if (hr < 10) {hr = "0" + hr; }
			if (min < 10) {min = "0" + min;}
			if (sec < 10) {sec = "0" + sec;}
			if (hr) {hr = "00";}
			return hr + ':' + min + ':' + sec;
		}
	
	    function resetUpload(){
			$( '#total' ).text(' ');
			//$( '#status' ).text(' ');
			$( '#fileToUpload' ).val('');
			$( '#judul' ).val('');
			$( '#deskripsi' ).val('');
			
			<?php 
            $loop = 0;
            foreach($fields as $field): ?>
				$( '#custom_field<?php echo $loop; ?>' ).val('');
            <?php 
            $loop++;
            endforeach; 
			?>
		}
		
		function cancelUpload(){
		
		resetUpload()
		
		count = 0;
		percentComplete = 0;
		upfiles = 0;
		
		$('#pb div').animate({ width: '0%' }, { step: function(now) {
			$(this).text( '0%' );
		},	duration: 10 });

		$( ".progressbar" ).hide();
		$( "#log" ).hide();
		$( "#uplcomp" ).hide();
		
		$.post("<?php echo site_url('ajax/wow');?>",{func:'cancelUpload'});
        
        goNext(wow_event_id);
	}
</script>

