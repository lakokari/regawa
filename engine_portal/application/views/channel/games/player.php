<script src="<?php echo config_item('assets_url'); ?>js/swfobject.js"></script>

<style>
  body    { margin: 0px; padding : 0px; }
  #player { position: absolute; top : 0px; left : 0px; }
</style>

<div id="player" style="z-index:10000;"></div>

<?php

  $height = $game->height ? $game->height : 300 ;

  //need to resize
  $max_width = 768;
  $width = ($game->width && $game->width<=$max_width) ? $game->width : $max_width ;

?>

<script type="text/javascript">
  swfobject.embedSWF("<?php echo $game->swf_url;?>", "player", "<?php echo $width; ?>", "<?php echo $height; ?>", "9.0.0",{},{menu: "true"});
</script>