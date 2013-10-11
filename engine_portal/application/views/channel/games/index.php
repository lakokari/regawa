<style>
    #landing-page-games {
        background: white;
        color: #000;
    }
</style>
<style>
    /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        border:0px solid #F00;
        float : left;
    }
    .uz-main-container-down {
        width: 1170px;
        height: 150px;
        padding-left: 60px;
        float : left;
        margin-top: 20px;
    }
    .uz-title-container {
        width: auto;
        height: 20px;
        float : left;
       
    }
    
    .uz-container-3 {
        width: 420px;
        height: 340px;
        float : left;
       
    }
    .uz-container-3-content {
        width: 420px;
        height: 340px;
        float : left;
        /*border : 1px solid #000;*/
    }
    .uz-container-wrap {
        width: 60px;
        height: 340px;
        float : left;
    }
    
    .uz-container-4 {
        width: 400px;
        height: 340px;
        float : left;
        /*border : 1px solid #000;*/
    }
    .uz-container-4-content {
        width: 400px;
        height: 320px;
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


    
    .uz-thumb-big {
        width: 296px;
        height: 269px;
        float : left;
        border : 1px solid #fff;
        background: #000;
        padding-top: 35px;
    }
    .uz-thumb-big img {
        width : 313px;
        height: auto;
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

    .myslider1 {
        border: 1px solid #D9D9D9;
        border-radius: 10px 10px 10px 10px;
        float: left;
        height: 110px;
        margin-bottom: 0px;
        padding-bottom: 0px;
        padding-top: 25px;
        width: 100%;
    }
	.myslider1 img {
		padding-top:-5px;
	}
	.myslider-item{
    	width:100%;
    	height: 110px;
    	-webkit-border-radius: 10px;
    	-moz-border-radius: 10px;
    	border-radius: 10px;
    	float : left;
    	margin-top: 10px;
    	margin-left: 10px;
	}

</style>
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />

    <div class="uz-main-container-up">
        
        <div class="uz-container-4">
            <div class="uz-title-container">Top Games</div><div class="uz-show-all"><a href="javascript:showAllTop();">Show All</a></div>
            <div class="uz-container-4-content" id="top">
                
                <?php $i=0; foreach($top as $data):?>
                    <a data="<?php echo $data->ID;?>" href="<?php echo base_url();?>games/detail/item/<?php echo $data->ID;?>" title="<?php echo $data->title;?>">
                        <?php if ($i==0):?>
                        <div class="<?php echo "uz-thumb-big";?>">
                            <img src="<?php echo $data->thumbnail_big_url;?>" class="imgSmall">
                        </div>
                        <?php else: ?>
                        <div class="<?php echo "uz-thumb-small";?>">
                            <img src="<?php echo $data->thumbnail_url;?>" class="imgSmall">
                        </div>
                        <?php endif; ?>
                    </a>
                <?php $i++; endforeach; ?>
            </div>
        </div>

        <div class="uz-container-wrap"></div>

        <div class="uz-container-2">
            <div class="uz-title-container">New Release</div><div class="uz-show-all"><a href="javascript:showAllNew();">Show All</a></div>
            <div class="uz-container-2-content" id="new-release">
                <?php
                    $i=1;
                    foreach ($new_r as $data) :
                ?>
                    <a data="<?php echo $data->ID; ?>" href="<?php echo base_url();?>games/detail/item/<?php echo $data->ID;?>" title="<?php echo $data->title;?>">
                        <div class="uz-thumb-small">
                            <img src="<?php echo $data->thumbnail_url;?>" class="imgSmall">
                        </div>
                    </a>
                <?php
                    $i++; if($i==10) break;
                    endforeach;
                ?>
            </div>
        </div>

        <div class="uz-container-wrap"></div>
        
        <div class="uz-container-2">
            <div class="uz-title-container" id="title_cnt"></div>
            <div class="uz-container-2-content" id="games-list">

            </div>
        </div>

    </div>

        <div class="uz-main-container-down">
            <div class="uz-title-container" id="title-down"></div>
            <div id="myslider1" class="myslider1" style="height:125px;">
                <div id="myslider-content">
                </div>
            </div>
        </div>
<script>
    $(document).ready(function(){
        if (window.location.hash){
            var hash = window.location.hash;
            hash=hash.replace('_',' ');
            hash=hash.replace('#','');
        } else {
            hash = "";
        }
        if(hash != ""){
            gamesByCategory(hash,0,hash);
        } else {
            gamesByCategory('action',0,'Action');
        }        
                
        
        
        $('#cat-container ul').on("click", "li", function() {
            gamesByCategory($(this).children('a').attr('data'),0,$(this).children('a').html());

            //change active class
            $('#cat-container ul li').each(function() {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
        
        /*
        if ($('#cat-container ul li').length>0){
            $('#cat-container ul li').eq(0).click();
        }*/
    });
    
    function gamesByCategory(category_name, offset, titlecat){
	$('#title-down').empty();
        //update selected category title
        $('div#title_cnt').html(titlecat);
        
        //refresh container slider
        
        
        $('#loader-selected').show();
        $.post("<?php echo site_url('ajax/games'); ?>", {func: 'games_by_category_name',category_name:category_name,offset:offset,limit:9}, function(data) {
            $('#loader-selected').hide();
            $('#games-list').empty();
			
            if (data['found'] > 0) {
                for (var i in data['items']) {
					
                    var d = data['items'][i];
                    var title = d['title'];
                    //var js = "javascript:showGameDetail("+d['ID']+")";
                    var js = "<?php echo base_url();?>games/detail/item/"+d['ID'];
                    
                    var s = "<a href='" + js +"' title='"+title+"'><div class='uz-thumb-small'>";
                    s += "<img src='" + d['thumbnail_url'] + "'/>";
                    s += "</div></a>";

                    $('#games-list').append(s);
					
                }
				
            } else {
                $('#games-list').html("No data");
                $('#title-down').html('Show All');
            }
        },'json');
        
        //show the rest of data
        gamesByCategoryBottom(category_name, 10, titlecat);
    }
	
    function gamesByCategoryBottom(category_name, offset, title_cat){
        $('#title-down').html('Show All '+ title_cat);
        
        $('#myslider-content').empty();
        $.post("<?php echo site_url('ajax/games'); ?>", {func: 'games_by_category_name',category_name:category_name,offset:offset,limit:30}, function(data) {
            if (data['found'] > 0){
                showGameBottom(data['items']);
            }else{
                $('#myslider-content').html('');
            }
        },'json');
        
        
    }
    
    function showGameBottom(data){
        $('#myslider-content').html('');
        for (var i in data){
            var d = data[i];
            var d = data[i];
            var title = d['title'];
            var js = "<?php echo base_url();?>games/detail/item/"+d['ID'];
            var s = "<div class='uz-thumb-small'><a href='" + js +"' title='"+title+"'>";
            s += "<img src='" + d['thumbnail_url'] + "' class='rounded'/>";
            s += "</a></div>";

            $('#myslider-content').append(s);

        }
        $('.myslider1').swipePlanes();
    }
    
    function showGameDetail(ID){
        
        //make sure detail container will be shown and the feature list to hide
        $('div#sliderFrame').hide();
        if ($('div#detail-container').css('display')==='none'){
            $('div#detail-container').show();
        }
        
        //load detail page in the container
        $('div#detail-container').load("<?php echo site_url('games/detail/item');?>",{gameId:ID});
    }
    
    function calculate_width(item_class){
        var w = 0;
        $(item_class).each(function(){
            w+= parseInt($(this).width());
        });
        
        return w;
    }

    function showAllNew(){

        var link = '<?php echo base_url();?>games/detail/item/';
        $.post("<?php echo site_url('ajax/games');?>",{func:'get_new',limit:30},function(result){
            $('#new-release').show();
            var link = '<?php echo base_url();?>games/detail/item/';
            var data = jQuery.parseJSON(result);
            $('#title-down').html("All New Release ");

            if (data['found']>0){
                showGameBottom(data['items']);
            }
        });   

    }


    function showAllTop(){
        var link = '<?php echo base_url();?>games/detail/item/';
        $.post("<?php echo site_url('ajax/games');?>",{func:'get_top',limit:30},function(result){
            $('#top').show();
            var link = '<?php echo base_url();?>games/detail/item/';
            var data = jQuery.parseJSON(result);
            $('#title-down').html("All Top Games ");

            if (data['found']>0){
                showGameBottom(data['items']);
            }
        });   

    }

</script>