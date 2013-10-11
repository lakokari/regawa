<!--player html 5 -->
<script src="<?php echo config_item('assets_url'); ?>player/mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>player/mediaelementplayer.min.css" />
<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>player/mejs-skins.css" />
<!--player html 5-->

<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />

<!-- slide panel item-->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-radio.css" rel="stylesheet" type="text/css" />

<style>
    body {
        overflow-y : scroll;
        overflow-x: scroll;
    }
    #detail-player-container {display: none;}
    .container-full-radio {
        width:  auto;
        height: 500px;
        float : left
    }
    .player-container {
        width : 300px;
        margin-top: 10px;
        margin-left: 50px;
        margin-right: 20px;
        float : left;
    }
    .rod-container-list {
        width : 300px;
        margin-top: 10px;
        margin-left: 20px;
        margin-right: 20px;
        float : left;
    }
    .tab-container-list {
        width : 500px;
        margin-top: 10px;
        margin-left: 20px;
        margin-right: 20px;
        float : left;
    }
    .rod_list_scrol {
        width: 100%;
        height: 300px;
        overflow-x: hidden;
        overflow-y: scroll;
        border : 1px solid #e9e9e9;
    }
    .container-radio-up {
        width: 1250px;
        height: auto;
        float : left;
    }
    .container-radio-station {
        width: 1190px;
        padding-left : 50px;
        padding-right : 10px;
        height: auto;
        float : left;
    }
    ul.rod_list {
        list-style-type: none;
        padding: 0px;
        margin: 0px;
        font-size: 12px;
    }
    ul.rod_list li{
        border-bottom : 1px solid #697c8d;
        padding-top : 2px;
        padding-bottom : 2px;
    }

    ul.rod_list li a{
        color : #151515;
        text-decoration : none;
    }

    ul.rod_list li a:hover{
        color : #151515;
        text-decoration : underline;
    }   
    .category-title-container {
        color: #151515;
        font-size: 17px;
        margin-bottom: 10px;
    }
    .sub-cat-title-container {
        width: 100%;
        height : auto;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: center;
        border: 1px solid #797979;
        border-radius: 5px;
    }

    .thumb_rod_container {
        width: 50px;
        height: 50px;
        float : left;
    }
    .thumb_rod_container .thumb_image{
        width: 50px;
        height: 50px;
        float : left;
    }
    .thumb_rod_container .thumb_image img{
        width: 50px;
        height: 50px;
    }
    .thumb_rod_container .icon_play_rod{
        width: 50px;
        height: 50px;

        background: url('<?php echo config_item('assets_url'); ?>css/img/play.png');
        background-repeat: no-repeat;
        margin-top : 10px;
        margin-left : 9px;
        opacity:0.5;
        filter:alpha(opacity=50); /* For IE8 and earlier */
    }

    .thumb_rod_container .icon_play_rod:hover {
        width: 50px;
        height: 50px;

        background: url('<?php echo config_item('assets_url'); ?>css/img/play.png');
        background-repeat: no-repeat;
        margin-top : 10px;
        margin-left : 9px;
        opacity:0.9;
        filter:alpha(opacity=90); /* For IE8 and earlier */
    }
    .container-rounded-list-rod-playthumb {
        width : auto;
        height : auto;
        border : 1px solid #999;
        border-radius: 10px;
        padding : 5px;
        margin-bottom : 10px;
        margin-right : 5px;
    }
    .title_rod_list {
        width : auto;
        height : auto;
        padding-top : 5px;
        padding-bottom :  5px;
        border-bottom : 1px solid #999;
        margin-left : 10px;
    }
    .title_rod_list a {
        text-decoration : none;
    }
    .title_rod_list a:hover {
        text-decoration: underline;
        color : #d31821;
    }
