<?php 
function create_schedule_date($num_item, $current_timestamp=NULL){
    if (!$current_timestamp)
        $current_timestamp = time();
    
    if ($num_item<=0) $num_item = 1;
    
    $start_time = strtotime('-'.$num_item.' day', $current_timestamp);
    //get date for current time
    
    $s = '';
    for($i = $num_item; $i>=0; $i--){
        $new_time = strtotime('-'.$i.' day', $current_timestamp);
        
        $btn_class = $i==date('d', $new_time)?'btn-active':'';
        $s.= '<li>';
            $s.= '<a href="javascript:loadSchedule(null,null,'.$new_time.');" class="btn btn-danger '.$btn_class.'" id="btn_schedule_'. $new_time.'">';
                $s.= date('d M', $new_time);
            $s.= '</a>';
        $s.= '</li>';
    }
    
    return $s;
}
?>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />
<style>
    .btn { border: none; }
    div#schedule-container{float:left;margin-left:5px;width:100%; height:340px; display: none; }
    div#schedule-list-container{float:left;height:245px; width: 100%; overflow-y: auto; overflow-x: hidden;}
    #frame-play{float:left;}
    #schedule-list{ font-size:13px; }
    #schedule-list a{
		color:#4a4343;
    }
    #cat-list{ font-size:13px; }
    #cat-list a{
		color:#4a4343;
    }
    #tv-act {
        float:left;
    }
    #schedule-container #img {
        width:54px;
        float:left;
        margin-right:3px;
    }
    #schedule-container h4 {
        height:31px;
        padding-top:8px;
    }
	.date-schedule, .date-schedule ul{
		list-style-type:none;
		margin:0;
		padding:0;
	}
	.date-schedule li{
		display:inline;
		float:left;
		height:auto;
		margin:0px 3px;
	}
	.date-schedule li a{
		padding:5px 25px;
		-webkit-border-radius: 7px;
		-moz-border-radius: 7px;
		border-radius: 7px;
	}
        .date-schedule li a.btn-active {
            background-color: greenyellow;
        }
	.date-schedule li a:hover{
		text-decoration:none;
		background: rgb(0,110,46); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(0,110,46,1) 0%, rgba(0,110,46,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,110,46,1)), color-stop(100%,rgba(0,110,46,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006e2e', endColorstr='#006e2e',GradientType=0 ); /* IE6-9 */
	}

	.selected-date {
		background: rgb(0,110,46); /* Old browsers */
		background: -moz-linear-gradient(top,  rgba(0,110,46,1) 0%, rgba(0,110,46,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,110,46,1)), color-stop(100%,rgba(0,110,46,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom,  rgba(0,110,46,1) 0%,rgba(0,110,46,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006e2e', endColorstr='#006e2e',GradientType=0 ); /* IE6-9 */
	}
        
        /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float : left;
    }

    .well {
        background-color: rgb(255, 255, 255);
        padding-bottom: 20px;
    }
    #schedule-container .well-small {
        padding: 8px;
        padding-bottom: 15px;
    }
    .uz-main-container-down {
        width: 1155px;
        height: 200px;
        padding-left: 60px;
        float : left;
        margin-top: 10px;
    }
    .uz-title-container {
        width: auto;
        height: 20px;
        float : left;
    }
    
    .uz-container-1 {
        width: 400px;
        height: 340px;
        float : left;
    }
    .uz-container-1-content {
        width: 400px;
        height: 320px;
        float : left;
    }
    .uz-container-wrap {
        width: 30px;
        height: 340px;
        float : left;
    }
    
    .uz-show-all {
        width: 70px;
        height: 20px;
        float : right;
    }
    
    .uz-show-all a {
        color : #d31821;
        text-decoration: none;
    }
    .uz-show-all a:hover {
        color : #d31821;
        text-decoration: underline;
    }
    .uz-container-2 {
        width: 317px;
        height: 340px;
        float : left;
    }
    .uz-container-2-content {
        width: 317px;
        height: 320px;
        float : left;
    }
    
    .uz-thumb-big {
        width : 236px;
        height: 314px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-thumb-big img {
        width : 236px;
        height: 314px;
    }
    .uz-thumb-small {
        width : 156px;
        height: 156px;
        float : left;
        border : 1px solid #fff;
        background: #000;
    }
    .uz-thumb-small img {
        width : 156px;
        height: 117px;
        margin-top: 20px;
    }
    .tv-banner-container {
        width: 400px;
        height: 315px;
    }
    .tv-banner-container img {
        width: 400px;
        height: 315px;
    }
    
	.myslider1 {
        width: 100%;
        height: 112px;
        border: 1px solid rgb(217, 217, 217);
        border-radius: 10px 10px 10px 10px;
        float: left;


        padding-top: 5px;
        margin-bottom: 20px;
        padding-bottom: 11px;
    }

    .myslider1 img {
        height: 108px;
        max-width: 108px;
        vertical-align: middle;
        border: 0px none;
    }

    .container-item {
        width: 108px;
        min-height: 112px;
        float: left;
        margin-right: 5px;
        margin-left: 10px;
        margin-bottom: 0px;
        text-align: center;
        font-weight: bold;
    }

	#myslider-content {
		margin-top:5px;
		margin-left:5px;
	}
    #sch_prog {display: none;}
    #sch_by_cat {display: none;}
    #tv-player {display: none;}
</style>
<!-- slide panel item removed -->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>


<div class="uz-main-container-up">
    <div class="uz-container-1">
        <div id="banner-tv">
            <div class="uz-title-container">&nbsp;</div>
            <div class="tv-banner-container">
                <img src="<?php echo config_item('image_url'); ?>channel/tv/banner_tv.jpg">
            </div>
        </div>
        <div id="tv-player">
            <div class="uz-title-container" id="title_play">TV Player</div>
            <div name="frame-play" id="frame-play" class='hide' style='width:400px; height:320px; overflow:hidden;'></div>
        </div>
    </div>
    <div class="uz-container-wrap"></div>
    <div class="uz-container-2">
        <div class="uz-title-container">Most Popular Program</div><div class="uz-show-all"><a href="javascript:showAllMost();">Show All</a></div>
        <div class="uz-container-2-content" id="most-click">
            <?php 
            $no =1;
            foreach ($most_popular as $most_popular):?>
            <a href='javascript:playTVStream("<?php echo $most_popular->stream_url;?>","<?php echo $most_popular->thumbnail;?>","<?php echo $most_popular->channel;?>");' title='<?php echo $most_popular->channel;?>'  data='<?php echo $most_popular->channel;?>'>
                <div class='uz-thumb-small'>
                    <img src='<?php echo base64_decode($most_popular->thumbnail);?>'></div>
            </a>
            <?php 
            if($no == 4) break;
            $no++;
            endforeach;
            ?>
        </div>
    </div>
    <div class="uz-container-wrap"></div>
    
    <div class="uz-container-2" id="sch_by_cat">
        <div class="uz-title-container" id='cat-schedule'></div>
        <div class="uz-container-2-content" style="width:379px;">
            <div class="hide" id='schedule'>
                <div id='act'>
                    <div id='img_cat' style="float:left;margin-right:5px;"></div>
                    <h4 class="well well-small">
                        <div class="scedule-operation">
                            <ul class="date-schedule">
                                <?php echo create_schedule_date(2);?>
                            </ul>
                        </div>
                    </h4>
                </div>
                <div id="schedule-list-container">
                    <div id="cat-list">
                        <table class="table table-striped" style="width:100%;" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>TV</th>
                                    <th>Time</th>
                                    <th>Programs</th>
                                </tr>
                            </thead>
                            <tbody id='tvcatdata'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="uz-main-container-down">
    <div class="uz-title-container" id="all-title"></div>
    <div id="myslider1" class="myslider1">
        <div id="myslider-content"><!-- content will be fill by ajax call --></div>
    </div>
</div>
<div id='form-player'></div>
<script src="<?php echo config_item('assets_url'). 'js/jwplugin.js';?>"></script>
<script>
    $('.myslider1').swipePlanes();
    
    //Set default category to be activated on page load
    var current_category_name = 'All Schedule';
    var current_category_id = 0;
    var current_tvcode = null;
    
    var unixtime = '<?php echo time(); ?>';
    
    var date = new Date();
    var current_date_num = unixtime;
    
    var loadScheduleOnload = true;
    
    $(document).ready(function() {
        $('#sch_by_cat').show();
        $('#sch_prog').hide();
        
        //Load station in bottom list
        
        loadSliderStation(loadScheduleOnload);
        
        //Load schedule from default category
        //loadSchedule(current_category_id, current_category_name, current_date_num, current_tvcode);
        
        
        $('#byfeature li a').click(function() {
            $('#sch_by_cat').show();
            $('#sch_prog').hide();
            var category = $(this).attr('data');
            var cat_name = $(this).attr('value');
            current_category_id = category;
            current_category_name = cat_name;
            current_tvcode = null;
                        
            if(cat_name!=="" && category !==""){
                loadSchedule(current_category_id, current_category_name, current_date_num, current_tvcode);
            }
        });
        
        $('img').error(function (){
            $(this).attr('src','<?php echo config_item('image_url').'channel/tv/banner_tv.jpg' ?>');
        });

    });
       
    function loadSliderStation(loadScheduleAuto){
        if (typeof loadScheduleAuto==='undefined' || loadScheduleAuto==true){
            current_category_id = 0;
            current_category_name = 'All Schedule';
            current_tvcode = null;
            
            loadSchedule(current_category_id, current_category_name, current_date_num, current_tvcode);
        }
        $('#myslider-content').empty();
        
        $.post("<?php echo site_url('ajax/tv');?>",{func:'get_station',limit:30},function(result){
            $('#myslider-content').show();
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                for (var i in data['items']){
                    
                    var d = data['items'][i];
                    var s = "";
                    s+= "<div class='slide container-item'>";
                    s+= "<a class='album-name' href='javascript:playTVStream(\""+d['live_stream']+"\",\""+d['small_logo1']+"\",\"Live Streaming > "+d['tv_code']+"\",\""+d['tv_code']+"\");loadSchedule(-1, null,0, \""+d['tv_code']+"\");'>";
                    s+= "<img src='"+ _get_file(d['small_logo1'])+"' class='rounded' width='150' />";
                    s+= "</a>";
                    s+= "</div>";

                    $('#myslider-content').append(s);
                    $('#all-title').html('Live TV');
                }
                
            }else{
                $('#myslider-content').html("<?php echo config_item('text_nodata'); ?>");
            }
            $('.myslider1').swipePlanes();
            
            $('img').error(function (){
                $(this).attr('src','<?php echo config_item('image_url').'channel/tv/banner_tv.jpg' ?>');
            });
        });
    }
    
    function loadSchedule(categoryId, categoryName, cdate, tvcode){
        
        
        //if categoryId and categoryName is NULL
        if (categoryId===null)
            categoryId = current_category_id;
        else
            current_category_id = categoryId;
        if (categoryName===null)
            categoryName = current_category_name;
        else
            current_category_name = categoryName;
        
        if (parseInt(current_category_id)<0){
            categoryName = 'All Schedule';
        }
        if(tvcode===undefined)
            tvcode = current_tvcode;
        else
            current_tvcode = tvcode;
        
        if (parseInt(cdate)<=0){
            if (current_date_num > 0)
                cdate = current_date_num;
            else
                cdate = '<?php echo time();?>';
        }
        
        current_date_num = parseInt(cdate);
        
        //set active tab button
        activateTabSchedule(current_date_num);
        
        //alert(categoryId+','+categoryName+','+cdate+','+tvcode);
        
        $('#cat-schedule').empty();
        $('#cat-schedule').append('<div class="uz-title-container" id="cat-schedule"> ' + categoryName + '</div>'); /* 8/15/2013 by Bagus */
        $('#schedule table tbody').empty();
        
        $.post("<?php echo site_url('ajax/tv'); ?>", {func: 'get_schedule', category:categoryId, date:cdate, tvcode:tvcode}, function(result) {
            $('.ajax_loader').hide();
            $('#tvcatdata').empty();
            //$('#img_cat').empty();
            var data = jQuery.parseJSON(result);
            if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var tvcode = d['tvcode'];
                    var tvimg_small = d['small_logo1'];
                    var acara = d['acara'];
                    var jam = d['jam'];
                    var tvod_stream = d['tvod_stream'];
                    var id = d['id'];
                    
                    var s = '';
                    s += '<tr>';
                        s+= '<td><img width="24" height="24" src="' + _get_file(tvimg_small) + '"></td>';
                        s+= '<td>' + jam + '</td>';
                        s+= '<td><a href="javascript:playTVStream(\'' + tvod_stream + '\',\'' + tvimg_small + '\',\'' + acara + '\');">' + acara + '</a></td>';
                    s+= '</tr>';
                    
                    $('#tvcatdata').append(s);
                }
            } else {
		$('#tvcatdata').append("<tr><td><?php echo config_item('text_nodata');?></td></tr>");
            }
            $('#schedule').show();
	});
    }
    
    function activateTabSchedule(cdate){
        $('ul.date-schedule li').each(function(){
            var btn =$(this).find('a');
            if (btn.attr('id')!='btn_schedule_'+cdate){
                btn.removeClass('btn-active');
            }else{
                btn.addClass('btn-active');
            }
        });
    }
    
    /****************** FUNCTION FOR MOST POPULAR *****************************/
    function showAllMost(){
        
        $.post("<?php echo site_url('ajax/tv');?>",{func:'get_most_popular',offset:4,limit:20},function(result){
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                loadMostPopularBottom(data);
                loadTitleBottom('All Most Popular Program');
            }
        });   

    }

    function loadMostPopularBottom(data){
        $('#myslider-content').empty();
        for (var i in data['items']){
            var d = data['items'][i];
            var link_stream = d['stream_url'];
            var pic = d['thumbnail'];
            var s = "";
                s+= "<div class='slide container-item'>";
                s+= "<a href='javascript:playTVStream(\""+link_stream+"\",\""+pic+"\",\""+d['name']+"\");'>";
                s+= "<img src='"+_get_file(pic)+"' class='rounded' width='150' />";
                s+= "</a>";
                s+= "</div>";

            $('#myslider-content').append(s);
            
        }
        $('#all-title').html('All Most Popular');
        
        $('img').error(function (){
            $(this).attr('src','<?php echo config_item('image_url').'channel/tv/banner_tv.jpg' ?>');
        });
        
        $('.myslider1').swipePlanes();        
    }
    
    
    /**************************** FUNCTION TO PLAY VIDEO IN DESKTOP AND MOBILE *******************************/
    
    function playTVStream(rtmp, poster, title, tvcode){
        /*
        if (tvcode !== undefined){
            current_tvcode = tvcode;
            loadSchedule(null, null, date.getDate(), tvcode);
        }*/
        $('#img_cat').html('<img class="img-rounded" src="'+ _get_file(poster) + '" width="50px" />');
        $('#title_play').html(capitaliseFirstLetter(title));
        play(400, 315, rtmp, poster);
    }
    
    function play(width, height, rtmp, poster) {
        $('#banner-tv').hide();
        $('#tv-player').show();
        $('#frame-play').attr('width', width);
        $('#frame-play').attr('height', height);
        
        var is_desktop = parseInt("<?php echo $IS_DESKTOP;?>");
        var is_mobile = parseInt("<?php echo $IS_MOBILE;?>");
        
        if (poster === undefined) 
            poster = '<?php echo config_item('image_url').'channel/tv/banner_tv.jpg' ?>';
        else
            poster = _get_file(poster);
            
        if (is_mobile===1){
            setup_html5_video('frame-play', poster, _get_file(rtmp), width, height);
        }else{
            setup_jw_player('frame-play', poster, _get_file(rtmp), width, height);
        }
        $('#frame-play').show();
    }
    
    function setup_jw_player(target, poster, url, width, height){
        var container = document.getElementById(target);
        container.innerHTML= '';
        
        jwplayer(target).setup({
            file: url,
            image: poster,
            autostart: true,
            'modes': [
                {type: 'flash', src: "jwplayer.flash.swf"},
                {type: 'html5'}
            ],
            height: height,
            width: width
        });
    }
    
    function setup_html5_video(target, poster, url, width, height){
        var container = document.getElementById(target);
        //empty inside element
        container.innerHTML = "";
        
        var video = document.createElement('video');
        video.class = 'mejs-wmp';
        video.width = width;
        video.height = height;        
        video.id = 'video-player';
        video.poster = poster;
        video.controls = 'controls';
        video.preload = 'none';
        
        container.appendChild(video);
        
        //append source
        var sources = [
            {
                source: url,
                type: 'video/mp4'
            },
            {
                source: url,
                type: 'video/webm'
            },
            {
                source: url,
                type: 'video/ogv'
            }
        ];
        for (var i in sources){
            var source = document.createElement('source');
            
            source.src = sources[i]['source'];
            source.type = sources[i]['type'];

            video.appendChild(source);
        }
        
        
        //reload the video and play
        video.load();
        video.play();
    }    
</script>
