<meta name="title" content="<?php echo $item->title; ?> - <?php echo config_item('meta_title_suffix');?>" />
<meta name="keywords" content="<?php echo $item->title; ?> - <?php echo config_item('meta_title_suffix');?>" />
<meta name="description" content="<?php echo config_item('meta_title_suffix');?> > Games > <?php echo $item->description; ?>" />
<link rel="image_src" href="<?php echo $item->thumbnail_url ?>" />

<script type="text/javascript" src="<?php echo config_item('assets_url'); ?>js/jquery.cool.dialog.js"></script>
<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>css/cool_dialog.css" />


<style> 
    .ajax_loader {display: none;}
    #landing-page-games {
        background: white;
        color: #000;
        margin-left:-10px;
    }
    .detail-containter-games  {
        width: 100%;
        height: 460px;
    }
    
    .deskripsi-rounded {
        width: 100%;
        height: auto;
        padding-top: 2px;
        padding-bottom: 2px;
        border : 1px solid #999999;
        border-radius: 5px;
        text-align: center;
    }
   .covergames-detail {
        height:233px;
        width:280px;
    }
    #games-play-container {
        display :none;
    }
    #player{max-width: 800px;}
    #games-list {display : none;}
        .table-detail stripped {
                margin-top:30px;
        }   
    .uz-thumb-small {
        width : 100px;
        height: 100px;
        float : left;
                vertical-align:middle;
                display:block;
        border : 1px solid #fff;
    }
    .uz-thumb-small img {
        width : 100px;
        height: 100px;
                vertical-align:middle;
    }
        a .tile square image {
                width:100px;
                height:100px;
        }
	
    .panorama .panorama-sections .panorama-section.tile-span-8 {
        width:1130px;
    }
	
    .uz-main-container-up {
        padding-left: 70px;
        width: 1200px;
        height: auto;
        border:0px solid #F00;
        float : left;
    }
    .uz-title-container {
        width: 250px;
        height: 20px;
        float : left;       
    }
    
    .uz-container-3 {
        width: 320px;
        height: 340px;
        float : left;       
    }
	
    .uz-container-3-content {
        width: 320px;
        height: 340px;
        float : left;
    }
	
    .uz-container-wrap {
        width: 60px;
        height: 340px;
        float : left;
    }
    
    .uz-container-4 {
        width: 280px;
        height: 340px;
        float : left;
    }
	
    .uz-container-4-content {
        width: 280px;
        height: 320px;
        float : left;
    }
    
    .uz-container-2 {
        width: 500px;
        height: 340px;
        float : left;
        margin-top:20px;
    }
	
    .uz-container-2-content {
        width: 500px;
        height: 320px;
        float : left;        
    }
    
    .uz-container-image-detail {
        width: 280px;
        height: 340px;
        float: left;
    }
    .uz-container-detail {
        width: 440px;
        height: 340px;
        float: left;
    }
    .uz-container-gameplay {
        width: 780px;
        height: auto;
        float: left;
        display: none;
    }
</style>

<div class="uz-main-container-up" id="landing-page-games">
    <div class="uz-container-gameplay">
        <div class="uz-title-container"><a href="javascript:back_detail();">&laquo; Back</a> - <span id="title"></span></div>
        <div class="box hide-container" id="player-container">
            <iframe name="frame-play" id="frame-play" src="" width="<?php echo $item->width; ?>" height="<?php echo $item->height; ?>" frameborder="0"></iframe>
        </div>
    </div>
    
    <div class="uz-container-image-detail" id="games-pic">
        <div class="covergames-detail">
            <img src="<?php echo $item->thumbnail_big_url ?>">
        </div>
        <div style="margin-top : 50px;">
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style">
                <a class="addthis_counter addthis_pill_style"></a>
                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                <a class="addthis_button_tweet"></a>
            </div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51de9ac26202a940"></script>
            <!-- AddThis Button END -->
        </div>
    </div>

    <div class="uz-container-wrap" id="games-wrap"></div>

    <div class="uz-container-detail" id="games-detail">
        <div class="deskripsi-rounded">Description</div>
        
            <table style="width:100%;font-size:12px;">
                <tr>
                    <td style="width:150px;height:25px; vertical-align:middle;">Title</td>
                    <td><?php echo $item->title; ?></td>
                </tr>
                <tr>
                    <td style="width:150px;height:25px; vertical-align:top;">Categories</td>
                    <td style="vertical-align:top;">[<?php echo $item->categories; ?>]</td>
                </tr>
                <tr>
                    <td style="height:25px;">Game Size (W x H)</td>
                    <td><?php echo $item->width; ?> x <?php echo $item->height; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="height:25px;"><?php echo $item->description; ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="height:50px;">
                        <a class="games-icon-play" href="javascript:playGame(<?php echo $item->ID; ?>,'<?php echo cleanString($item->title); ?>',<?php echo $inside; ?>);">
                            Play Game
                        </a> 
                        <?php if (count($item->video_url)) { ?> 
                            &nbsp;&nbsp; | &nbsp;&nbsp;
                            <a href='javascript:showModalMOB();' style="font-weight:bold; color:#000;">View Trailer</a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        
    </div>

    <div class="uz-container-wrap"></div>

    <div class="uz-container-3">
        <div class="uz-title-container">Top Games</div>
        <?php
        $i = 1;
        foreach ($top as $data) :
            ?>
            <a href="<?php echo base_url(); ?>games/detail/item/<?php echo $data->ID; ?>" title="<?php echo $data->title; ?>">
                <div class="uz-thumb-small">
                    <img src="<?php echo $data->thumbnail_url; ?>" class="imgSmall">
                </div>
            </a>
            <?php
            $i++;
            if ($i == 10)
                break;
        endforeach;
        ?>
    </div>

</div>


<div id="myModalMOB" class="modal hide fade" style='height:360px;width:420px;padding:5px 5px 5px 5px;'>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>    
    <div id="trailer" style="padding-top:20px;">
        <div id='player'>
        </div>
    </div>
</div>



<script>
    function redir(category_id){
        window.location='<?php echo base_url('games/channel')?>#category/'+category_id;
    }
    function playGame(gameID, game_name, inside){
        if (inside===1){
            $('#games-pic').hide();
            $('#games-wrap').hide();
            $('#games-detail').hide();

                    //alert(game_name);
            if ($('.uz-container-gameplay').css('display')==='none')
                $('.uz-container-gameplay').show();
            $('.uz-container-gameplay span#title').text(game_name);
            
            //add
            $('iframe#frame-play').attr('src','<?php echo base_url();?>games/player/getplayerframe?id_games=<?php echo $item->ID;?>');
        }else{
            var wnd = window.open('<?php echo $item->swf_url; ?>','PlayGame');
            wnd.focus();
        }
    }
    
    function back_detail(){
        $('.ajax_loader').show();
        $('.uz-container-gameplay').hide();
        window.location=document.URL;
    }
    
	
    function showModalMOB(){
        $('#myModalMOB').modal();
        var img='<?php echo $item->video_url;?>';
        img=img.replace('MP4','THUMB');
        img=img.replace('movie/MOVIE','movie/thumbnail/MOVIE');
        img=img.replace('.mp4','.jpg');
        jwplayer("player").setup({
            file: '<?php echo $item->video_url;?>',
            image: img,
            autostart: true,
            'modes': [
		{type: 'flash', src: "jwplayer.flash.swf"},
                {type: 'html5'}
            ],
            height: 340,
            width: 420
        });
    }
</script>

