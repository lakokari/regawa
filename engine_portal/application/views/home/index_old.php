<style>
    #click {
        width: 48px;
    }
    .cs-style-4 figcaption {
        z-index: 99;
    }
    .caption-thumb {
        position: absolute;
        bottom: 0px;
        left: 0px;
        z-index: 1;
        width: 150px;
        height: 30px;
        background: rgba(0,0,0,0.6);
        font-size: 25px;
        color: #fff;
        text-align: center;
    }
    
    /* untuk remove effect hover image */
    .no-touch .cs-style-4 figure:hover img,
    .cs-style-4 figure.cs-hover img {
        -webkit-transform: translateX(0%);
        -moz-transform: translateX(0%);
        -ms-transform: translateX(0%);
        transform: translateX(0%);
    }
    
    .grid figure.persegi img {
        max-width: 100%;
        width: auto;
        height: 112px;
    }
    .grid figure.portrait img {
        max-width: 100%;
        width: auto;
        height: 112px;
    }
    .grid figure.uzone img {
        max-width: 100%;
        width: auto;
        height: 118px;
    }
    
    .grid li {
        display: inline-block;
        width: 150px;
        margin: 0;
        padding: 5px;
        text-align: left;
        position: relative;
        background: #fff;
    }
</style>

<div id='panel'>
    <ul class="grid cs-style-4">
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>music/channel">
                        <div class="caption-thumb">Music</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-music" src="<?php echo config_item('image_url'); ?>music.jpg" alt="img05">
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>radio/channel">
                        <div class="caption-thumb">Radio</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-radio" src="<?php echo config_item('image_url'); ?>radio.jpg" alt="img06">
                                </td>
                            </tr>
                        </table></a></div> 
                                               
            </figure>
        </li>
        <li>
            <figure class="portrait">
                <div><a href="<?php echo base_url(); ?>movie/channel">
                        <div class="caption-thumb">Movie</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-movie" src="<?php echo config_item('image_url'); ?>movie.jpg" alt="img02">
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>games/channel">
                        <div class="caption-thumb">Games</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-games" src="<?php echo config_item('image_url'); ?>games.jpg" alt="img03">
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="uzone">
                <div><a href="<?php echo base_url(); ?>">
                        <img src="<?php echo config_item('image_url'); ?>uzone.png" alt="img01"></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>tv/channel">
                        <div class="caption-thumb">TV</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-tv" src="<?php echo config_item('image_url'); ?>tv.jpg" alt="img04">
                                </td>
                            </tr>
                        </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="portrait">
                <div><a href="<?php echo base_url(); ?>book/channel">
                        <div class="caption-thumb">Book</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-book" src="<?php echo config_item('image_url'); ?>books.jpg" alt="img02">
                                </td>
                            </tr>
                       </table></a></div>
            </figure>
        </li>
        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>apps/channel">
                        <div class="caption-thumb">Apps</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-apps" src="<?php echo config_item('image_url'); ?>apps.jpg" alt="img06">
                                </td>
                            </tr>
                       </table>
                        </a></div>
            </figure>
        </li>

        <li>
            <figure class="persegi">
                <div><a href="<?php echo base_url(); ?>wow/channel">
                        <div class="caption-thumb">WOW</div>
                        <table align="center">
                            <tr>
                                <td>
                                    <img id="image-wow" src="<?php echo config_item('image_url'); ?>wow.jpg" alt="img03">
                                </td>
                            </tr>
                       </table>
                    </a>
                </div>
            </figure>
        </li>
    </ul>
</div>
<div id='click'><img src="<?php echo config_item('assets_url'); ?>img/button-click-here-home.png"></div>




<script>
    var img_url = '<?php echo config_item('api_folder').'music/'; ?>';
    var step=1;
    
    //radio thumb 
    var myradio = new Array();
    <?php
    $urut = 0;
    foreach ($sod as $sod) { ?>
        myradio[<?php echo $urut;?>] = "<?php echo $sod->attachment?>";
        <?php $urut++;
        if ($urut == 3) {
            break;
        }
    }
    ?>
        
    //movie thumb
    var mymovie = new Array();
    <?php $i = 0;
    foreach ($top_view as $item) : ?>
        mymovie[<?php echo $i;?>] = "<?php echo $item->item_thumbnail_big; ?>";
    <?php $i++;
    if ($i == 3) break; endforeach; ?>
        
    
    //tv thumb
    var mytv = new Array();
    <?php $i = 0;
    foreach ($tvod as $item) : ?>
        mytv[<?php echo $i;?>] = "<?php echo $item->img; ?>";
    <?php $i++;
    if ($i == 3) break; endforeach; ?>
        
    //book thumb
    var mybook = new Array();
    <?php $i = 0;
    foreach ($bookbs as $item) : ?>
        mybook[<?php echo $i;?>] = "<?php echo config_item('api_folder').'books/'.$item->thumbnail_url; ?>";
    <?php $i++;
    if ($i == 3) break; endforeach; ?>
        
    //apps thumb
    var myapps = new Array();
    <?php $i = 0;
    foreach ($appstop as $item) : ?>
        myapps[<?php echo $i;?>] = "<?php echo config_item('api_folder').'apps/'.$item->icon_url; ?>";
    <?php $i++;
    if ($i == 3) break; endforeach; ?>
    
    //wow thumb
    var mywow = new Array();
    mywow[0] = "http://static.uzone.co.id/images/channel/wow/general_big.jpg";
    mywow[1] = "http://static.uzone.co.id/images/channel/wow/digital_idol_small.jpg";
    mywow[2] = "http://static.uzone.co.id/images/channel/wow/10seconds_small.jpg";
    
    window.onload = function start() {
        slideThumb();
    }
    
    $(document).ready(function() {
       
    });
    
    function slideThumb() {
        loadRandMusic(100010,step);
        loadRandGames(step);
        loadRandRadio(myradio[step-1]);
        loadRandMovie(mymovie[step-1]);
        loadRandTV(mytv[step-1]);
        loadRandBook(mybook[step-1]);
        loadRandApps(myapps[step-1]);
        loadRandWow(mywow[step-1]);
        if(step<3)
            step++;
        else
            step=1;
        setTimeout("slideThumb()",5000);
    } 
    
    
    
    function loadRandRadio(gambar){
        $('img#image-radio').attr("src",gambar);
    }
    function loadRandMovie(gambar){
        $('img#image-movie').attr("src",gambar);
    }
    function loadRandTV(gambar){
        $('img#image-tv').attr("src",gambar);
    }
    function loadRandBook(gambar){
        $('img#image-book').attr("src",gambar);
    }
    function loadRandApps(gambar){
        $('img#image-apps').attr("src",gambar);
    }
    function loadRandWow(gambar){
        $('img#image-wow').attr("src",gambar);
    }
    
    function loadRandMusic(genre, page) {
        if (page === undefined) page = 1;
        $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_new_album', genreId: genre, page: page, limit: 1}, function(result) {
            var data = jQuery.parseJSON(result);
            if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var gambar =  img_url + d['albumLImgPath'];
                    $('img#image-music').attr("src",gambar);
                }
            } 
        });
    }
    
    function loadRandGames(page){
        if (page===undefined) page = 1;
        $.post("<?php echo site_url('ajax/games'); ?>", {func: 'games_by_category_name',category_name:"MMO",page:page,limit: 1}, function(data) {
            if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    $('img#image-games').attr("src",d['thumbnail_url']);
                }	
            } 
        },'json');
    }
    
</script>
