<link rel="stylesheet" type="text/css" href="<?php echo config_item("assets_url"); ?>css/bootmetro.css" />
<style type="text/css">
    .social-share-cot{
		text-align: center;
		width : 320px;
		display:block;
		margin:auto auto;
		padding:10px 0;
	}
	.facebook-share-container {
		width : auto;
		height : 20px;
		float : left;
		margin-right : 50px;
	}
	.twitter-share-container {
		width : auto;
		height : 20px;
		float : left;
		margin-right : 50px;
	}
		.twitter-share-container img{
		height : 18px;

	}
	.gplus-share-container {
		width : auto;
		height : 20px;
		float : left;
	}
	.status-finish-upload {
		display : block;
		width : auto;
		height : auto;
		margin : auto auto;
		text-align : center;
		padding-top: 165px;
		padding-bottom: 20px;
	}
</style>
<div class="status-finish-upload">
    <h3>Upload Berhasil Dilakukan.</h3>
	<p>Hasil upload video anda akan bisa dilihat setelah proses validasi selesai.</p>
	<p></p>
</div>
<div class="social-share-cot">
<div class="facebook-share-container">
	<!-- fb -->
	<a href="#" 
		onclick="javascript:fb();">
		<img src="<?php echo config_item('assets_url').'img/facebook-share-icon.gif'; ?>" alt="Share on Facebook" />
		<!--Share on Facebook-->
	</a>
	<!-- fb -->
</div>
<?php $target_url=site_url('wow/channel/gallery').'/'.$wow_event_id; ?>
<!-- tw -->

<div class="twitter-share-container">

<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $target_url; ?>" data-text="Check My Video at " data-via="UzoneIndonesia" data-hashtags="UzoneIndonesia" data-dnt="true">
<img src="<?php echo config_item('assets_url').'img/twit_share_btn.png'; ?>" height="18px"/>
</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</div>
<!-- tw -->
<!-- g+ -->
<!-- Place this tag in your head or just before your close body tag. -->
<div class="gplus-share-container">
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-annotation="bubble" data-href="<?php echo $target_url; ?>"></div>
</div>
<!-- g+ -->
</div>
<div class="status-finish-upload" style="padding-top:20px;">
    <button class="btn btn-inverse" href="javascript:void(0);" onclick="closeDialog();">Watch My Video</button>
   <!--<button class="btn btn-success" href="javascript:void(0);" onclick="toGallery();">Go To Your File</button>-->
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
        //$('#element_to_pop_up').bPopup().close();
        window.location = "<?php echo site_url('wow/channel/nominee'); ?>/"+wow_event_id;
    }
    function toGallery(){
        window.location = "<?php echo site_url('wow/channel/mygallery'); ?>";	
    }
    
</script>