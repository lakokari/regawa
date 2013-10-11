
		<div class="playtime-thumb" id="video-player-footer">
			<a href="#">
				<img src="<?php echo $data_video->img_path; ?>">
				<div class="overlay-play-icon"></div>
			</a>
		</div>
	
	<script src="<?php echo config_item('assets_url'); ?>js/jquery.min.10.js"></script>
	<script src="<?php echo config_item("assets_url"); ?>jwplayer/jwplayer.js"></script>
	<script type="text/javascript">jwplayer.key="6aMwqeMz0opU9trgteTwz6bLsKUOzlGvNCg64g==";</script>
	
	<script>

		$(document).ready(function() { 
		//call jw player to handle video

		jwplayer('video-player-footer').setup({
				file: '<?php echo config_item('userfiles').'/wow/news/'.$data_video->video_path; ?>',
				image: '<?php echo config_item('userfiles').'/wow/news/'.$data_video->img_path; ?>',
				autostart: true,
				'modes': [
					{type: 'flash', src: "jwplayer.flash.swf"},
					{type: 'html5'}
				],
				width: 520,
				height: 350
		});
		});
	</script>