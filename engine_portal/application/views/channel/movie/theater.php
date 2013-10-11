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
        width: 100%;
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
		background:#ddd;
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
		background-color: #ddd;
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
		background:#ddd;
		border-radius: 10px 10px 10px 10px;
	}
	.uz-container-2-content ul.tabs {
		width:100%;
	}
	#moviebox table tbody tr td img {
		float: left;
		margin-right: 10px;
		width: 80px;
	}
	#theaterbox {
		overflow-y:auto;
		max-height:230px;
	}
	#moviebox {
		overflow-y:auto;
		max-height:230px;
	}
</style>
<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />

<!-- slide panel item-->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />

<div class="uz-main-container-up">
	<div class="uz-container-1">
		<div class="uz-title-container">Theater Schedule</div>
		<div style='width:320px;float:left;margin-bottom:10px'>
		<ul class="tabs" persist="true">
			<li class="selected">
				<a rel="movie" href="#">Movie</a>
			</li>
			<li>
				<a rel="theater" href="#">Theater</a>
			</li>
		</ul>
		</div>
		<div class="tabcontents">
			<div id="movie" class="tabcontent">
				<div id='select'>
					<select id='citymovie' class='span2'>
						<?php foreach($city as $row) : ?>
							<option value='<?php echo $row->id?>'><?php echo $row->name?></option>
						<?php endforeach; ?>
					</select>
					<select id='movie' class='span2'>
					</select>
				</div>
				<div id='theaterbox'>
					<table class="table table-bordered">
					</table>
				</div>
			</div>
			<div id="theater" class="tabcontent">
				<div id='select'>
					<select id='citytheater' class='span2'>
						<?php foreach($city as $row) : ?>
							<option value='<?php echo $row->id?>'><?php echo $row->name?></option>
						<?php endforeach; ?>
					</select>
					<select id='theater' class='span2'>
					</select>
				</div>
				<div id='moviebox'>
					<table class="table table-bordered">
					</table>
				</div>
			</div>


		</div>
	</div>


	<div class="uz-container-wrap"></div>
	<div class="uz-container-2">
		<div class="uz-title-container">Coming Soon</div>
		<div class="uz-container-2-content">
			<?php $i=1; foreach($coming_soon as $item) : ?>
			<a class="tile square image" href='<?php echo base_url('movie/channel/detail/'.$item->id)?>'>
				<div class="uz-thumb-small">
					<img src="<?php echo config_item('api_folder'). 'vod/'.$item->categories.'/'. $item->item_thumbnail; ?>">
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
		<div class="uz-container-2-content">
			<?php $i=1; foreach($top_view as $item) : ?>
			<a class="tile square image" href='<?php echo base_url('movie/channel/detail/'.$item->id)?>'>
				<div class="uz-thumb-small">
					<img src="<?php echo config_item('api_folder'). 'vod/'.$item->categories.'/'. $item->item_thumbnail; ?>">
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
	<div class="uz-title-container">All Top View</div>
	<div id="myslider1" class="myslider1">
		<div id="myslider-content">
		   <?php for($i=6;$i<count($top_view);$i++): ?>
				<a title='<?php echo substr($top_view[$i]->item_name,0,15); ?>' href='<?php echo base_url('movie/channel/detail/'.$top_view[$i]->id)?>'>
					<div class='slide1 container-item rounded'>
						<img src='<?php echo config_item('api_folder'). 'vod/'.$top_view[$i]->categories.'/'.$top_view[$i]->item_thumbnail; ?>' class='rounded' width='96' height='142'/>
					</div>
				</a>
			<?php endfor; ?>
		</div>
	</div>
</div>
   <script type="text/javascript">
   var hash = window.location.hash;
   hash=hash.split('/');
   
$(document).ready(function(){
	$('#myslider1').swipePlanes();
	$('#citytheater').bind('change', function(){
		loadtheater($(this).val());
	});
	$('#select #theater').bind('change', function(){
		loadmovielist($('#citytheater').val(), $(this).val());
	});
	$('#citytheater').trigger('change');
	$('#citymovie').bind('change', function(){
		loadmovie($(this).val());
	});
	$('#select #movie').bind('change', function(){
		loadtheaterlist($('#citymovie').val(), $(this).val());
	});
	$('#citymovie').trigger('change');
	if(hash){
		if(hash[0]=='#feature'){
			$("#byfeature li a[data='"+hash[1]+"']").click();
		}else if(hash[0]=='#genre'){
			$('#bygenre li a[data='+hash[1]+']').click();
		}else{
			$("#byfeature li a[data='2']").click();
		}
	}
});
	
function loadmovie(city){
	$.post('<?php echo base_url('movie/theater/moviebycity')?>', {city:city}, function(result){
		var data = jQuery.parseJSON(result);
		$('#select #movie').html('');
		if (data['found']>0){
			for (var i in data['items']){
				var d = data['items'][i];
				var s = "<option value='"+d['id']+"'>"+d['item_name']+"</option>";
				$('#select #movie').append(s);
			}
		}else{
			var s = "<option value=''>There is no Movie</option>";
			$('#select #movie').append(s);
		}
		$('#select #movie').trigger('change');
	});
}
function loadtheaterlist(city, id){
	//alert(id);
	$.post('<?php echo base_url('movie/theater/theaterlist')?>', {id:id, city:city}, function(result){
		var data = jQuery.parseJSON(result);
		$('#theaterbox table').html("<thead><tr><th align='center'>Theater</th><th align='center'>Showtime</th></tr></thead>");
		var s='<tbody>';
		if (data['found']>0){
			for (var i in data['items']){
				var d = data['items'][i];
				s += "<tr>"+
							"<td>"+d['name']+"</td>"+
							"<td>"+d['time'].replace(/,/g,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')+"</td>"+
						"</tr>";
			}
		}else{
			s += "<tr>><td colspan='2'>There is no Theater</td>";
		}
		$('#theaterbox table').append(s+"</tbody>");
	});
}
function loadtheater(city){
	$.post('<?php echo base_url('movie/theater/theaterbycity')?>', {city:city}, function(result){
		var data = jQuery.parseJSON(result);
		$('#select #theater').html('');
		if (data['found']>0){
			for (var i in data['items']){
				var d = data['items'][i];
				var s = "<option value='"+d['id']+"'>"+d['name']+"</option>";
				$('#select #theater').append(s);
			}
		}else{
			var s = "<option value=''>There is no Theater</option>";
			$('#select #theater').append(s);
		}
		$('#select #theater').trigger('change');
	});
}
function loadmovielist(city, id){
	//alert(id);
	$.post('<?php echo base_url('movie/theater/movielist')?>', {id:id, city:city}, function(result){
		var data = jQuery.parseJSON(result);
		$('#moviebox table').html("<thead><tr><th align='center'>Movie</th><th align='center'>Showtime</th></tr></thead>");
		var s='<tbody>';
		if (data['found']>0){
			for (var i in data['items']){
				var d = data['items'][i];
				s += "<tr>"+
							"<td valign='middle'><a href='<?php echo base_url('movie/channel/detail');?>/"+d['item_id']+"'><img src='<?php echo config_item('userfiles'). 'movie/thumbnail/'; ?>/"+d['item_thumbnail']+"'/>"+d['item_name']+"</a></td>"+
							"<td>"+d['time'].replace(/,/g,'<br>')+"</td>"+
						"</tr>";
			}
		}else{
			s += "<tr>><td colspan='2'>There is no Movie</td>";
		}
		$('#moviebox table').append(s+"</tbody>");
	});
}


   </script>