</style>
<div class="container-full-radio">
    <div class="container-radio-up">
        <div class="player-container">
            <div class="container-bgblue" id="detail-player-container">
                <div class="container-content-blue" >
                    <div class="box-player">
                        <div class="music-title-detail">
                            <h4><span id="title_rod"></span></h4>
                        </div>
                        <div class="music-player-container">
                            <!-- player rod-->
                            <div class="box" id="player-container-rod">
                                <span id="loader-player" class="ajax-loader-small loader"></span>
                                <div id="player-item">
                                    <div id='test-player'>
                                        <video class="mejs-wmp" width="640" height="360" src="bento.mp3" type="video/mp4" id="player1" poster="" controls="controls" preload="none"></video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
                 <a class="addthis_counter addthis_pill_style"></a>
                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                <a class="addthis_button_tweet"></a>
            </div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51de9ac26202a940"></script>
            <!-- AddThis Button END -->
        </div>
        <div class="rod-container-list">
            <div id="rod-list-container" class="hide-container"><!-- this container will be filled by js call for album detail-->
                <?php if (!empty($_GET['search_podcast'])) { ?>
                    <div class="category-title-container">
                        Search Podcast
                    </div>
                    <div class="sub-cat-title-container">
                        <?php echo $_GET['search_podcast']; ?>
                    </div>

                    <ul class="rod_list">
                        <?php
                        $no = 1;
                        foreach ($search_podcast as $search_podcast) {
                            ?>
                            <li><a href="#" onclick='javascript:loadRODPlayer("Podcast > <?php echo cleanString($search_podcast->title); ?>", "<?php echo $search_podcast->file; ?>", "<?php echo $search_podcast->attachment; ?>");'>
                                    <?php echo $search_podcast->title; ?></a>
                            </li>
                            <?php
                            $no++;
                        }
                        ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
        <div class="tab-container-list">
            <!-- ----------------------------------------------- tab content --------------------------------------- -->
            <ul class="tabs" persist="true">
                <li><a href="#" rel="tab-chart-attack">Chart</a></li>
                <li><a href="#" rel="tab-best-podcast">Podcast</a></li>
                <li><a href="#" rel="tab-radio-req">Request </a></li>
                <li><a href="#" rel="view4">Info TMC</a></li>
            </ul>
            <div class="tabcontents">
                <div id="tab-chart-attack" class="tabcontent"><!-- load content chart attack -->

                </div>
                <div id="tab-best-podcast" class="tabcontent"><!-- load content best podcast -->

                </div>
                <div id="tab-radio-req" class="tabcontent"><!-- load content radio req -->

                </div>
                <div id="view4" class="tabcontent">

                    <a class="twitter-timeline" height="315" href="https://twitter.com/TMCPoldaMetro" data-widget-id="355034086387109888" data-chrome="noheader">Tweets by @TMCPoldaMetro</a>
                    <script>!function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + "://platform.twitter.com/widgets.js";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, "script", "twitter-wjs");</script>

                </div>


            </div>
            <!-- ----------------------------------------------- end tab content --------------------------------------- -->
        </div>
    </div>
    <div class="container-radio-station">
        <div class="container-content-blue" id="list-radio-container"><!-- load content radio station-->

        </div>
    </div>
<div style="width: 1140px; height: auto; text-align: center; font-size: 11px; margin-left: auto; margin-right: auto;">
        Disclaimer: As a directory and search service, Uzone/Suara Radio does not host and is not responsible for Contents accessed through its directory or search functionality. Contents are hosted and served by Radio Stations or Content Providers. The Radio Stations or Content Providers are solely responsible for their Contents, including, without limitation, obtaining all rights, licenses and royalties pertaining to their Contents.
</div>    

</div>

