<meta name="title" content="<?php echo $album->albumName; ?> - <?php echo config_item('meta_title_suffix'); ?>" />
<meta name="keywords" content="<?php echo $album->albumName; ?> - <?php echo config_item('meta_title_suffix'); ?>" />
<meta name="description" content="<?php echo config_item('meta_title_suffix'); ?> > Music > <?php echo $album->albumName; ?>, <?php echo $album->mainArtistName; ?>, <?php echo $album->genreName; ?>" />
<link rel="image_src" href="<?php echo config_item('api_sync') .'music/'. $album->albumLImgPath ?>" />


<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />


<style>
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float : left;
		clear:both;
    }

    .uz-title-container {
        width: auto;
        height: 20px;
        float : left;
    }

    .uz-container-1 {
        width: 375px;
        height: auto;
        float : left;
    }

    .uz-container-2 {
        width: 790px;
        height: auto;
        float : left;
    }

    #landing-page-music {
        background: white;
        color: #666;
    }

    .player-fly-container {
        position : absolute;
		top:393px;
        width: 375px;
        height: auto;
        float : left;
    }
    .title-fly-player {
        width: 280px;
        height: auto;
        background:rgba(255,255,255,0.5);
        padding-left : 10px;
        padding-right : 10px;
        color : #666;
        font-size: 14px;
		display : none;
    }
	
    #img-list {
        display : none;
    }
    .scr-song-list a {
        color : #666;
    }
    .scr-song-list a:hover {
        color : #666;
        text-decoration: underline;
    }
    
    .ajax_loader {display: none;}
    
</style>
    <div class="uz-main-container-up" id="landing-page-music">
        <div class="uz-container-1">
            <div class="tile-span-6" id="img-list">
                <h2 id="title-cat-album">New Release</h2>
            </div>
            <div class="music-player">
                <img src="<?php echo config_item('api_sync').'music/'; ?><?php echo $album->albumLImgPath ?>" width="300" height="313">
                <div class="player-fly-container">
                    <div class="music-player-container">
                        <div class="box hide-container" id="player-container">
                            <div class="title-fly-player"><h3><span><marquee width='280' height='24' id="title"></marquee></span></h3></div>
                            <iframe name="player-music" width="300" height="24" style="overflow:hidden" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
                <table id="detail-metadata" width="100%" style="margin-top:10px;">
                    <tr>
                        <td width="50">Album</td><td>:</td>
                        <td><?php echo $album->albumName; ?></td>
                    </tr>
                    <tr>
                        <td>Artist</td><td>:</td>
                        <td><?php echo $album->mainArtistName; ?></td>
                    </tr>
                    <tr>
                        <td>Genre</td><td>:</td>
                        <td><?php echo $album->genreName; ?></td>
                    </tr>
                    <?php if (isset($album->issueDate)):?>
                    <tr>
                        <td>Year</td><td>:</td>
                        <td><?php echo substr($album->issueDate,0,4); ?></td>
                    </tr>
                    <?php endif;?>
                </table>
                <div style="width: 100%; height: auto; margin-top: 5px;">
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_counter addthis_pill_style"></a>
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                    </div>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51de9ac26202a940"></script>
                    <!-- AddThis Button END -->
                </div>
            </div>
        </div>
		<div class="uz-container-2">
            <div class="tab-container" style="width: 790px;margin-top: 10px;">
                <div style="
                     width:auto;
                     height: 25px;
                     padding-top: 7px;
                     padding-left: 20px;
                     text-align: left;
                     border : 1px solid #c0c3c8;
                     border-radius: 5px;
                     font-size: 14px;
                     ">
                    Songlist
                </div>
                <div class="scr-song-list" style="
                     width: 100%;
                     height: 200px;
                     overflow-x: hidden;
                     overflow-y: auto;
					 margin-bottom:15px;
					 padding-top:5px;
                     ">
                    <table width="100%">
                        <?php $i = 1;
                        foreach ($songs as $song): ?>
                            <tr>
                                <td width="5" align="center"><?php echo row_number($i++); ?></td>
                                <td width="75"><?php echo $song->songName; ?></td>
                                <td width="10" align="center"><a title="Play" href="<?php echo   base_url(); ?>music/player/getplayerframe?song_id=<?php echo $song->songId;?>" target="player-music" onclick="playSongFrame(<?php echo $song->songId; ?>,'<?php echo $song->songName; ?>','<?php echo $song->id; ?>');">Play</a></td> <!-- 05/08/2013 by Alex -->
                                <td width="10" align="center"><a href="javascript:openCart(<?php echo $song->songId; ?>);" title="Download">Download</td>
                            </tr>
                    <?php endforeach; ?>
                    </table>
                </div>
                <!-- --------------------------------------------- Tab ----------------------------- -->
                <ul class="tabs" persist="true">
                    <li><a href="#" rel="view1">Top Chart</a></li>
                    <li><a href="javascript:getMyList();" rel="view2">My List</a></li>
                    <li><a href="javascript:getMyList();" rel="view3">Our Recomendation</a></li>
                </ul>
                <div class="tabcontents">
                    <!-- chart latest -->
                    <div id="view1" class="tabdetailmusic">
                        <table width="100%">
                            
                            <?php $i = 1;
                            foreach ($chart as $album):
                                ?>
                                <tr>
                                    <td align="center"><?php echo $album->ranking; ?>.</td>
                                    <td align="left"><?php echo $album->songName; ?></td>
                                    <td align="left"><?php echo $album->artistName; ?></td>
                                    <td align="center"><a title="Detail" href="<?php echo   base_url();?>music/detail/album/<?php echo $album->albumId; ?>" onclick="showAlbumDetail(<?php echo $album->albumId; ?>);">Show</a></td>
                                </tr>
                                <?php if ($i > 4) break; ?>
                                <?php $i++;
                            endforeach;
                            ?>
                        </table>
                    </div>
                    <div id="view2" class="tabdetailmusic">
                        <table width="100%">
							<?php $i = 1;
								foreach (array_reverse($playlist) as $key => $play):
							?>
								<tr>
									<td><?php echo $play['songName']; ?></td>
									<td><?php echo $play['artistName']; ?></td>
									<td align="center">
										<a title="Detail" href="<?php echo   base_url();?>music/detail/album/<?php echo $play['albumId']; ?>">Show</a>
										| <a title="Delete" href="javascript:void('');" onclick="deleteplaylist(<?php echo array_search($play, $playlist); ?>, this);">Delete</a>
									</td>
								</tr>
							<?php if ($i > 9) break; ?>
							<?php $i++;
								endforeach;
							?>
                        </table>
                    </div>
                    <div id="view3" class="tabdetailmusic">
                        <table width="100%">
						<?php $i = 1;
							foreach ($recommended as $album):
						?>
							<tr>
								<td align="center"><?php echo $i;?></td>
								<td align="left"><?php echo $album->mainSongName; ?></td>
								<td align="left"><?php echo $album->mainArtistName; ?></td>
								<td align="center"><a title="Detail" href="<?php echo   base_url();?>music/detail/album/<?php echo $album->albumId; ?>">Detail</a></td>
							</tr>
						<?php if ($i > 9) break; ?>
						<?php $i++;
							endforeach;
						?>
                        </table>
                    </div>

                </div>
                <div style="float:right;">
                    Powered by  <img src="<?php echo config_item('image_url');?>channel/music/melon-small.png" style="width : 84px;height: 30px;">
		</div>
                <!-- --------------------------------------------- end Tab ----------------------------- -->
            </div>
		</div>
    </div>

