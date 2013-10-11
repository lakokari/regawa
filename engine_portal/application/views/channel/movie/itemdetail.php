<style>
    /************  style ini yang dipakai ****************/
	.table-detail b{
		color:#565656;
	}
	.table-detail p{
		line-height:25px;
	}
    .uz-main-container-up {
		margin-top:10px;
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
        width: 725px;
        height: 340px;
        float : left;
       
    }
	.uz-container-3 {
		width: 420px;
        height: 340px;
        float : left;
       
    }
    .uz-container-1-content {
        width: 400px;
        height: 320px;
        float : left;
    }
    .uz-container-wrap {
        width: 20px;
        height: 340px;
        float : left;
    }
    
    .uz-container-2 {
        width: 99.9%;
        height: 100%;
        float : left;
    }
    .uz-container-2-content {
        width: 355px;;
        height: auto;
		margin:0 auto; padding:0 auto;
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
		width: 115px;
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
    .uz-thumb-small img {
        width : 115px;
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

	#detail {
		overflow-x:hidden;
		overflow-y:auto;
		max-height:450px;
		padding-right:15px;
		margin-bottom:5px;
	}
	#commentbox {
		max-height:410px;
		overflow-y:auto;
	}
	#comment-form-container {
    	border: 1px solid #333;
    	margin-left: 20px;
    	margin-bottom: 20px;
    }
