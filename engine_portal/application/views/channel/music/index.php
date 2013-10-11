<style>
    /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float : left;
    }
    .uz-main-container-down {
        width: 1155px;
        height: 200px;
        padding-left: 60px;
        float : left;
        margin-top: 10px;
    }
    .uz-title-container {
        width: 250px;
        height: 20px;
        float : left;
        white-space:nowrap; 
        overflow:hidden; 
        text-overflow:ellipsis;
    }

    .uz-title-container-all {
        width: auto;
        height: 20px;
        float : left;
        white-space:nowrap; 
        overflow:hidden; 
        text-overflow:ellipsis;
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
        width: 60px;
        height: 340px;
        float : left;
    }
    
    .uz-container-2 {
        width: 320px;
        height: 340px;
        float : left;
    }
    .uz-container-2-content {
        width: 320px;
        height: 320px;
        float : left;
    }
    
    .uz-thumb-big {
        width : 236px;
        height: 274px;
        float : left;
        border : 1px solid #fff;
		background: #000 url(<?php echo config_item('assets_url'); ?>css/img/ajax-loader.gif);
		background-position: center center;
		background-repeat: no-repeat;
		padding-top : 40px;
        
        
    }
    .uz-thumb-big img {
        width : 236px;
        height: auto;
    }
    .uz-thumb-small {
        width : 156px;
        height: 156px;
        float : left;
        border : 1px solid #fff;
        background: url(<?php echo config_item('assets_url'); ?>css/img/ajax-loader.gif);
        background-position: center center;
        background-repeat: no-repeat;
    }
    .uz-thumb-small img {
        width : 156px;
        height: 156px;
    }
    .slide1.container-item {
        background: url(<?php echo config_item('assets_url'); ?>css/img/ajax-loader.gif);
        background-position: center center;
        background-repeat: no-repeat;
    }
</style>
<!-- slide panel item-->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />


<div class="uz-main-container-up">
    
    <div class="uz-container-1" id="img-list">
        
    </div>
    <div class="uz-container-wrap"></div>
    <div class="uz-container-2">
        <div class="uz-title-container" id="most-click-songs">Most Click</div><div class="uz-show-all" id="link_sa_mc">Show All</div> <!-- 05/08/2013 by Alex -->
        <div class="uz-container-2-content" id="most-click">	
        </div>
    </div>
    <div class="uz-container-wrap"></div>
    
    <div class="uz-container-2">
        <div class="uz-title-container" id="title-all-coll">All Collection</div><div class="uz-show-all" id="link_sa_ac">Show All</div>
        <div class="uz-container-2-content" id="allcol-list">
        </div>
    </div>
</div>
<div class="uz-main-container-down">
	<div class="uz-title-container-all" id="all-release"></div> <!-- 05/08/2013 by Alex -->
    <div id="myslider1" class="myslider1">
        <div id="myslider-content">
           
        </div>
    </div>
</div>
         
