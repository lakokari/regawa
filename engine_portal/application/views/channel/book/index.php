<style>
    /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        
        float : left;
    }
    .uz-main-container-down {
        width: 1150px;
        height: 150px;
        padding-left: 60px;
        float : left;
    }
    .uz-title-container {
        width: 240px;
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
        width : 180px;
        height: 320px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-thumb-big img {
        width : 200px;
        height: 316px;
    }
    .uz-thumb-small {
        width : 101px;
        height: 156px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-thumb-small img {
        width : 101px;
        height: 156px;
    }

    .uz-btm-small {
        width : 70px;
        height: 111px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-btm-small img {
        width : 70px;
        height: 111px;
    }
    
</style>
<style>
    .myslider1 {
        border: 1px solid #D9D9D9;
        border-radius: 10px 10px 10px 10px;
        float: left;
        height: 111px;
        padding-bottom: 5px;
        padding-top: 5px;
        width: 100%;
    }
.modal-header {
    padding: 2px 15px;
}
</style>
<!-- slider -->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>

    <div class="uz-main-container-up">



    <div class="uz-container-1">
        <div class="uz-title-container">Best Seller</div>
        <div class="uz-show-all"><a href="javascript:showAllBest();">Show All</a></div>
        <div class="uz-container-1-content" id="best-seller">
            
        </div>
    </div>
    <div class="uz-container-wrap"></div>

        
    <div class="uz-container-2">
        <div class="uz-title-container">New Release</div><div class="uz-show-all"><a href="javascript:showAllNew();">Show All</a></div>
        <div class="uz-container-2-content" id="new-release">

            
        </div>
    </div>
    <div class="uz-container-wrap"></div>


    <div class="uz-container-2"  id="book-container-cat">
        <div class="uz-title-container"></div>
        <div class="uz-container-2-content">
            
        </div>
    </div>
    </div>

    <div class="uz-main-container-down">
        <div class="uz-title-container" id="all"></div>
        <div id="myslider1" class="myslider1">
            <div id="myslider-content"></div>
        </div>
    </div>

<div class="modal hide fade" id='ModalComic' style="width:800px; height:96%; margin-left:-30%; background:#fff; margin-top: -75px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><br>
    </div>
<iframe name="frame-play" id="frame-play" src="" width="800px" height="100%" frameborder="0"></iframe>
</div>


<script>
    var img_url = '<?php echo config_item('api_sync').'book/'; ?>';

    var active_category = "<?php echo isset($category)?$category:'Comic'; //comic:2?>";
    $(document).ready(function(){
        loadNewRelease();
        loadBest();
        $('#book-container-cat').show();
        $('#new-release').show();
        $('.myslider1').swipePlanes();
        $('#kategory-buku li a').click(function(){
            loadBookByCategory($(this).attr('name'),$(this).attr('data'), $(this).html());
        });
        
        //if (active_category>0){
            if($('#kategory-buku li a').length>1){
                $('#kategory-buku li a').each(function(){
                    if ($(this).attr('name')==active_category){
                        $(this).click(); return;
                    }
                });
            }
        //}
    });


    function showModalComic(){
        $("#ModalComic").modal('show');
    }

    function loadBookByCategory(category, categoryId){
        //$('#panorama-scroll-prev').click();
        var func = 'get_comic_mako';
        var link = '';
        var onclick= 'showModalComic()';
        var target= 'frame-play';
        if(category!=="Comic"){ 
            func = 'get_book_by_category';
            link = '<?php echo base_url();?>book/detail/book/';
            target = '';
            onclick = '';
        }
        $('#book-container-cat').empty();
        $('#myslider-content').empty();
        $('#all').empty();
        
        $.post("<?php echo site_url('ajax/book');?>",{func:func,category_id:categoryId,category:category,limit:40},function(result){
            $('#book-container-cat').show();
            var data = jQuery.parseJSON(result);
            var titlebook = "<div class='uz-title-container'>"+category+"</div>";
            $('#book-container-cat').append(titlebook);

            if (data['found']>0){
                var usedId = [];
                for (var i in data['items']){
                    
                    var d = data['items'][i];
                    
                    var bookName = d['name'];
                    var s = "";
                    s+= "<a title='"+bookName+"' href='"+link+d['content_id_token']+"' target='"+target+"' onclick='"+onclick+"'>";
                    s+= "<div class='uz-thumb-small '>";
                    if (category==="Comic")
                        s+= "<img src='"+ d['thumbnail_url']+"'/>";
                    else
                        s+= "<img src='"+ img_url + d['thumbnail_url']+"'/>";
                    s+= "</div>";
                    s+= "</a>";

                    $('#book-container-cat').append(s);
                    
                    usedId.push(d['content_id_token']);
                    
                    if (parseInt(i)>=5) break;
                }
                
                //show the rest of data
                if (data['found']>6){
                    loadBookBottom(data, usedId, link, target, onclick, category);
                    loadTitleBottom(category);
                }
            }else{
                $('#book-container-cat').append("No data");
            }
        });
    }


    function loadNewRelease(){
        var category = 'New Release';
        var target  = '';
        var link = '<?php echo base_url();?>book/detail/book/';
        $.post("<?php echo site_url('ajax/book');?>",{func:'get_new_release',limit:6},function(result){
            $('#new-release').show();
            var link = '<?php echo base_url();?>book/detail/book/';
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                for (var i in data['items']){
                    
                    var d = data['items'][i];
                    
                    var bookName = d['name'];
                    var s = "";
                    s+= "<a data='"+d['content_id_token']+"' title='"+bookName+"' href='"+link+d['content_id_token']+"'>";
                    s+= "<div class='uz-thumb-small'>";
                    s+= "<img src='"+ img_url + d['thumbnail_url']+"'/>";
                    s+= "</div>";
                    s+= "</a>";

                    $('#new-release').append(s);
                }
                
            }else{
                $('#new-release').append("No data");
            }
        });
    }


    function loadBest(){
        var category = 'Best Seller';
        var target  = '';
        var imgurl='';
        var link = '<?php echo base_url();?>book/detail/book/';
        $.post("<?php echo site_url('ajax/book');?>",{func:'get_best_seller',limit:5},function(result){
            $('#best-seller').show();
            var link = '<?php echo base_url();?>book/detail/book/';
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                for (var i in data['items']){
                    
                    var d = data['items'][i];
                    
                    var bookName = d['name'];
                    var s = "";
                    s+= "<a data='"+d['content_id_token']+"' title='"+bookName+"' href='"+link+d['content_id_token']+"'>";
                    if(i == 0){
                        s += '<div class="uz-thumb-big">';
                    } else {
                        s += '<div class="uz-thumb-small">';
                    }
                    if(category!=='Comic') 
                        imgurl=img_url;
                    s+= "<img src='"+imgurl+d['thumbnail_url']+"'/>";
                                        s+= "</div>";
                    s+= "</a>";

                    $('#best-seller').append(s);
                }
                
            }else{
                $('#best-seller').append("No data");
            }
        });
    }


    function showAllNew(){
        var usedId = [];

        $('div#new-release a').each(function(){
            usedId.push($(this).attr('data'));
        });

        var link = '<?php echo base_url();?>book/detail/book/';
        $.post("<?php echo site_url('ajax/book');?>",{func:'get_new_release',limit:30},function(result){
            $('#new-release').show();
            var link = '<?php echo base_url();?>book/detail/book/';
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                loadBookBottom(data, usedId, link, '', '');
                loadTitleBottom('New Release');
            }
        });   

    }

    function showAllBest(){
        var usedId = [];

        $('div#best-seller a').each(function(){
            usedId.push($(this).attr('data'));
        });

        var link = '<?php echo base_url();?>book/detail/book/';
        $.post("<?php echo site_url('ajax/book');?>",{func:'get_best_seller',limit:30},function(result){
            $('#best-seller').show();
            var link = '<?php echo base_url();?>book/detail/book/';
            var data = jQuery.parseJSON(result);

            if (data['found']>0){
                loadBookBottom(data, usedId, link, '', '');
                loadTitleBottom('Best Seller');
            }
        });   

    }
    
    function loadBookBottom(data, usedId, link, target, onclick, category){
        $('#myslider-content').empty();
        for (var i in data['items']){
            var d = data['items'][i];
            if (usedId.indexOf(d['content_id_token'])<0){
                var bookName = d['name'];
                var s = "";
                var imgurl='';
                s+= "<a title='"+bookName+"' href='"+link+""+d['content_id_token']+"' target='"+target+"' onclick='"+onclick+"'>";
                s+= "<div class='uz-btm-small '>";
                if(category!=='Comic') imgurl=img_url;
                s+= "<img src='"+imgurl+d['thumbnail_url']+"'/>";
                s+= "</div>";
                s+= "</a>";

                $('#myslider-content').append(s);
            }
        }
        $('.myslider1').swipePlanes();
    }
    
    function loadTitleBottom(category){
        $('#all').empty();
        var titlebook = "<div class='uz-title-container'> All "+category+"</div>";
        $('#all').append(titlebook);
        }   
    
</script>