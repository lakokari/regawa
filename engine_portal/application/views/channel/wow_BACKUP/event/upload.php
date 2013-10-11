<!-- bootsrap file upload -->
<script src="<?php echo config_item('assets_url'); ?>js/bootstrap-fileupload.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/bootstrap-fileupload.min.css" rel="stylesheet" type="text/css" />

<style>
    /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float : left;
    }
    .uz-main-container-down {
        width: 1200px;
        height: 200px;
        padding-left: 60px;
        float : left;
        margin-top: 5px;
    }
    .uz-title-container {
        width: 380px;
        height: 20px;
        float : left;
    }
    .uz-container-1 {
        width: 400px;
        height: 340px;
        float : left;
       
    }
    .uz-container-1-content {
        width: 400px;
        height: 320px;
        float : left;
    }
    .uz-container-wrap {
        width: 60px;
        height: 340px;
        float : left;
    }
    
    .uz-container-2 {
        width: 320px;
        height: 340px;
        float : left;
    }
    .uz-container-2-wide {
        width: 700px;
        height: auto;
        float : left;
    }
    .uz-container-2-content {
        width: 320px;
        height: 320px;
        float : left;
    }
    .uz-thumb-big {
        width : 236px;
        height: 314px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-thumb-big img {
        width : 236px;
        height: 314px;
    }
    .uz-thumb-small {
        width : 156px;
        height: 156px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-thumb-small img {
        width : 156px;
        height: 156px;
    }
    .wow-uz-thumb-big {
        width : 236px;
        max-height: 314px;
        float : left;
        border : 1px solid #fff;
    }
    .wow-uz-thumb-big img {
        width : 236px;
        max-height: 314px;
        padding-top: 39px;
        padding-bottom: 39px;
        background-color: #CFCFCF;
    }
    .blok-paragraph {
        width: 100%;
        float : left;
        height: auto;
    }
    
    #upload-container{
        display: none;
    }
    .hidden-content{
        display: none;
    }
</style>

<div class="uz-main-container-up">
     <div class="uz-container-1">  <!-- statis image menu wow by. Alex 8/5/2013-->
        <div class="uz-title-container"></div>
        <img src="<?php echo config_item('image_url');?>channel/wow/<?php echo $image_big; ?>">
     </div>

    <div class="uz-container-wrap"></div>


    <!-- Form Upload -->
    <div class="uz-container-2-wide">
        <div class="uz-title-container" style="width: 100%; margin-bottom: 10px;"></div>
        <div class="blok-paragraph">
            <p>
                <b>STEP 1</b><br />
                Upload dan share video kamu.:<br />
                Silahkan ikuti ketentuan berikut:
                <ul>
                    <li>Saya hanya meng-upload video yang saya ciptakan sendiri. –  <button class="btn btn-link btn-toggle" id="lengkap-1" style="color:#666;">Lengkapnya..</button></li>
                    <ol class="hidden-content">
                        <li>Anda harus memiliki atau memegang seluruh hak penting (hak cipta, dll) untuk video Anda.</li>
                        <li>"Saya memiliki izin" tidak berarti Anda menciptakannya.</li>
                        <li>Direksi, DP, editor, musisi, efek grafis seniman, dan aktor dapat meng-upload karya-karya yang mereka telah memberikan kontribusi signifikan.</li>
                        <li>Video Public domain tidak diperbolehkan.</li>
                        <li>Silahkan tambahkan peran Anda / keterlibatan dalam deskripsi video untuk menghindari kesalahan penghapusan.</li>
                    </ol>
                    <li>Saya mengerti bahwa beberapa jenis konten yang tidak diijinkan di Vimeo. –  <button class="btn btn-link btn-toggle" id="lengkap-2" style="color:#666;">Lengkapnya..</button></li>
                    <ol class="hidden-content">
                        <li>Anda tidak dapat meng-upload materi yang mengandung unsur seksual yang eksplisit atau pornografi. Ketelanjangan non-seksual diperbolehkan.</li>
                        <li>Anda tidak dapat meng-upload video yang menghasut kebencian, termasuk pidato diskriminatif atau menggambarkan tindakan melanggar hukum atau kekerasan ekstrem.</li>
                        <li>Anda dapat memposting video diri sendiri di TV, selama Anda memiliki izin untuk meng-upload dan video menggambarkan hanya keterlibatan Anda dalam program ini.</li>
                        <li>Anda tidak dapat meng-upload video potongan atau kompilasi adegan dari program TV atau film.</li>
                        <li>Anda tidak dapat meng-upload menangkap video game atau permainan, bahkan jika diedit.</li>
                    </ol>
                </ul>

                <b>STEP 2</b><br />
                Memasukkan info:
                <ul>
                    <li>Judul:</li>
                    <li>Deskripsi:</li>
                    <li>Kategori: Musik, Hiburan, Movie, Komedi, Olahraga, Hobbi, Lifestyle, Pendidikan, Teknologi.</li>
                    <li>Tag:</li>
                    <li>Share Video ke G+, FB, Twitter.</li>
                </ul>

                <b>STEP 3</b><br />
                Konfirmasi video sudah diupload.<br /><br />
                
                <label for="agree"><input type="checkbox" name="agree" id="agree" onclick="javascript:check();" /> Saya setuju dengan segala syarat dan ketentuan yang berlaku.</label>
            </p>
            <div class="row-fluid" id="upload-container">
                <?php if ($this->session->flashdata('upload_message')): ?>
                <div class="alert alert-error">
                    <strong><?php echo $this->session->flashdata('upload_message');?></strong>
                </div>
                <?php endif;?>
                <div class="well well-small">
                    <form id="frm-upload" class="form-inline" action="<?php echo site_url('wow/channel/uploadmovie');?>" method="post" enctype="multipart/form-data">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input span3" style="height:38px;">
                                    <i class="icon-file fileupload-exists"></i> 
                                    <span id="preview" class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-file">
                                    <span class="fileupload-new">Upload</span>
                                    <span class="fileupload-exists">Change</span>
                                    <input onchange="return validateUpload(this);" class="span2" type="file" id="userfile" name="userfile" />
                                </span>
                                <a href="#" id="btn-remove" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                <a href="javascript:doUpload();" class="btn fileupload-exists" style="padding-bottom:0px;height:34.2px;" >Submit</a>
                            </div>
                        </div>
                        <input type="hidden" name="event_category" value="<?php echo $event_category; ?>" />
                    </form>
                    <div id="allowed-file-type">
                        <p>File Type yang diperbolehkan: .webm, .mp4, .ogv</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var is_loggedin = "<?php echo ($this->user_m->is_loggedin()?1:0); ?>";
    $(document).ready(function(){
        $('#lengkap-1').click(function(){
            $('.hidden-content').eq(0).toggle();
        });
        $('#lengkap-2').click(function(){
            $('.hidden-content').eq(1).toggle();
        });
    });

    function check(){
        $('#upload-container').toggle();
    }

    function doUpload(){
        var frm_upload = document.getElementById('frm-upload');
        frm_upload.submit();
    }

    function validateUpload(obj){
        //check if user loggedin
        if (parseInt(is_loggedin)===0){
            //clean input file
            $(obj).val('');
            setTimeout(function(){alert("<?php echo config_item('text_no_login'); ?>")}, 100);
            $('#settings').click();
            return false;
        }
        //check file type
        return checkFileType(obj);
    }

    function checkFileType(inputFile){

        var filename = $(inputFile).val();
        var allowed_type = ['webm','mp4','ogv'];
        if (filename!=''){
            var ftype = filename.split('.');
            extension = ftype[ftype.length-1];
            if (allowed_type.indexOf(extension.toLowerCase())<0){
                setTimeout(function(){alert('Format '+ftype[ftype.length-1]+' tidak diperbolehkan.')}, 100);
                $(inputFile).val('');
                return false;
            }
        }

        return true;
    }
</script>