<script>
    var img_url = '<?php echo config_item('api_sync').'music/'; ?>';
    
    $(document).ready(function() {
        if (window.location.hash){
            var hash = window.location.hash;
            hash=hash.split('/');
        } else {
            hash = "";
        }
        
        $('#category li a').click(function(){
            loadGenre($(this).attr('data'),$(this).html());
        });
            
        if(hash != ""){
            loadGenre(hash[1],hash[2]);
        } else {
            loadGenre(10, 'Indonesia');
        }

        $('#kategori-musik ul').on("click", "li", function() {
            //change active class
            $('#kategori-musik ul li').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
        
        $('#subkategori-musik ul').on("click", "li", function() {
            //change active class
            $('#subkategori-musik ul li').each(function() {
                $(this).removeClass('active');
            });
        
            $(this).addClass('active');
        });

       
    });
        
    function loadGenre(category, title) {
        //store active category
        categoryId = category;
        $('.ajax_loader').show();
        $('div#landing-page-music').show();
        $('div#detail-album-frame').hide();
        $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_genre_by_category', categoryId: category}, function(result) {
            $('.ajax_loader').hide();
            $('#cat-container').empty();

            var data = jQuery.parseJSON(result);
            if (data['found'] > 0) {
                for (var i in data['items']) {
                    if(i == 0){
                        loadNewAlbum(data['items'][i]['genreId'],0,title, data['items'][i]['genreName']); /* 05/08/2013 by Alex */
                        var s = "<li><a href='#' onclick='loadNewAlbum(" + data['items'][i]['genreId'] + ",1,\""+title+"\",\""+data['items'][i]['genreName']+"\");' data='" + data['items'][i]['genreId'] + "' id='genre_" + data['items'][i]['genreId'] + "' >" + data['items'][i]['genreName'] + "</option>";
                    } else {
                        var s = "<li><a href='#' onclick='loadNewAlbum(" + data['items'][i]['genreId'] + ",1,\""+title+"\",\""+data['items'][i]['genreName']+"\");' data='" + data['items'][i]['genreId'] + "' id='genre_" + data['items'][i]['genreId'] + "' >" + data['items'][i]['genreName'] + "</option>";
                    }
                            
                    $('#title-cat-album').text($('#cat-container option:selected').text());
                    $('#cat-container').append(s);

                }
            } else {
                $('#cat-container option').append("<li><?php echo config_item('text_nodata'); ?></li>");
            }

        });

    }

    function loadNewAlbum(genre, offset, category, subcat) {
        
        //update selected category title
        $('span#selected-category').text($('option#genre_' + genre).text());

        //refresh container slider
        $('#myslider1 div').each(function() {
            if ($(this).attr('id') !== 'myslider-content')
                $(this).remove();
        });

        showAllCollection(genre, category, subcat); /* 06/08/2013 by Alex */
        loadHotAlbum(genre, category, subcat); /* 06/08/2013 by Alex */
        
        if(subcat === ''){ /* 05/08/2013 by Alex */
            var subcats = '';
        }else{
            var subcats = ' > ' + subcat;
        }

        $('.ajax_loader').show();

        $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_new_album', genreId: genre, offset:0, limit: 3}, function(result) {
            $('.title-new').text(category);
            $('.ajax_loader').hide();
            $('#myslider-content').empty();
            $('#img-list').empty();
            $('#img-list').append('<div class="uz-title-container">New Release > ' + category + ' ' + subcats + '</div><div class="uz-show-all"><a href="javascript:showall_new_release('+genre+',7,\'' + category + '\',\'' + subcats + '\');">Show All</a></div>'); /* 05/08/2013 by Alex */
            var data = jQuery.parseJSON(result);
                
            if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var albumName = d['albumName'];
                    var js = "<?php echo  base_url(); ?>music/detail/album/" + d['albumId'] + "";
                    var s = "<a title='" + albumName + "' href='" + js + "'>";
                    
                    if(i == 0){
                        s += '<div class="uz-thumb-big">';
                    } else {
                        s += '<div class="uz-thumb-small">';
                    }
                    s += '<img src="' + img_url + d['albumLImgPath'] + '" /></a>';
                    s += '</div>';
                    
                    $('#img-list').append(s);
                }
                
                $('#myslider-content').width(calculate_width('.container-item'));
            } else {
                $('#myslider-content').html("<?php echo config_item('text_nodata'); ?>");
            }
                
            $('#myslider1').swipePlanes();
            
            $('#all-release').empty();  /* 05/08/2013 by Alex */
            $('#all-release').append('<div class="uz-title-container-all" id="all-release">All New Release > ' + category + ' ' + subcats + '</div>');

        });
            
        $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_new_album',genreId:genre,offset:7,limit: 40}, function(result) {
            $('#loader-new').hide();
            $('#myslider-content').empty();

            var data = jQuery.parseJSON(result);

            if (data['found'] > 0) {
                if(genre) 
                    var dat=data['items'];
                else 
                    var dat=data['items']['dataList'];

                for (var i in dat) {
                    
                    var d = dat[i];
                    var albumName = d['albumName'];
                    var js = "<?php echo  base_url(); ?>music/detail/album/" + d['albumId'] + "";

                    var s = "<div class='slide1 container-item'>";
                    s += "<a title='" + albumName+"' class='album-name' href='" + js +"'><img src='" + img_url + d['albumLImgPath'] + "' class='rounded' width='142' height='142'/>";
                    s += "</a>";
                    s += "</div>";

                    $('#myslider-content').append(s);
                    
                }
                $('#myslider-content').width(calculate_width('.container-item'));
            } else {
                $('#myslider-content').html("<?php echo config_item('text_nodata'); ?>");
            }

            $('#myslider1').swipePlanes();
        });
    }

    function calculate_width(item_class){
        var w = 0;
        $(item_class).each(function(){
            w+= parseInt($(this).width());
        });

        return w;
    }

    function loadHotAlbum(genre, category, subcat) {
        $('.ajax_loader').show();
        if(subcat == ''){ /* 06/08/2013 by Alex */
            var subcats = '';
        }else{
            var subcats = ' > ' + subcat;
        }

        $('#most-click-songs').empty();  /* 05/08/2013 by Alex */
        $('#most-click-songs').append('<div class="uz-title-container">Most Click > ' + category + ' ' + subcats + '</div>');
        $('#link_sa_mc').empty();  /* 05/08/2013 by Alex */
        $('#link_sa_mc').append('<a href="javascript:showall_most_click(' + genre + ',\'' + category + '\',\'' + subcats + '\');">Show All</a>');

        $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_album_hot', limit: 4, genreId: genre}, function(result) {
            $('.ajax_loader').hide();
            $('#most-click').empty();
            
            var data = jQuery.parseJSON(result);
            if (data['found'] > 0) {
                for (var i in data['items']) {
                    if(i < 4) {
                        var d = data['items'][i];
                        var albumName = d['albumName'];
                        var js = "<?php echo  base_url(); ?>music/detail/album/" + d['albumId'] + "";
                        var s = "<a class='tile square image' href='" + js + "' title='" + albumName + "'>";
                        
                        s += "<div class='uz-thumb-small'>";
                        s += "<img src='" + img_url + d['albumLImgPath'] + "'/>";
                        s += "</div></a>";
                        
                        $('#most-click').append(s);
                        }
                    }

                } else {
                    $('#most-click').html("<?php echo config_item('text_nodata'); ?>");
                }
            });
        }
        
    function showAllCollection(genreID, category, subcat){
            
                $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_all_collection', offset:3, limit: 4, genreId: genreID}, function(result) {
                $('.ajax_loader').hide();
                $('#allcol-list').empty();

                if(subcat == ''){ /* 06/08/2013 by Alex */
                    var subcats = '';
		}else{
                    var subcats = ' > ' + subcat;
		}
                $('#title-all-coll').empty();
                $('#title-all-coll').append('All Collection > ' + category + ' ' + subcats);
                $('#link_sa_ac').empty();
                $('#link_sa_ac').append('<a href="javascript:showall_all_collection('+genreID+',\'' + category + '\',\'' + subcats + '\');">Show All</a>');

                var data = jQuery.parseJSON(result);
                
                if (data['found'] > 0) {
                    for (var i in data['items']) {
                        var d = data['items'][i];
                        var albumName = d['albumName'];
                        var js = "<?php echo  base_url(); ?>music/detail/album/" + d['albumId'] + "";
                        var s = "<a class='tile square image' href='" + js + "' title='" + albumName + "'>";
                        s += "<div class='uz-thumb-small'>";
                        s += "<img src='" + img_url + d['albumLImgPath'] + "'/>";
                        s += "</div></a>";

                        $('#allcol-list').append(s);
                    }
                    
                } else {
                    $('#allcol-list').html("<?php echo config_item('text_nodata'); ?>");
                }
            });
        }

    function getMyList() {
            $('#view2').load("<?php echo site_url('music/channel/playlist'); ?>");
        }

    function deleteplaylist(urut, obj) {
            $.post("<?php echo site_url('music/channel/deleteplaylist'); ?>", {urut: urut}).success(function() {
                $(obj).parent('td').parent('tr').remove();
            });
        }
        
    function showall_new_release(genre, offset, category, subcat){
            $('.ajax_loader').show();
            
            $('#all-release').empty(); /* 06/08/2013 by Alex */
            $('#all-release').replaceWith('<div class="uz-title-container-all" id="all-release">All New Release > ' + category + ' ' + subcat +'</div>'); /* 06/08/2013 by Alex */

            $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_new_album',genreId:genre,offset:offset,limit: 53}, function(result) {
                $('.ajax_loader').hide();
                $('#myslider-content').empty();

                var data = jQuery.parseJSON(result);

                if (data['found'] > 0) {
                    if(genre) var dat=data['items'];
                    else var dat=data['items']['dataList'];

                    for (var i in dat) {
                        
                        var d = dat[i];
                        var albumName = d['albumName'];
                        var js = "<?php echo  base_url(); ?>music/detail/album/" + d['albumId'] + "";

                        var s = "<div class='slide1 container-item'>";
                        s += "<a title='" + albumName+"' class='album-name' href='" + js +"'><img src='" + img_url + d['albumLImgPath'] + "' class='rounded' width='142' height='142'/>";
                        s += "</a>";
                        s += "</div>";

                        $('#myslider-content').append(s);
                        
                    }
                    $('#myslider-content').width(calculate_width('.container-item'));
                } else {
                    $('#myslider-content').append("<?php echo config_item('text_nodata'); ?>");
                }

                $('#myslider1').swipePlanes();
            });
        }
        
    function showall_most_click(genre, category, subcats){
            $('.ajax_loader').show();

            $('#all-release').empty(); /* 06/08/2013 by Alex */
            $('#all-release').replaceWith('<div class="uz-title-container-all" id="all-release">All Most Click > ' + category + ' ' + subcats +'</div>'); /* 06/08/2013 by Alex */

            $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_album_hot', limit: 53, genreId: genre}, function(result) {
                $('.ajax_loader').hide();
                $('#myslider-content').empty();
    
                var data = jQuery.parseJSON(result);

                if (data['found'] > 0) {
                    for (var i in data['items']) {
                        if(i > 3) {
                            var d = data['items'][i];
                            var albumName = d['albumName'];
                            var js = "<?php echo base_url(); ?>music/detail/album/" + d['albumId'] + "";
                            //var js = "javascript:showAlbumDetail(" + d['albumId'] + ")";
                            var s = "<div class='slide1 container-item'><a class='tile square image' href='" + js + "' title='" + albumName + "'>";
                            s += "";
                            s += "<img src='" + img_url + d['albumLImgPath'] + "'/>";
                            s += "</a></div>";

                            $('#myslider-content').append(s);
                        }
                    }

                } else {
                    $('#myslider-content').html("<?php echo config_item('text_nodata'); ?>");
                }
            });
        }
        
    function showall_all_collection(genreID, category, subcats){
            $('.ajax_loader').show();
            $('#all-release').empty();  /* 05/08/2013 by Alex */
            $('#all-release').replaceWith('<div class="uz-title-container-all" id="all-release">Show All Collection > ' + category + ' ' + subcats + '</div>');

            $.post("<?php echo site_url('ajax/music'); ?>", {func: 'get_all_collection', offset:7, limit:30, genreId:genreID}, function(result) {
                $('.ajax_loader').hide();
                $('#myslider-content').empty();
                
                var data = jQuery.parseJSON(result);
                
                if (data['found'] > 0) {
                    for (var i in data['items']) {
                        var d = data['items'][i];
                        var albumName = d['albumName'];
                        var js = "<?php echo  base_url(); ?>music/detail/album/" + d['albumId'] + "";
                        var s = "<div class='slide1 container-item'><a class='tile square image' href='" + js + "' title='" + albumName + "'>";
                        s += "";
                        s += "<img src='" + img_url + d['albumLImgPath'] + "'/>";
                        s += "</a></div>";

                        $('#myslider-content').append(s);
                        
                    }
                    
                } else {
                    $('#myslider-content').html("<?php echo config_item('text_nodata'); ?>");
                }
            });
        }
</script>
   