<script>
    var categoryId = 0;
    var genreId = 0;

    $(document).ready(function() {
        <?php if (!empty($_GET['search_podcast'])) { ?>
            //loadSearchPodcast();
        <?php } else { ?>
            loadGenre(1);
        <?php } ?>
        loadChartAttack();
        loadBestPodcast();
        loadRadioRequest();
        loadListRadioStation();


        $('#category li a').click(function() {
            $('div#rod-list-container').empty();
            loadGenre($(this).attr('data'));
        });
        
        
        $('#kategori-radio ul').on("click", "li", function() {
            //change active class
            $('#kategori-radio ul li').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
        
        $('#subcat-radio ul').on("click", "li", function() {
            //change active class
            $('#subcat-radio ul li').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
        
        $('select#cat-container').change(function() {
            $('div#rod-list-container').empty();
            $('div#search_podcast_container').hide();
            loadROD($(this).val());
            //change active class
            $('#cat-container option').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');

        });
    });
    
    function loadGenre(category) {

        //store active category
        categoryId = category;

        $('.loading-circle').show();

        $.post("<?php echo site_url('ajax/radio'); ?>", {func: 'get_sod_subcategory', categoryId: category}, function(result) {
            $('.loading-circle').hide();
            $('#cat-container').empty();

            var data = jQuery.parseJSON(result);

            if (data['found'] > 0) {
                
                for (var i in data['items']) {
                    if(i == 0) {
                        var s = "<li class='active'><a href='#' data='" + data['items'][i]['id'] + "' onclick='loadROD(" + data['items'][i]['id'] + ");' id='genre_" + data['items'][i]['id'] + "'>" + data['items'][i]['sub_category'] + "</a></li>";
                    } else {
                        var s = "<li><a href='#' data='" + data['items'][i]['id'] + "' onclick='loadROD(" + data['items'][i]['id'] + ");' id='genre_" + data['items'][i]['id'] + "'>" + data['items'][i]['sub_category'] + "</a></li>";
                    }
                    if (i == 0) {
                        loadROD(data['items'][i]['id']);
                    }

                    $('#cat-container').append(s);
                    
                }

                if ($('#cat-container option').length > 0) {
                    loadNewAlbum($('#cat-container').val(), 1);
                }
            } else {
                $('#cat-container option').append("<li>No data</li>");
            }

        });

    }

    function loadSearchPodcast() {
        $('.loading-circle').show();
        $('div#rod-list-container').load("<?php echo site_url('radio/channel/search_podcast'); ?>", function(result) {
            $('.loading-circle').hide();
        });

    }
    function loadROD(rodId) {
        $('div#rod-list-container').empty();
        $('.loading-circle').show();
        $('div#rod-list-container').load("<?php echo site_url('radio/channel/list_rod'); ?>", {rodId: rodId}, function(result) {
            $('.loading-circle').hide();
        });

    }

    function loadChartAttack() {
        $('.loading-circle').show();
        $('div#tab-chart-attack').load("<?php echo site_url('radio/channel/load_chart_attack'); ?>");
    }

    function loadBestPodcast() {
        $('.loading-circle').show();
        $('div#tab-best-podcast').load("<?php echo site_url('radio/channel/load_best_podcast'); ?>");
    }

    function loadRadioRequest() {
        $('.loading-circle').show();
        $('div#tab-radio-req').load("<?php echo site_url('radio/channel/load_radio_req'); ?>");
    }


    function loadListRadioStation() {
        $('div#list-radio-container').load("<?php echo site_url('radio/channel/load_radio_station'); ?>", function(result) {
            $('.myslider1').swipePlanes();
        });
    }

    function loadRODPlayer(rod_title, url_stream, photo) {        
        $('div#detail-player-container').show();

        if ($('div#player-container-rod').css('display') == 'none')
            $('div#player-container-rod').show();

        //Show song title 
        $('span#title_rod').text(rod_title);
        
        //change image radio if available
        $('img#image_player').attr("src", "<?php echo config_item('api_folder').'radio/'; ?>"+photo);

        var s = "<video class='mejs-wmp' width='300' height='300' src='" + url_stream + "' type='video/mp4' id='player1' poster='" + photo + "' controls='controls' preload='none'></video>";
        $('div#test-player').html(s);
        $('video').mediaelementplayer();
    }
</script>
