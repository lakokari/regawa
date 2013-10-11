<meta name="title" content="<?php echo $item->name; ?> - <?php echo config_item('meta_title_suffix');?>" />
<meta name="keywords" content="<?php echo $item->name; ?> - <?php echo config_item('meta_title_suffix');?>" />
<meta name="description" content="Book > <?php echo $item->name; ?>, <?php echo $item->description; ?>" />
<link rel="image_src" href="<?php echo $item->thumbnail_url; ?>" />
<!-- tab -->
<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />
<style>
.panorama-section img {
    height: auto;
    width: auto;
}

    #landing-page-book {
        background: white;
        color: #000;
    }
    ul.comment{margin: 0; padding: 0; list-style: none;}
    ul.comment li{
        width: 100%;
        float: left;
        margin-top: 10px;
        clear: right;
    }
    ul.comment li:first-child{margin-top: 0;} 
    .metro .tile.wide.imagetext.book {
        margin:0;
        border:none;
        width:90px;
        height:135px;
    }

    .metro .tile.bigposter.wide.image {
        width:324px;
        height:405px;
    }
    .metro .tile.bigposter.wide.image img {
        max-width:324px;
        max-height:405px;
    }

    #book-container-cat {display : none;}
    
    .detail-containter-book  {
        width: 100%;
        height: 270px;
    }
    .metro .tile.wide.imagetext.book {
        margin:0;
        border:none;
        width:90px;
        height:135px;
    }

    .deskripsi-book {
        width : 100%;
        height: auto;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    #download-book {
        display: none;
        width: auto;
        height: auto;
        float: left;
    }
    #book-checkout {
        display : none;
    }

    .uz-comment-content{
        width: 320px;
        height: auto;
    }

    .uz-container-2 {
        width: 320px;
        height: 340px;
        float : left;
        /*border : 1px solid #000;*/
    }

    .uz-container-wrap {
        width: 60px;
        height: 340px;
        float : left;
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
    a.rating { color:#fff; text-decoration: underline} 
</style>

<!-- by aldi-->
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
    
    .uz-container-1 {
        width: 480px;
        height: 340px;
        float : left;
        margin-right: 45px;
       
    }
    .uz-container-1-content {
        width: 480px;
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

    .book-ck 
    {
        width: 800px;
        height: 500px;
        padding: 10px;
        text-align: center;
        float: left;
        margin-left: -30%;
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
        width : 101px;
        height: 111px;
        float : left;
        border : 1px solid #fff;
    }
    .uz-btm-small img {
        width : 101px;
        height: 111px;
    }



.panorama .panorama-sections .panorama-section.tile-span-5 {
    width: 480px;
    margin-left: 0px;
}
	#comment-form-container {
    	border: 1px solid #333;
    	margin-left: 20px;
    	margin-bottom: 20px;
    }
    
</style>
    <div class="uz-main-container-up">
        <div class="uz-container-1">
            <div class="detail-containter-book">
                <table width="100%">
                    <tr>
                        <td valign="top">
                                <img src="<?php echo $item->thumbnail_url; ?>">
                        </td>
                        <td valign="top">
                            <table width="85%" align="right">
                                <tr>
                                    <td width="30%">Judul</td>
                                    <td width="70%"><?php echo $item->name; ?></a></td>
                                </tr>
                                <tr>
                                    <td>Author</td>
                                    <td><?php echo $item->author; ?></td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td><?php echo $item->category_name; ?></td>
                                </tr>
                                <tr>
                                    <td>Publish Date</td>
                                    <td><?php echo $item->publish_date; ?></td>
                                </tr>
                                <tr>
                                    <td>Publisher</td>
                                    <td><?php echo $item->sub_publisher_name; ?></td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>Rp. <?php echo number_format($item->price,0,',','.'); ?>,-</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <!-- AddThis Button BEGIN -->
                                        <div class="addthis_toolbox addthis_default_style ">
                                            <a class="addthis_counter addthis_pill_style"></a>
                                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                            <a class="addthis_button_tweet"></a>
                                        </div>
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51de9ac26202a940"></script>
                                        <!-- AddThis Button END -->
                                    </td>
                                </tr>
                                <tr> 
                                    <td colspan="2" height="80px">
                                    <?php if ($item->price == 0) { ?>
                                    <a href="#" class="btn btn-small btn-success" id="download-book-button" onclick="showDownloadInfo();">Download</a>
                                    <?php } else { ?>
                                    <a onclick="showModalBuy();" class="btn btn-small btn-warning">Download</a>
                                    <?php } ?>

                                        <button onclick="comment('<?php echo $item->content_id_token;?>');" class='btn-success'>
                                            <i class="icon-chat"></i> <!-- Comment & -->Rating
                                        </button>
                                    </td> 
                                </tr>
                                <tr>
                                   <td colspan="2">
                                        <div id="download-book">
                                            <p>Silahkan download buku ini dengan masuk ke aplikasi QBaca di Smartphone Anda</p>
                                            <div style="width: 130px; float : left; margin-right: 10px;">
                                                <a target="_blank" href="https://play.google.com/store/apps/details?id=com.access_company.android.ai_qbaca_telkom"><img src="<?php echo config_item('assets_url'); ?>css/img/button_playstore.png" width="100"></a>
                                            </div>
                                            <div style="width: 130px; float : left;">
                                                <a target="_blank" href="https://itunes.apple.com/id/app/qbaca/id584314511?mt=8"><img src="<?php echo config_item('assets_url'); ?>css/img/button_appstore.png" width="100"></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>


            </div>
        </div>

            <div class="tab-container uz-container-2" style="margin-left:-40px;">
                <ul class="tabs" persist="true">
                    <li class="selected"><a href="#" rel="view1">Description</a></li>
                    <li><a href="#" rel="view2"><!-- Comment & -->Rating</a></li>
                </ul>
                <div class="tabcontents">
                    <div id="view1" class="tabcontent">
                        <table width="100%">
                            <tr>
                                <td>
                                    <?php
                                        if($item->description) {
                                            echo "<p>".$item->description."</p>";
                                        } else {
                                            echo "<p><i>Tidak Ada Deskripsi.</i></p>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="view2" class="tabcontent">
                        <div class="uz-comment-content" id='comment'>
                                <div id='commentbox' style='height:auto;'>
                                                
                                </div>     
                                <div id='pagination' style="margin-top:20px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal hide fade book-ck" id="book-checkout">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><br>
            </div>
            <iframe id="book_checkout" class="frame-checkout" name="frame-checkout" width="96%" height="460" scrolling="yes" frameborder="1"></iframe>
        </div>
        <div class="panorama-section tile-span-2">
    <div class="uz-container-2">
        <div class="uz-title-container">New Release</div>
        <div class="uz-container-2-content" id="new-release">
            
        </div>
    </div>
</div>

<!-- modal comment -->
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
<!--                 <tr>
                    <td>
                        <label>Komentar Anda</label>
                        <textarea name="comment" id="comment" class="span4" maxlength="254"></textarea>
                    </td>
                </tr> -->
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


<!-- modal buy -->

<div class="modal hide fade" id='ModalBuy'>
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h3 style="margin-top:10px;">Login</h3>
    </div>
    <div class="modal-body">
    <form action="javascript:loginQbaca();">
        <table class="table">
                <tr>
                    <td width="30%">
                        <label>Email</label>
                    </td>
                    <td>
                        <input type="text" id="username" name="username" placeholder="Email Address">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Password</label>
                    </td>
                    <td>
                        <input type="password" id="password" name="password" placeholder="Password">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="http://qbaca.com/user/forgotPass" style="color:#666" target="blank">Forgot Password</a> | <a href="http://qbaca.com/user/signup" style="color:#666" target="blank">Create an Account</a>
                    </td>
                </tr>
            </table>
    </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript:loginQbaca();" class="btn btn-primary">Login</a>
    </div>
</div>
    </div>
</div>

    

<script>
    var category_active = "<?php echo $category;?>";
    var is_loggedin = "<?php echo ($this->user_m->is_loggedin()?1:0); ?>";
    var email_qbaca = "<?php echo $this->session->userdata('qbaca_email'); ?>";
    var active_token_id = "<?php echo ($item->content_id_token); ?>";
    var global_rating=0;
    $(document).ready(function(){
        loadcomment(active_token_id, 1);
        loadNewRelease();

        $('#kategory-buku li a').click(function(){
            loadBookByCategory($(this).attr('name'), $(this).html());
	});
        
        $('#my-modal').on('hidden', function () {
            $('#modal-body').empty();
        });
    });
    
    function showCheckoutBook(url){
        $('#panorama-scroll-next').click();
        $('#book-checkout').modal('show');
        $('iframe#book_checkout').attr('src', url);
        
    }
    
    function comment(id){
        if (is_loggedin!=='1'){
            alert('Anda belum login. Anda akan dibawa ke halaman login');
            $('#settings').click();
        }else{
        $('#ModalComment').modal('show');
        
        }   
    }

    function showModalBuy(){
        if(email_qbaca){
        var buy_url = 'http://qbaca.com/bookContent/checkout?email='+email_qbaca+'&cid='+active_token_id;
        showCheckoutBook(buy_url);
        }else{
        $("#ModalBuy").modal('show');
        }
    }

    function loadcomment(id, page){
        $('#comment').show();
        var limit = 4;
        if (page==='undefined'||page<1) page = 1;
        $.post("<?php echo site_url('book/detail/commentview');?>",{id:id, page:page,limit:limit},function(result){
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
                s +="<blockquote style='background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd'>"+
                            "<small id='kosong'>No Rating</small>"+
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
        s+= "<a>"+d['u_name']+"</a>";
		for(var j=1;j<=5;j++){
			if(rat%2==1 && Math.round(rat/2)==j) s +="<span class='half-star-small'></span>";
			else if(Math.round(rat/2)>=j || Math.round(rat/2)==j) s +="<span class='full-star-small'></span>";
			else s +="<span class='empty-star-small'></span>";
		}
		s+="</blockquote>";
        s +="</div>";
        return s;
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

    function saveComment(){
        if (global_rating<0 || global_rating>10){
            alert('Rating harus antara 0 - 10');
            return;
        }
        var comment = $('textarea#comment').val();
        // if (comment===''){
        //     alert('Anda belum kasih komentar');
        //     return;
        // }
        $.post("<?php echo site_url('book/detail/comment');?>",{id:active_token_id,comment:comment,rating:global_rating},function(result){
            if (result['status']==1){
                alert('Rating berhasil');
                $('textarea#comment').val('');
                $('#ModalComment').modal('hide');
                loadcomment(active_token_id, 1);
            }else{
                alert('Rating gagal');
            }
        },'json');
    }

function loginQbaca(){
    var username = $('input#username').val();
    if (username===''){
        alert('username kosong');
        return;
    }

    var password = $('input#password').val();
    if (password===''){
        alert('password kosong');
        return;
    }

    $.post("<?php echo site_url('ajax/book');?>",{func:'login_qbaca',email:username,password:password,cid:active_token_id},function(result){
        if (result['status']==1){
            showCheckoutBook(result['url']);
            //$('textarea#comment').val('');
            $('#ModalBuy').modal('hide');
            //loadcomment(content_id_token, 1);
        }else{
            alert(result['message']);
        }
    },'json');
}

    function showDownloadInfo(){
        $('#download-book').toggle();
    }
    function loadBookByCategory(categoryId, titlebuku){
        window.location = "<?php echo site_url('book/channel/index');?>/"+categoryId;
    }
    
    function loadNewRelease(){
        var category = 'New Release';
        var target  = '';
        
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
                    s+= "<img src='<?php echo config_item('api_sync').'book/'; ?>"+d['thumbnail_url']+"'/>";
                    s+= "</div>";
                    s+= "</a>";

                    $('#new-release').append(s);
                }
                
            }else{
                $('#new-release').append("No data");
            }
        });
    }

</script>