<script>
    $(document).ready(function() {
    	//loadGenre($('#category li a').attr('data'),$('#category li a').html());
        $('#category li a').click(function(){
            $('#landing-page-music').hide();
            redir($(this).attr('data'),$(this).html());
        });
    });

    function redir(category_id,title){
        window.location='<?php echo base_url('music/channel')?>#content/'+category_id+'/'+title;
    }

    function getMyList() {
        $('#view2').load("<?php echo site_url('music/channel/playlist'); ?>");
    }

    function deleteplaylist(urut, obj) {
        $.post("<?php echo site_url('music/channel/deleteplaylist'); ?>", {urut: urut}).success(function() {
            $(obj).parent('td').parent('tr').remove();
        });
    }
    
    function playSongFrame(songId,songName,id){

        //display container player if hidden
        if ($('div#player-container').css('display')==='none')
            $('div#player-container').show();
        $('.title-fly-player').show();
        //Show song title
        $('div#player-container marquee#title').text(songName);
        $.post("<?php echo base_url('music/channel/musicview')?>", { id: id}); // Added 05/08/2013 by Alex
    }
    function openCart(f) {
        var b = 612;
        var d = 508;
        var a = Math.floor((window.screen.availWidth - (b + 12)) / 2);
        var e = Math.floor((window.screen.availHeight - (d + 30)) / 2);
        if (f == undefined) {
            f = "";
        }
        var c = "http://www.melon.co.id/nologin/cart/add.do?songId=" + f;
        window.open(c,"cart", "width=" + b + ",height=" + d + ",status=yes,resizable=0,scrollbars=no,top=" + e + ",left=" + a);
    }
</script>