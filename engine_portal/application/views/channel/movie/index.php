<style>
    /************  style ini yang dipakai ****************/
	
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float:left;
    }
    .uz-main-container-down {
        width: 1160px;
        height: 200px;
		margin-top:10px;
        padding-left: 60px;
        float : left;
    }
    .uz-title-container {
        width: auto;
		text-align:left;
        height: 20px;
		float:left;
       
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
        width : 290px;
        height: 316px;
        float : left;
		background:#000;
		text-align:center;
		position: relative;
        border : 2px solid #fff;
		border-right : 1px solid #fff;
    }
	.uz-thumb-big a {
		color: #FFFFFF;
	}
    .uz-thumb-big img {
        width : 213px;
        height: 316px;
    }
	
    .uz-main-container-up .uz-thumb-small {
		background-color: #000;
		color: #FFFFFF;
		cursor: pointer;
		display: block;
		float: left;
		height: 156px;
		overflow: hidden;
		padding: 0;
		position: relative;
		text-decoration: none;
		width: 103px;
        border : 2px solid #fff;
		border-bottom : 1px solid #fff;
        float : left;
    }
	.uz-main-container-up .uz-container-2 .tile:nth-child(3n-2) .uz-thumb-small {
        border-right: 1px solid #fff;
	}
	.uz-main-container-up .uz-container-2 .tile:nth-child(3n) .uz-thumb-small {
        border-left: 1px solid #fff;
	}
	.uz-main-container-up .uz-container-2 .tile:nth-child(3n-1) .uz-thumb-small{
        border-left: 1px solid #fff;
		border-right: 1px solid #fff;
	}
	.uz-main-container-up .uz-container-2 .tile:nth-child(n+4) .uz-thumb-small{
        border-top: 1px solid #fff;
		border-bottom: 2px solid #fff;
	}
	.uz-main-container-up .uz-container-1 .uz-thumb-small {
		border-left: 1px solid #fff;
	}
	.uz-main-container-up .uz-container-1 .uz-thumb-small:last-child {
		border-top: 1px solid #fff;
		border-bottom: 2px solid #fff;
	}
    .uz-thumb-small img {
        width : 104px;
        height: 154px;
    }
    .uz-main-container-up .tile.square .textover-wrapper,.uz-main-container-up .uz-thumb-big .textover-wrapper {
		width: auto;
	}
	.uz-main-container-up .tile .textover-wrapper.transparent,.uz-main-container-up .uz-thumb-big .textover-wrapper.transparent {
		background-color: rgba(0, 0, 0, 0.7);
	}
	.uz-main-container-up .tile .textover-wrapper,.uz-main-container-up .uz-thumb-big .textover-wrapper {
		background-color: inherit;
		bottom: 0;
		height: auto;
		padding: 2px 10px;
		position: absolute;
		display:none;
	}
	.uz-main-container-up .tile:hover .textover-wrapper,.uz-main-container-up .uz-thumb-big:hover .textover-wrapper {
		display:block;
	}
	.uz-main-container-up .tile .text2,.uz-main-container-up .uz-thumb-big .text2 {
		font-size: 13px;
		font-weight: 300;
		text-wrap:normal;
		line-height: 20px;
		max-height: 100%;
		overflow: hidden;
		text-align: left;
	}
	#myslider-content .slide1.container-item, #myslider-content .slide1.container-item img {
		width:96px;
		min-height:142px;
		background:#000;
		border-radius: 10px 10px 10px 10px;
	}
	.uz-show-all {
		float: right;
		height: 20px;
		width: 70px;
	}
	.uz-show-all a {
		color: #D31821;
		text-decoration: none;
	}
</style>
<!-- slide panel item-->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />

<div class="uz-main-container-up">
    <div class="uz-container-1" id='movie-act'>
        <div class="uz-title-container">New Release</div>
		<div class="uz-show-all">
			<a href="javascript:void(0);" onclick="loadAllData('newrelease');">Show All</a>
		</div>
        <?php $i=1; foreach($new_release as $item) : ?>
        <?php if($i==1) : ?>
        <div class="uz-thumb-big">
            <a href='<?php echo base_url('movie/channel/detail/'.$item->id)?>'>
                <img src="<?php echo $item->item_thumbnail_big; ?>">
                <div class='textover-wrapper transparent'>
                    <div class='text2'><?php echo substr($item->item_name,0,15)?><br><font size='2' color='#cccccc'><?php echo $item->director?></font></div>
                </div>
            </a>
        </div>
        <?php else: ?>
        <a class="tile square image" href='<?php echo base_url('movie/channel/detail/'.$item->id)?>'>
            <div class="uz-thumb-small">
                <img src="<?php echo $item->item_thumbnail_big; ?>">
                <div class='textover-wrapper transparent'>
                    <div class='text2'><?php echo substr($item->item_name,0,15)?><br><font size='2' color='#cccccc'><?php echo $item->director?></font></div>
                </div>
            </div>
        </a>
        <?php endif; ?>
        <?php $i++; if($i==4) break; endforeach; ?>
    </div>
    <div class="uz-container-wrap"></div>
    <div class="uz-container-2">
        <div class="uz-title-container">Top Paid</div>
		<div class="uz-show-all">
			<a href="javascript:void(0);" onclick="loadAllData('top_paid');;">Show All</a>
		</div>
        <div class="uz-container-2-content">
            <?php $i=1; foreach($top_paid as $item) : ?>
            <a class="tile square image" href='<?php echo base_url('movie/channel/detail/'.$item->id)?>'>
                <div class="uz-thumb-small">
                    <img src="<?php echo $item->item_thumbnail_big; ?>">
                    <div class='textover-wrapper transparent'>
                        <div class='text2'><?php echo substr($item->item_name,0,15)?><br><font size='2' color='#cccccc'><?php echo $item->director?></font></div>
                    </div>
                </div>
            </a>
            <?php $i++; if($i==7) break; endforeach; ?>
	</div>
    </div>
    <div class="uz-container-wrap"></div>
    <div class="uz-container-2">
        <div class="uz-title-container">Top View</div>
		<div class="uz-show-all">
			<a href="javascript:void(0);" onclick="loadAllData('top_view');">Show All</a>
		</div>
        <div class="uz-container-2-content">
            <?php $i=1; foreach($top_view as $item) : ?>
            <a class="tile square image" href='<?php echo base_url('movie/channel/detail/'.$item->id)?>'>
                <div class="uz-thumb-small">
                    <img src="<?php echo $item->item_thumbnail_big; ?>">
                    <div class='textover-wrapper transparent'>
                        <div class='text2'><?php echo substr($item->item_name,0,15)?><br><font size='2' color='#cccccc'><?php echo $item->director?></font></div>
                    </div>
                </div>
            </a>
            <?php $i++; if($i==7) break; endforeach; ?>
		
        </div>
    </div>
</div>

<div class="uz-main-container-down">
    <div class="uz-title-container">Show All</div><div class="ajax_loader" style="display: none;"></div>
    <div id="myslider1" class="myslider1">
        <div id="myslider-content"></div>
    </div>
</div>
   
<script type="text/javascript">
   var hash = window.location.hash;
   hash=hash.split('/');
   
    $(document).ready(function(){
        $("#byfeature li a").click(function(){
            var category = $(this).attr('data');
            loadAllData(category);
        });
    
        
        if(hash && hash.length>0 && hash[0]=='feature'){
            //alert(hash[1]);
            loadAllData(hash[1]);
        }else{
            loadAllData('newrelease');
        }
    });
	
    function loadAllData(category_name){
        var category_title = category_name.replace('_', ' ');
        $('.uz-main-container-down .uz-title-container').text('All '+capitaliseFirstLetter(category_title));
        $('#myslider-content').empty();
        
        $.post('<?php echo base_url('ajax/movie');?>',{func:'load_all_data',categories:category_name},function(data){
            if (data['found']>0){
                for(var i in data['items']){
                    var d = data['items'][i];
                    var img_url= d['item_thumbnail'];
                    var movieName = d['item_name'];
                    var s = "<a title='" + movieName.substr(0, 15)+"' href='<?php echo base_url('movie/channel/detail/')?>/"+d['id']+"'>";
                    s +="<div class='slide1 container-item rounded'>";
                    s += "<img src='"+img_url+"' class='rounded' width='96' height='142'/>";
                    s += "</div>";
                    s += "</a>";

                    $('#myslider-content').append(s);
                }
                $('#myslider-content').width(calculate_width('.container-item'));
                $('#myslider1').swipePlanes();
            }
        },'json');
    }
	
    function calculate_width(item_class){
        var w = 0;
        $(item_class).each(function(){ w+= parseInt($(this).width()); });

        return w;
    }
</script>

