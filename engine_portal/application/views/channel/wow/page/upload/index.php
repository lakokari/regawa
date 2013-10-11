<!-- slide panel item-->
<link href="<?php echo config_item("assets_url"); ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo config_item("assets_url"); ?>css/bootstrap-modal.css" rel="stylesheet" type="text/css" />
<script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
<link href="<?php echo config_item('assets_wow'); ?>css/style_slide_item_twitter_feed.css" rel="stylesheet" type="text/css" />
<script src="<?php echo config_item("assets_url"); ?>js/bootstrap.js"></script>
<!--override default bootstrap modal-->
<script src="<?php echo config_item("assets_url"); ?>js/bootstrap-modalmanager.js"></script>
<script src="<?php echo config_item("assets_url"); ?>js/bootstrap-modal.js"></script>
<style>
    #tittle-modal {
        margin: 0;
        font-size: 18px;
        line-height: 32px;
    }
    .modal-header {
        padding: 14px 23px 0 23px;
    }
    .modal-footer {
        padding: 0 13px;
    }
    #text-btn {
        font-size: 9px;
    }
    
    .step-upload-img-wrap {
        float: left;
    }
    .step-upload-img-wrap {
        width: 90px;
    }
    .step-upload-text-wrap {
        float: left;
        width: 345px;
        margin-left: 17px;
    } 
    .step-upload-text-wrap span, .step-upload-text-wrap div {
        color: #333333;
        display: block;
    }
    
    .step-upload-text-wrap .title1 {
        font-size: 20px;
        margin-top: 7px;     
        font-weight: bold;
    }
    .step-upload-text-wrap .title2 {
        margin-bottom: -5px;
    }    
    .step-upload-text-wrap .title3 {
        font-size: 9px;
        height: 9px;        
    }    
    .step-upload-text-wrap .social-but-wrap {
        
    }
    .social-but-wrap {
        padding-top: 12px;
    }
    
</style>


<div class="content-container">
    <div class="margin-container" style="margin-top: 50px;">
        <div id="upload-wizard">
            <div class="container" style="margin-left: 150px">
                <?php $this->load->view('channel/wow/page/upload/step-1'); ?>
            </div>
        </div>        
    </div>
</div>
<div class="modal hide fade" id="social" data-width="505" data-height="100" data-backdrop="static" data-keyboard="false">
    <div class="modal-header">
        <h2 style="color:#666;"  id="tittle-modal">Step 1</h2>
    </div>
    <div class="modal-body">
        <div class="step-upload-img-wrap">
            <img src="<?php echo config_item('assets_url'); ?>img/uzone.jpg"/>
        </div>
        <div class="step-upload-text-wrap">
            <span class="title1">Like Uzone in Facebook</span>
            <span class="title2">UZone Indonesia</span>
            <span class="title3">One Stop Digital Shop - Educate Enlight Entertain</span>
            <div class="social-but-wrap">
                <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FUZoneIndonesia&amp;width=450&amp;height=80&amp;colorscheme=light&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;send=false&amp;appId=<?php echo config_item('fb_app_id') ;?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:359px; height:28px;" allowTransparency="true">
                </iframe>
            </div>
        </div>        
    </div>
    <div class="modal-footer">
        <a href="#" class="" id="text-btn" onclick="twitterModal()" data-dismiss="" aria-hidden="">Skip this step</a>
    </div>
</div>

   
<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>
<script>
    var wow_settings = {event_select_id: 0};
    function show(id) {
        document.getElementById(id).style.display = "block";
    }
    
    function hide(id) {
        document.getElementById(id).style.display = "none";
    }
    
    var wow_event_selected = 0;
    var is_loggedin = '<?php echo $is_loggedin;?>';
    
    var default_wizard_content = '';
    var default_wizard_title = '';
    $(document).ready(function(){
        //cek session user apakah sudah login apa belum 
		if (is_loggedin==='yes'){
            return;
        }else{
           alert('Anda harus login untuk upload');
           window.location = '<?php echo base_url(); ?>wow/channel';
        }
		
        //fill default content wizard
        default_wizard_content = $('#upload-wizard').html();
        default_wizard_title = $('#wow-wizard-title').text();
        $('#my-button').bind('click', function(e) {
            // Prevents the default action to be triggered. 
            e.preventDefault();
                
            startWizard();
        });
                        
        $('a#social').click(function(){
            $('a#text-btn').empty();
            $('a#text-btn').append('Next');
        });
        
    });
    function twitterModal(){
        if (wow_settings.event_select_id == 2) {
            $('#text-btn').attr('onclick','closemdl()');
        } else {
            $('#text-btn').attr('onclick','useeTv()');
        }
        
        updateTitle('#tittle-modal', 'Step 2');
        updateTitle('.step-upload-text-wrap .title1', 'Like Uzone in Twitter');
        updateTitle('.step-upload-text-wrap .title2', '@UZoneIndonesia');        
        var socialStr = '<iframe allowtransparency="true" frameborder="0" scrolling="no"' +
                            'src="//platform.twitter.com/widgets/follow_button.html?screen_name=UZoneIndonesia"' +
                            'style="width:300px; height:20px;"></iframe>' ;
        updateTitle('.social-but-wrap', socialStr);        
    }
    function updateTitle(className, content) {
        $(className).empty()
        $(className).append(content);                        
    }
    function useeTv(){
        $('#text-btn').attr('onclick','closemdl()');
        updateTitle('#tittle-modal', 'Step 3');
        updateTitle('.step-upload-text-wrap .title1', 'Like UseeTV in Twitter');
        updateTitle('.step-upload-text-wrap .title2', '@UseeTVcom');   
        var socialStr = '<iframe allowtransparency="true" frameborder="0" scrolling="no"' +
                            'src="//platform.twitter.com/widgets/follow_button.html?screen_name=UseeTVcom"' +
                            'style="width:300px; height:20px;"></iframe>' ;
        updateTitle('.social-but-wrap', socialStr);                   
    }

    function closemdl(){
        //$('#text-btn').attr('data-dismiss','modal');
        //$('#text-btn').attr('aria-hidden','true');
        $('#social').modal('hide');
        var url = '<?php echo site_url('wow/upload/wizard_loadform'); ?>/' + wow_settings.event_select_id;
        $('div#upload-wizard').load(url, function(){
            $('h1#wow-wizard-title').html('Upload Your Files');
        });        
    }
    
    function startWizard(init){
        if (is_loggedin==='yes'){
            // Triggering bPopup when click event is fired
            if (typeof init==='undefined' || init===true){
                $('#element_upload').bPopup({
                    modalClose: false,
                    opacity: 0.8,
                    positionStyle: 'fixed', //'fixed' or 'absolute'
                    onClose: function (){
                        $('#upload-wizard').html(default_wizard_content);
                        $('#wow-wizard-title').text(default_wizard_title);
                    }
                });
            }else{
                $('#upload-wizard').html(default_wizard_content);
                $('#wow-wizard-title').text(default_wizard_title);
            }
        }else{
            alert('Anda harus login untuk upload');
            $('.tombol-panel-one').click();
        }
    }
    function goNext(wow_event_selected){
        
        /*$('#social').modal({
            keyboard: false,
            backdrop: false
        });*/
        //Load another step to pop up
        wow_settings.event_select_id = wow_event_selected;
        $('#social').modal('show');

    }
</script>