<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro.css" />
<style type="text/css">
    .center{text-align: center;}
</style>
<div class="container">
    <h1 class="center">Upload Anda telah berhasil</h1>
    <h3 class="center">Silahkan share video anda</h3>
</div>
<div class="container center">
<!-- fb -->
<a href="#" 
    onclick="javascript:fb();">
    <img src="<?php echo config_item('assets_url').'/img/facebook-share-icon.gif'; ?>" alt="Share on Facebook" />
    <!--Share on Facebook-->
</a>
<!-- fb -->
<?php $target_url=site_url('wow/channel/gallery').'/'.$wow_event_id; ?>
<!-- tw -->
<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $target_url; ?>" data-text="Check My Video at " data-via="UzoneIndonesia" data-hashtags="UzoneIndonesia" data-dnt="true">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- tw -->
<!-- g+ -->
<!-- Place this tag in your head or just before your close body tag. -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $target_url; ?>"></div>
<!-- g+ -->
</div>
<div class="container center" style="padding-top:20px;">
    <!--<button class="btn btn-inverse" href="javascript:void(0);" onclick="closeDialog();">Close</button>-->
    <button class="btn btn-success" href="javascript:void(0);" onclick="toGallery();">Go To Your File</button>
</div>

<script>
    var wow_event_id = '<?php echo $wow_event_id;?>';
    var target_url = "<?php echo site_url('wow/channel/gallery').'/'.$wow_event_id; ?>";
    function fb(){
        window.open(
            'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(target_url), 
            'facebook-share-dialog', 
            'width=626,height=436'
        ); 
    return false;
  }
    function closeDialog(){
        $('#element_to_pop_up').bPopup().close();
        //window.location = "<?php echo site_url('wow/channel/gallery'); ?>/"+wow_event_id;
    }
    function toGallery(){
    	$('#element_to_pop_up').bPopup().close();
        window.location = "<?php echo site_url('wow/channel'); ?>";	
    }
    
</script>