.star{cursor: pointer; width:50%; height:28px; display: inline-block; float:left;}
.star_transparent{opacity:0.4;filter:alpha(opacity=40);}
.full-star, .half-star, .empty-star{width: 24px; height:28px;display: inline-block;}
.full-star{background: url('<?php echo config_item("assets_url"); ?>img/star/Full-Star.png') no-repeat;}
.half-star{background: url('<?php echo config_item("assets_url"); ?>img/star/Half-Star.png') no-repeat;}
.empty-star{background: url('<?php echo config_item("assets_url"); ?>img/star/Zero-Star.png') no-repeat;}
.full-star-small, .half-star-small, .empty-star-small{width: 18px; height:18px;display: inline-block;}
.full-star-small{background: url('<?php echo config_item("assets_url"); ?>img/star/Full-Star-small.png') no-repeat;}
.half-star-small{background: url('<?php echo config_item("assets_url"); ?>img/star/Half-Star-small.png') no-repeat;}
.empty-star-small{background: url('<?php echo config_item("assets_url"); ?>img/star/Zero-Star-small.png') no-repeat;}
a.rating { color:#666; text-decoration: none;font-weight:bold;}
a.rating:hover { text-decoration: underline;}
</style>
<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />

<script>
var id='<?php echo $item->id?>',trailer='<?php echo $item->item_url_mpeg_trailer?>',full='<?php echo $item->item_url_mpeg?>';
</script>
<div class="uz-main-container-up">
	<div class="uz-container-1">
		<div class="uz-title-container" style="margin-bottom:10px;"><h3><?php echo $item->item_name;?></h3></div>
		<table class="table-detail stripped" id='det'>
			<tr>
				<td valign='top' width='304px'>
					<img src="<?php echo $item->item_thumbnail_big; ?>" width='304px' height='450px' style='margin:0;width:304px;height:420px;margin-bottom:10px;'/>
					<span data='like'><?php echo $item->item_like_count?></span> Likes
					<?php if($islogin): ?>
						<div class="btn-group" id='unlike'>
							<ul class="dropdown-menu">
								<li><a href="javascript:unlike('<?php echo $item->id?>')">Unlike</a></li>
							</ul>
							<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown">Liked</a>
						</div>
						<a href="javascript:like('<?php echo $item->id?>')" class="btn btn-mini" id='like'><i class="icon-thumbs-up-2"></i> Like</a>
					<?php endif; ?>
					 | <?php echo $item->view_count?> Views<?php if($item->premiumYN=='y'): ?> & <?php echo $item->view_paid_count?> Paids<?php endif; ?><br><br>
					
					
					
				</td>
				<td valign='top'>
					<div id='detail' style='padding-left:10px'>
						<table width="100%" cellpadding="3" cellspacing="0" style="color:black;" class="table-detail stripped">
							<tr>
								<td valign='top' width="70"><b>Tahun</b></td><td width="10">:</td>
								<td><?php echo $item->published_year;?></td>
							</tr>
							<tr>
								<td valign='top'><b>Kategori</b></td><td>:</td>
								<td>[<?php echo $item->categories;?>]</td>
							</tr>
							<tr>
								<td valign='top'><b>Rating</b></td><td>:</td>
								<td><?php 
								if($star){
									foreach($star as $row){
										echo "<a href='$row->source_link' target='_blank' class='rating'>".$row->alias.'</a> '.$row->rating;
									}
								}else{
									echo config_item('text_norates');
								}?></td>
							</tr>
							<tr>
								<td colspan='3' style="text-align:justify;">
									<b>Synopsis</b><br>
									<?php echo empty($item->synopsis) ? 'No Synopsis' : $item->synopsis?>
								</td>
							</tr>
							<tr>
								<td colspan='3'>
									<table width="100%" cellpadding="3" cellspacing="0" class="table-detail stripped">
										<tr>
											<td valign='top' width='100'><b>Sutradara</b></td><td width='5'>:</td>
											<td><?php echo $item->director;?></td>
										</tr>
										<tr>
											<td valign='top'><b>Penulis Skenario</b></td><td>:</td>
											<td><?php echo $item->scene_writer;?></td>
										</tr>
										<tr valign='top'>
											<td valign='top'><b>Cast & Crew</b></td><td>:</td>
											<td >
												<?php echo $item->cast_crew?>
											</td>
										</tr>
										<tr>
											<td valign='top'><b>Release Date</b></td><td>:</td>
											<td><?php echo $item->published_year;?></td>
										</tr>
										<tr>
											<td valign='top'><b>Publisher</b></td><td>:</td>
											<td><?php echo $item->publisher_name;?></td>
										</tr>
										<tr>
											<td valign='top'><b>Jenis Film</b></td><td>:</td>
											<td><?php if($item->premiumYN=='y'): ?><span class="label label-important">Berbayar</span>
												<?php else: ?><span class="label label-info">Gratis</span><?php endif; ?></td>
										</tr>
										<tr>
											<td colspan='3'>
												<!-- AddThis Button BEGIN -->
												<div class="addthis_toolbox addthis_default_style">
													<a class="addthis_counter addthis_pill_style"></a>
													 <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
													<a class="addthis_button_tweet"></a>
													<!--<a class="addthis_button_pinterest_pinit"></a>-->
												   
												</div>
												<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51de9ac26202a940"></script>
												<!-- AddThis Button END -->
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<div style="display:block;margin-top:10px;margin-left:13px;">
						<?php if($item->item_url_mpeg_trailer) : ?>
							<button onclick="loadtrailer()" class='btn-danger'>
								<i class="icon-play"></i> Trailer
							</button>
						<?php endif; ?>
						<?php if($item->item_url_mpeg or $item->premiumYN=='y') echo " <button id='full' data-href='".$item->url_full_movie."' class='btn-primary'><i class='icon-paperplane'></i>Play</button>"; ?>
						 <button class='btn-success' id='commentbutton' <?php if(!$islogin): ?>title='<?php echo config_item('text_no_login'); ?>'' <?php else : ?> onclick="comment()" <?php endif; ?>>
							<i class="icon-chat"></i> Rating
						</button>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="uz-container-wrap"></div>
	<div class='uz-container-3'>
		<ul class="tabs" persist="true">
			<?php if($item->item_url_mpeg_trailer) : ?>
				<li class="selected">
					<a rel="trailer" href="#trailer" data-toggle="tab">Trailer</a>
				</li>
			<?php endif; ?>
			<?php if($item->item_url_mpeg && $item->premiumYN!=='y') : ?>
				<li>
					<a rel="play" href="#play" data-toggle="tab">Play</a>
				</li>
			<?php endif; ?>
			<li>
				<a rel="top_view" href="#top_view" data-toggle="tab">Top View</a>
			</li>
			<li>
				<a rel="comment" href="#comment" data-toggle="tab">Rating</a>
			</li>
		</ul>
		<div class="tabcontents">
			<?php if($item->item_url_mpeg_trailer) : ?>
				<div id="trailer" class="tabcontent">
					<div id='playertrailer'></div>
				</div>
			<?php endif; ?>
			<?php if($item->item_url_mpeg && $item->premiumYN!=='y') : ?>
				<div id="play" class="tabcontent">
					<div id='playerfull'></div>
				</div>
			<?php endif; ?>
			<div id="top_view" class="tabcontent">
				<div class="uz-container-2">
					<div class="uz-container-2-content" id="topviewbox"></div>
				</div>
			</div>
			<div id="comment" class="tabcontent">
				<div id='commentbox'></div>
				<div id='pagination'></div>
			</div>
		</div>
	</div>
</div>


<div class="modal hide fade" id='ModalComment' style="height: 240px; width: 440px;">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h2>Berikan Rating</h2>
	</div>
	<div class="modal-body" style="padding-left:0">
		<div id='comment-form-container'>
			<table class="table">
				<tr>
					<td>
						<label>Rating</label>

						<?php for($i=1;$i<=10;$i++): ?>
							<?php if($i%2==1) : ?><span class="empty-star"><?php endif; ?>
							<span onclick="javascript:setRatingStarSelected(<?php echo $i?>);" class="star" id="<?php echo ($i);?>" title="<?php echo $i?>"></span>
							<?php if($i%2==0) : ?></span><?php endif; ?>
						<?php endfor;?>

					</td>
				</tr>

				<tr>
					<td>
						<button onclick="javascript:saveComment();" class='btn-success'>
							<i class="icon-chat"></i> Save Rating
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
    <script src="<?php echo config_item('assets_url'). 'js/jwplugin.js';?>"></script>
   <script type="text/javascript">
   var global_rating=0;
   var likelist='<?php echo $likelist?>';
   var view='',paid='';
   
    $(document).ready(function(){
        loadcomment(1);
        loadTopView();
        likebox();
        if(trailer) playtra();
        if(full && "<?php echo $item->premiumYN; ?>"!=="y") playfull();

        $('button#full').click(function(){
                if("<?php echo $item->premiumYN; ?>"=="y"){
                        if(!paid){
                                paid='full';
                                $.post("<?php echo base_url('movie/channel/pluspaid')?>", { id: id});
                        }
                        window.open(_get_file($(this).data('href')), '_blank');
                }else{
                        $('a[rel="play"]').click();
            playfull();
                }
        });
        $('#commentbutton').click(function(){
                $('a[rel="comment"]').click();
        });

        $('.star').tooltip('hide');
        if('<?php echo $islogin; ?>'=='') $('#commentbutton').tooltip('hide');
    });
	function playtra(){
		var img='<?php echo config_item('api_folder'); if($item->categories==='tovi'){ echo 'tovi'.$item->item_thumbnail_big; }else{ echo  'vod/'.$item->categories.'/'.$item->item_thumbnail_big;} ?>';
		play('playertrailer', 420,340, img, '<?php echo config_item('api_folder'); ?>movie/'+trailer);
	}
	function playfull(){
		var img='<?php echo config_item('api_folder'). 'vod/'.$item->categories.'/'.$item->item_thumbnail_big; ?>';
		play('playerfull', 420,340, img, _get_file(full));
	}

    function play(target, width, height, img, rtmp) {
        
        var is_desktop = "<?php echo $IS_DESKTOP;?>";
        var is_mobile = "<?php echo $IS_MOBILE;?>";
        
    
        if (is_mobile=='1'){
            setup_html5_video(target, img, rtmp, width, height);
        }else{
            setup_jw_player(target, img, rtmp, width, height);
        }
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
    
    function loadTopView(){
        $('#topviewbox').empty();
        $.post("<?php echo site_url('ajax/movie');?>",{func:'load_top_view',offset:0,limit:6},function(data){
            
            var s= '';
            if (data['found']>0){
                
                for(var i in data['items']){
                    var d = data['items'][i];
                    s= '<a class="tile square image" href="<?php echo base_url()?>movie/channel/detail/' + d.id + '">';
                        s+= '<div class="uz-thumb-small">';
                            s+= '<img src="'+ d.item_thumbnail + '">';
                            s+= '<div class="textover-wrapper transparent">';
                                s+= '<div class="text2">' + d.item_name.substr(0,15) + '<br><font size="2" color="#cccccc">' + d.director + '</font></div>';
                            s+= '</div>';
                        s+= '</div>';
                    s+= '</a>';
                    
                    $('#topviewbox').append(s);
                }
            }else{
                s ="<blockquote style='background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd'>";
                s+="<p id='kosong'><?php echo config_item('text_nodata'); ?></p>";
                s+="</blockquote>";
                s+="</div>";
                
                $('#topviewbox').html(s);
            }
        },'json');
    }
    
function loadcomment(page){
	var limit = 5;
	if (page==='undefined'||page<1) page = 1;
	$.post("<?php echo site_url('movie/channel/commentview');?>",{item_id:id, page:page,limit:limit},function(result){
		$('#commentbox').empty();
		var data = jQuery.parseJSON(result);
		if (data['found']>0){
			var start = parseInt(data['start']);
			for(var i in data['items']){
				var d = data['items'][i];
				var s = contentcomment(d);
				$('#commentbox').append(s);
			}
		}else{
			var s = "<div id='comment-one'>";
			s +="<blockquote style='background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd;'>"+
						"<p id='kosong'><?php echo config_item('text_norates'); ?></p>"+
					"</blockquote>";
			s +="</div>";
			$('#commentbox').append(s);
			
			$('#comment #pagination').empty();
		}
		
		$('#comment #pagination').html(data['pagination']);
	});
}
function contentcomment(d){
	var rat=parseInt(d['rating']);
	var s = "<div id='comment-one'>";
	s+="<blockquote style='background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd'>";
	s+= "<a href='mailto:"+d['email']+"' target='_blank'>"+d['u_name']+"</a>";
	for(var j=1;j<=5;j++){
		if(rat%2==1 && Math.round(rat/2)==j) s +="<span class='half-star-small'></span>";
		else if(Math.round(rat/2)>=j || Math.round(rat/2)==j) s +="<span class='full-star-small'></span>";
		else s +="<span class='empty-star-small'></span>";
	}
	//s+="<small>"+d['datetime']+"</small>";
	s+="</blockquote>";
	s +="</div>";
	return s;
}
function saveComment(){
	if (global_rating<0 || global_rating>10){
		alert('Rating harus antara 0 - 10');
		return;
	}
	var comment = $('textarea#comment').val();
	/*if (comment===''){
		alert('Anda belum kasih komentar');
		return;
	}*/
	$.post("<?php echo site_url('movie/channel/comment');?>",{id:id,comment:comment,rating:global_rating},function(result){
		if (result['status']==1){
			alert('Rating berhasil disimpan');
			$('textarea#comment').val('');
			$('#ModalComment').modal('hide');
			loadcomment(1);
		}else{
			alert('Rating gagal disimpan');
		}
	},'json');
}
function setRatingStarSelected(rating){
	global_rating = rating;
	$('span.star').each(function(index){
		$(this).parent('span').removeClass('empty-star');
		$(this).parent('span').removeClass('half-star');
		$(this).parent('span').removeClass('full-star');
	});
	$('span.star').each(function(index){
		var id=parseInt($(this).attr('id'));
		if(rating%2==1 && (id==rating || id==rating+1)) $(this).parent('span').addClass('half-star');
		else if(id<rating || (rating%2==0 && id==rating)) $(this).parent('span').addClass('full-star');
		else if(id>rating) $(this).parent('span').addClass('empty-star');
			
	});
}
function comment(){
	$('#ModalComment').modal('show');
}
function likebox(){
	if(likelist==0){
		$('#unlike').hide();
		$('#like').show();
	}else{
		$('#like').hide();
		$('#unlike').show();
	}
}
</script>

<?php if($islogin): ?>
<script>
function like(id){
	$.post("<?php echo base_url('movie/channel/like')?>/", {id:id}).success(function(){
		likelist=1;
		$('span[data=like]').html(parseFloat($('span[data=like]').html())+1);
		likebox();
	});
}
function unlike(id){
	$.post("<?php echo base_url('movie/channel/unlike')?>/", {id:id}).success(function(){
		likelist=0;
		$('span[data=like]').html(parseFloat($('span[data=like]').html())-1);
		likebox();
	});
}

   </script>
   <?php endif; ?>

