
<style>
    #upload-wizard{
        float: left;
        width: 100%;
        height:450px;
        overflow-y: auto;
        overflow-x: hidden;
    }
	.kecil {
		width: 600px;
	}     
</style>
<div><button id="my-button"><img src="<?php echo config_item('assets_wow'); ?>images/upload_btn.png" /></button></div>
<div id="element_upload">
    <a class="b-close">x</a>
    <h1 id="wow-wizard-title" class="pop-up-title">Upload Video</h1>
    <div id="upload-wizard">
        <div class="container kecil">
            <?php $this->load->view('channel/wow/upload/step-1'); ?>
        </div>
    </div>
</div>
<script>
    var wow_event_selected = 0;
    var is_loggedin = '<?php echo $is_loggedin;?>';
    
    var default_wizard_content = '';
    var default_wizard_title = '';
    $(document).ready(function(){
        
        //fill default content wizard
        default_wizard_content = $('#upload-wizard').html();
        default_wizard_title = $('#wow-wizard-title').text();
        $('#my-button').bind('click', function(e) {
            // Prevents the default action to be triggered. 
            e.preventDefault();
                
            startWizard();
        });
        
        
    });
    
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
        //Load another step to pop up
        $('div#upload-wizard').load('<?php echo site_url('wow/upload/wizard_loadform'); ?>/'+wow_event_selected, function(){
            $('h1#wow-wizard-title').html('Upload Your Files');
        });
    }
</script> 