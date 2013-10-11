<style>
    /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float : left;
        clear:both;
    }
    .uz-main-container-down {
        width: 1156px;
        height: 200px;
        padding-left: 60px;
        float : left;
        margin-top: 20px;
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
        /*border : 1px solid #000;*/
    }
    .uz-container-wrap {
        width: 60px;
        height: 340px;
        float : left;
    }
    .uz-container-2 {
        width: 320px;
        height: 340px;
        float : left;
        /*border : 1px solid #000;*/
    }
    .uz-container-2-content {
        width: 320px;
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
    }
    .uz-thumb-small img {
        width : 156px;
        height: 156px;
    }
    .mob-uz-thumb-big {
        width : 236px;
        max-height: 314px;
        float : left;
        border : 1px solid #fff;
    }
    .mob-uz-thumb-big img {
        width : 236px;
        max-height: 314px;
        padding-top: 39px;
        padding-bottom: 39px;
        background-color: #CFCFCF;
    }
    .apps-uz-thumb-small {
        border: solid 1px #999999;
        width : 153px;
        height: 153px;
        float : left;
    }
    .apps-uz-thumb-small img {
        float: none;
        padding-left: 13px;
        padding-top: 12px;
        min-width : 30px;
        height: 130px;
    }
    .pc-uz-thumb-small {
        width : auto;
        height: 139px;
        float : left;
        padding-top: 9px;
        padding-bottom: 9px;
        border : solid 1px #FFFFFF;
    }
    .pc-uz-thumb-small img {
        width : 104px;
        height: 139px;
    }
    .mob-uz-thumb-small {
        width : auto;
        height: 104px;
        float : left;
        border : solid 1px #FFFFFF;
    }
    .mob-uz-thumb-small img {
        width : auto;
        height: 102px;
    }
    .mob-container-slide{
        width: 104px;
        height: 100px;
    }
    .mob-container-slide img{
        width: 100px;
        height: 100px;
        vertical-align:middle;
    }
    .pc-container-slide{
        width: 80px;
        height: 100px;
    }
    .pc-container-slide img{
        width: 75px;
        height: 100px;
        vertical-align:middle;
    }
    .pict1{
        float: left;
    }
    .pict1 img{
        width: auto;
        height: 190px;
        background-color: #000000;
        float: left;
    }
    .text2{
        width: 400px;
        height: 100px;
        padding-top: 10px;
        float: left;
    }

    .uz-main-container-down .myslider1 {
        width: 100%;
        height: 108px;
        border: 1px solid rgb(217, 217, 217);
        border-radius: 10px 10px 10px 10px;
        float: left;
        padding-top: 7px;
        margin-bottom: 20px;
    }

    .uz-main-container-down #myslider-content {
        float: left;
        min-width: 100%;
        width: auto;
    }

    .uz-main-container-down .uz-title-container {
        width: 380px;
        height: 20px;
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
    .uz-title-container{
        width: 280px;
        height: 20px;
        float: left;
    }
    .uz-title-container a {
        color: #d31821;
        text-decoration: none;
        float: right;
    }
    .uz-title-container a:hover {
        color: #d31821;
        text-decoration: underline;
    }

</style>
<style>
.full-star, .half-star, .empty-star{width: 24px; height:28px;display: inline-block;}
.full-star{background: url('<?php echo config_item("assets_url"); ?>img/star/Full-Star.png') no-repeat;}
.half-star{background: url('<?php echo config_item("assets_url"); ?>img/star/Half-Star.png') no-repeat;}
.empty-star{background: url('<?php echo config_item("assets_url"); ?>img/star/Zero-Star.png') no-repeat;}
.full-star-small, .half-star-small, .empty-star-small{width: 18px; height:18px;display: inline-block;}
.full-star-small{background: url('<?php echo config_item("assets_url"); ?>img/star/Full-Star-small.png') no-repeat;}
.half-star-small{background: url('<?php echo config_item("assets_url"); ?>img/star/Half-Star-small.png') no-repeat;}
.empty-star-small{background: url('<?php echo config_item("assets_url"); ?>img/star/Zero-Star-small.png') no-repeat;}

</style>
<!-- slide panel item-->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />

<div class="uz-main-container-up">
    
    <div class="uz-container-1">
        <div class='uz-title-container' id='apptitle'>

        </div>
    	<div class='uz-container-1-content' id='img-list'>

        </div>
    </div>

    <div class="uz-container-wrap"></div>

    <div class="uz-container-2">
        <div class="uz-title-container">Top Mobile Content<a href="javascript:showAllTopDownMob();">Show All</a></div>
        <div class="uz-container-2-content" id="top-mob-content">
            
        </div>
    </div>

    <div class="uz-container-wrap"></div>

    <div class="uz-container-2">
        <div class="uz-title-container">Top PC Content<a href="javascript:showAllTopDownPc();">Show All</a></div>
        <div class="uz-container-2-content" id="top-web-content">
            
        </div>
    </div>
</div>
<div class="uz-main-container-down" id="myslider-main">
<div class='uz-title-container' id="title-slider"></div>
    <div id='myslider1' class='myslider1'>
        <div id='myslider-content'>
        </div>
    </div>
</div>
<style>
    span.loader{float:left;margin-left:5px;padding:0;}
    .album-new{min-height: 200px;}
    .ajax_loader_bar1 {display : none;}
    .ajax_loader_bar2 {display : none;}
    #list {display : none;}
</style>

<script>
    var PC=1;
    var MOB=2;

    $(document).ready(function(){
        if (window.location.hash){
            var hash = window.location.hash;
            hash=hash.split('/');
        } else {
            hash = "";
        }
        loadTopDownMob();
        loadTopDownPC();
        loadSubCat();
        $('#device li a').click(function(){
            loadSubCat($(this).attr('data'));
        });
        if(hash != ""){
            $("#ddsubcat li a[data='"+hash[2]+"']").click();
            if (hash[1] == PC) {
                loadItemsPC(hash[2]);
            } else {
                loadItemsMob(hash[2]);   
            }
        } else {
            loadItemsMob(3);
        }
        
        $('#ddcat ul').on("click", "li", function() {

            //change active class
            $('#ddcat ul li').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
        
        $('#ddsubcat ul').on("click", "li", function() {

            //change active class
            $('#ddsubcat ul li').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });  
    });
var img_url="<?php echo config_item('api_sync').'apps/'; ?>";

    function loadTopDownMob(){
        $.post("<?php echo base_url('ajax/apps') ?>",{func:'top_download_mob',offset:0,limit:9},function(data){
        $('#top-mob-content').empty();
        if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var package_name = d['package_name'];
                    var s = "<a data='"+d['package_id']+"' title='"+package_name+"' style='background-color:#FFFFFF;' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                    s += "<div class='mob-uz-thumb-small'>";
                    s += "<img src='" + img_url+ d['icon_url'] + "' />";
                    s+= "</div></a>";

                    $('div#top-mob-content').append(s);
                }
                
            } else {
                $('div#top-mob-content').html("<p><?php echo config_item('text_nodata'); ?></p>");
            }
        },'json');
    }

    function showAllTopDownMob(){
        var usedId = [];
        var parent_id = 2;
        var title = 'Top Mobile Content';

        $('div#top-mob-content a').each(function(){
            usedId.push($(this).attr('data'));
        });

        $.post("<?php echo site_url('ajax/apps');?>",{func:'get_topmob',limit:30},function(result){
            $('#top-mob-content').show();
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                loadAppsBottom(data, usedId, parent_id, title);
            }
        });   
    }

    function showAllTopDownPc(){
        var usedId = [];
        var parent_id = 1;
        var title = 'All Top PC Content';

        $('div#top-web-content a').each(function(){
            usedId.push($(this).attr('data'));
        });

        $.post("<?php echo site_url('ajax/apps');?>",{func:'get_toppc',limit:30},function(result){
            $('#top-web-content').show();
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                loadAppsBottom(data, usedId, parent_id, title);
                // loadTitleBottom('New Release');
            }
        });   
    }

    function loadTopDownPC(){
        $.post("<?php echo base_url('ajax/apps') ?>",{func:'top_download_web',offset:0,limit:6},function(data){
        $('#top-web-content').empty(); 
        if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var package_name = d['package_name'];

                    var s = "<a title='"+package_name+"' style='background-color:#FFFFFF;' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                    s += "<div class='pc-uz-thumb-small'>";
                    s += "<center><img src='" + img_url+ d['icon_url'] + "' /></center>";
                    s += "</div></a>";

                    $('div#top-web-content').append(s);
                }
                
            } else {
                $('div#top-web-content').html("<p><?php echo config_item('text_nodata'); ?></p>");
            }
        },'json');
    }

    function loadAppsBottom(data, usedId, parent_id, title){
        $('#myslider-content').empty();
        $('#myslider-main .uz-title-container').empty();
        $('#myslider-main .uz-title-container').append(title);
        for (var i in data['items']){
            var d = data['items'][i];
            if (usedId.indexOf(d['package_id'])<0){
                var appsName = d['package_name'];
                var s = "";
                s+= "<div class='mob-container-slide' style='display: inline-block; float: left; position: relative;'>";
                s+= "<a style='background-color:#FFFFFF' class='tile square image mob-uz-slider' title='"+appsName+"' href='<?php echo base_url();?>apps/detail/apps/"+parent_id+"/"+d['package_id']+"' title='" +d['package_name']+"''>";
                s+= "<img class='rounded' src='"+ img_url+d['icon_url']+"'/>";
                s+= "</a>";
                s+= "</div>";

                $('#myslider-content').append(s);
            }
            $('#myslider1').swipePlanes();
        }
    }

    function loadItemsMob(category_id){
        var parent_id = 2;
        var parent = "Mobile";

        $('div#img-list').empty();
        $('div#apptitle').empty();
        $('#title-slider').empty();

        $.post("<?php echo base_url('ajax/apps') ?>",{func:'category_items',parent_id:parent_id,category_id:category_id,offset:0,limit:0},function(data){
            $('div#apptitle').append(parent+" > "+data['cat_name']['category_name']);

            $('#title-slider').append("All "+parent+" > "+data['cat_name']['category_name']);

            if (data['found'] > 0) {
				$('#myslider1 div').each(function() {
				    if ($(this).attr('id') !== 'myslider-content')
				    $(this).remove();
				});
                for (var i in data['items']) {
                    var s = "";
                    var d = data['items'][i];
                    var package_name = d['package_name'];
                    var link = "<a title='"+package_name+"' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                        if (i == 0){
                            var rate = "";
                            var rat=parseInt(d['rating']);

                            for(var j=1;j<=5;j++){
                                if(rat%2==1 && Math.round(rat/2)==j) rate +="<span class='half-star-small'></span>";
                                else if(Math.round(rat/2)>=j || Math.round(rat/2)==j) rate +="<span class='full-star-small'></span>";
                                else rate +="<span class='empty-star-small'></span>";
                            }
                            
                            if (d['description'].length<=100) {
                                var readmore = "<a title='"+package_name+"' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>Show</a>";
                                var description = d['description'].replace('<p>','').replace('</p>','')+" "+readmore;
                            } else {
                                var readmore = "<a title='"+package_name+"' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>Read More</a>";
                                var description = d['description'].replace('<p>','').replace('</p>','').substring(0,90)+"..."+readmore;
                            }

                            //check width + height image
                            var img = new Image();
                            img.src = img_url+d['icon_url'];
                            img.onload = function(){
                                calculateBigImage(this.width, this.height);
                            }

                            s += "<div class='pict1'>";
                            s += "<img src='"+ img_url+d['icon_url']+"'></img>";
                            s += "</div>";
                            s += "<div class='text2'>";
                            s += "<p><b>Rating: </b>"+rate+"</p>";
                            s += "<p><b>Description: </b></p>"
                            s += "<p>"+description+"</p>";
                            s += "</div>";
                            //s += "</div>";
                            $('div#img-list').append(s);
                        } else {
                            var s = "<div class='mob-container-slide'>";
                            s += "<a title='"+package_name+"' class='tile square image mob-uz-slider' style='background-color:#FFFFFF;' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                            s += "<img src='" + img_url + d['icon_url'] + "' class='rounded' />";
                            s += "</a>"; 

                            $('#myslider-content').append(s);   
                        }
                    }
                $('#myslider-content').width(calculate_width('.container-item'));
                var foot = "</div></div>";
                $('#myslider-main').append(foot);
            } else {
                $('div#img-list').html("<p style='color:#666;'><?php echo config_item('text_nodata'); ?></p>");
            }
            $('#myslider1').swipePlanes();
        },'json');
    }

    function loadItemsPC(category_id){
        var parent_id = 1;
        var parent = "PC";

        $('div#apptitle').empty();
        $('div#img-list').empty();
        $('#title-slider').empty();

        $.post("<?php echo base_url('ajax/apps') ?>",{func:'category_items',parent_id:parent_id,category_id:category_id,offset:0,limit:0},function(data){
            $('div#apptitle').append(parent+" > "+data['cat_name']['category_name']);
            $('#title-slider').append("All "+parent+" > "+data['cat_name']['category_name']);
			
            if (data['found'] > 0) {
				$('#myslider1 div').each(function() {
				    if ($(this).attr('id') !== 'myslider-content')
				    $(this).remove();
				});            
                for (var i in data['items']) {
                    var s = "";
                    var d = data['items'][i];
                    var package_name = d['package_name'];
                    var link = "<a title='"+package_name+"' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                        if (i == 0){
                            var rate = "";
                            var rat=parseInt(d['rating']);
                            for(var j=1;j<=5;j++){
                                if(rat%2==1 && Math.round(rat/2)==j) rate +="<span class='half-star-small'></span>";
                                else if(Math.round(rat/2)>=j || Math.round(rat/2)==j) rate +="<span class='full-star-small'></span>";
                                else rate +="<span class='empty-star-small'></span>";
                            }
                            if (d['description'].length<=100) {
                                var readmore = "<a title='"+package_name+"' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>Show</a>";
                                var description = d['description'].replace('<p>','').replace('</p>','')+" "+readmore;
                            } else {
                                var readmore = "<a title='"+package_name+"' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>Read More</a>";
                                var description = d['description'].replace('<p>','').replace('</p>','').substring(0,90)+"..."+readmore;
                            }

                            //check width + height image
                            var img = new Image();
                            img.src = img_url+d['icon_url'];
                            img.onload = function(){
                                calculateBigImage(this.width, this.height);
                            }

                            s += "<div class='pict1'>";
                            s += "<img src='"+ img_url + d['icon_url']+"'></img>";
                            s += "</div>";
                            s += "<div class='text2'>";
                            s += "<p><b>Rating: </b>"+rate+"</p>";
                            s += "<p><b>Description: </b></p>"
                            s += "<p>"+description+"</p>";
                            s += "</div>";
                            $('div#img-list').append(s);
                        } else {
                            var s = "<div class='pc-container-slide'>";
                            s += "<a title='"+package_name+"' class='tile square image pc-uz-slider' style='background-color:#FFFFFF;' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                            s += "<img src='" + img_url + d['icon_url'] + "' class='rounded'/>";
                            s += "</a>"; 

                            $('#myslider-content').append(s);   
                        }
                    }
                $('#myslider-content').width(calculate_width('.container-item'));
                var foot = "</div></div>";
                $('#myslider-main').append(foot);
            } else {
                $('#img-list').html("<p style='color:#666;'><?php echo config_item('text_nodata'); ?></p>");
            }
            $('#myslider1').swipePlanes();
        },'json');
    }

    function calculateBigImage(width, height){
        var scale = height/190;
        var width = Math.ceil(width/scale);
        var pad_left = Math.ceil((400-width)/2);
        $('.pict1').width(width);
        $('.pict1').height('190px');
        $('.pict1 img').css('padding-left', pad_left+'px');
        $('.pict1 img').css('padding-right', pad_left+'px');
    }

    function loadSubCat(parent_id){
        
        $('#loader-subcat').show();        
        
        $.post("<?php echo base_url('ajax/apps');?>",{func:'category_list',parent_id:parent_id},function(result){
        
            $('#cat-container').empty();
            
            var data = jQuery.parseJSON(result);
            if (data['found']>0){
                for (var i in data['items']){
                    var d = data['items'][i];
                    
                    var sub = d['category_name'].substring(0,20);
                    if (parent_id == PC) {
                        var s = "<li><a href='#' onclick='loadItemsPC("+d['category_id']+");' data='"+d['category_id']+"' title='"+d['category_name']+"' onclick='loadItemsPC("+d['category_id']+")'>"+sub+"</li>";
                       
                    } else {
                        var s = "<li><a href='#' onclick='loadItemsMob("+d['category_id']+");' data='"+d['category_id']+"' title='"+d['category_name']+"' onclick='loadItemsMob("+d['category_id']+")'>"+sub+"</li>";
                        
                    }

                    $('#cat-container').append(s);
                }
                
            }

            $('#loader-subcat').hide();
        });
    }

    function calculate_width(item_class){
        var w = 0;
        $(item_class).each(function(){
            w+= parseInt($(this).width());
        });

        return w;
    }
</script>