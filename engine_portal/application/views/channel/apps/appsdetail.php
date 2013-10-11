<meta name="title" content='<?php echo $item->package_name; ?> - <?php echo config_item('meta_title_suffix'); ?>' />
<meta name="keywords" content='<?php echo $item->package_name; ?> - <?php echo config_item('meta_title_suffix'); ?>' />
<meta name="description" content='<?php echo $item->description; ?> - <?php echo config_item('meta_title_suffix'); ?>' />
<link rel="image_src" href="<?php echo $item->icon_url; ?>" />
<!-- modal -->
<script type="text/javascript" src="<?php echo config_item('assets_url'); ?>js/jquery.cool.dialog.js"></script>
<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>css/cool_dialog.css" />
<!-- tab -->
<script src="<?php echo config_item('assets_url'); ?>js/tabcontent.js" type="text/javascript"></script>
<link href="<?php echo config_item('assets_url'); ?>css/tabbed_content.css" rel="stylesheet" type="text/css" />
<style>
    /************  style ini yang dipakai ****************/
    .uz-main-container-up {
        width: 1200px;
        height: auto;
        padding-left: 60px;
        float : left;
    }
    .uz-main-container-down {
        width: 1200px;
        height: 200px;
        padding-left: 60px;
        float : left;
        margin-top: 5px;
    }
    .uz-title-container {
        width: 380px;
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
    .pict1{
        width:auto;
        height:190px;
    }
    .pict1 img{
        width: auto;
        height: 190px;
        padding-left: 105px;
        padding-right: 105px;
        background-color: #000000;
    }
    .text2{
        width: 400px;
        height: 100px;
        padding-top: 20px;
    }
    .mob-image-detail img{
        width: 118px;
        height: 118px;
    }
    .pc-image-detail img{
        width: 118px;
        max-height: 200px;
    }
    .uz-detail-container-apps{
        width: 400px;
        height: auto;
    }
    .uz-comment-content{
        width: 320px;
        height: auto;
    }
    p{
        color:#666;
    }
    
    #comment-form-container {
    	
    	border: 1px solid #333;
    	margin-left: 20px;
    	margin-bottom: 20px;
    }
</style>
<style>
    #player{max-width: 755px;}
    span.rating, span.customer{display: block; color: #0081c2; font-weight: bold;}
    span.comment {display: block; color: #515151;margin-top: 10px;}
    
    ul.comment{margin: 0; padding: 0; list-style: none;}
    ul.comment li{
        width: 100%;
        float: left;
        margin-top: 10px;
        clear: right;
    }
    ul.comment li:first-child{margin-top: 0;}
    .star{cursor: pointer;}
    .star_transparent{opacity:0.4;filter:alpha(opacity=40);}


    #landing-page-apps {
        background: white;
        color: #000;
    }
    
    #apps-container-cat {display : none;}
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
<div class="uz-main-container-up" id="landing-page-apps">
    <div class="uz-container-1">
        <div class="uz-container-1-content">
            <div class="uz-detail-containter-apps">
                <table width="100%">
                    <tr>
                        <td width="30%" valign="middle">
                            <?php
                                if ($item->parent_id == 1) {
                                    echo "<div class='pc-image-detail'>";
                                } else {
                                    echo "<div class='mob-image-detail'>";
                                }
                            ?>
                                <img src="<?php echo config_item('api_sync').'apps/'; ?><?php echo $item->icon_url; ?>">
                            </div>
                        </td>
                        <td width="70%" valign="top">
                            <table width="90%" align="right">
                                <tr>
                                    <td>Name</td>
                                    <td><?php echo $item->package_name; ?></td>
                                </tr>
								<tr>
								    <td>Device</td>
								    <td><?php  echo $device_type; ?></td>
								</tr>
								<tr>
								    <td>Kategori</td>
								    <td><?php echo $categories->category_name; ?></td>
								</tr>
                                <tr>
                                    <td>Developer</td>
                                    <td><?php echo $item->developer_or_publisher; ?></td>
                                </tr>
                                <tr>
                                    <td>Version</td>
                                    <td><?php echo $item->version; ?></td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <?php if($item->price==0){$price = "free";}else{$price = "Rp.".$item->price."";} ?>
                                    <td><?php echo $price;?></td>
                                </tr>
                                <tr>
                                    <td>Rating</td>
                                    <td>
                                        <?php
                                        $rat = $item->rating;
                                        for($j=1;$j<=5;$j++){
                                            if($rat%2 == 1 && ceil($rat/2)==$j) echo "<span class='half-star-small'></span>"; //s +="<span class='half-star-small'></span>";
                                            else if(ceil($rat/2)>=$j || ceil($rat/2)==$j) echo "<span class='full-star-small'></span>";
                                            else echo "<span class='empty-star-small'></span>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php $PC = 1; $MOB = 2; ?>
                                    <?php if ($item->parent_id == $PC){ ?>
                                        <td>Purchased</td>
                                    <?php } else { ?>
                                        <td>Downloaded</td>
                                    <?php } ?>
                                    <td><?php echo $item->download_count; ?></td>
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
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <?php
                            if ($item->parent_id == $PC){
                                echo "<td colspan='2'><button onclick='window.open(\"".$item->telkomstore_link."\")' target='_blank' class='btn btn-small btn-warning' >Download</button> | <button class='btn btn-small btn-warning' onclick='javascript:showModalPC();'>Cara Download</button> | <button onclick=\"giveRating('<?php echo $item->id; ?>')\" class='btn-small btn-success'>
                                    <i class=\"icon-chat\"></i> Rating
                                </button>
                                </td>";
                            } else {
                                echo "<td colspan='2'><button onclick='window.open(\"".$item->telkomstore_link."\")' target='_blank' class='btn btn-small btn-warning' >Download</button> | <button class='btn btn-small btn-warning' onclick='javascript:showModalMOB();'>Cara Download</button> | <button onclick=\"giveRating('<?php echo $item->id; ?>')\" class='btn-small btn-success'>
                                    <i class=\"icon-chat\"></i> Rating
                                </button>
                                </td>";
                            }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="uz-container-wrap"></div>
    <div class="tab-container uz-container-2">
        <ul class="tabs" persist="true">
            <li class="selected"><a href="#" rel="view1">Description</a></li>
            <li><a href="#" rel="view2">Rating</a></li>
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
                    
                        <div id='commentbox' style='overflow-y:auto;height:253px;'>
                                        
                        </div>     
                        <div id='pagination'></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="uz-container-wrap"></div>
    
    <div class='panorama-section'>
        <div class='uz-container-2'>
            <?php
            if ($item->parent_id == 1){
                echo "
                    <div class='uz-title-container'>Top PC Content</div>
                    <div class='uz-container-2-content' id='top-web-content'>
                                    
                    </div>
                ";
            }else{
                echo "
                    <div class='uz-title-container'>Top Mobile Content</div>
                    <div class='uz-container-2-content' id='top-mob-content'>
                                    
                    </div>
                ";
            }
            ?>
        </div>
    </div>
</div>
<div id="myModalPC" class="modal hide fade" style='height:360px;width:640px;padding:5px 5px 5px 5px;'>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h1>Cara Download</h1>
    <p>Konten ini adalah konten berbayar dengan pembayaran melalui tagihan bulanan Speedy. Untuk membelinya, ikuti petunjuk berikut:</p>
    <br />
    <ol>
        <li>Klik tombol “Download” pada halaman ini.</li>
        <li>Anda akan dialihkan ke halaman Webstore yang meminta Login dengan Telkom ID atau Register jika Anda belum memiliki Telkom ID. Ikuti petunjuk yang tertera pada halaman tersebut.</li>
        <li>Status pembelian konten akan diinformasikan melalui email Anda.</li>
    </ol>
</div>
<div id="myModalMOB" class="modal hide fade" style='height:360px;width:640px;padding:5px 5px 5px 5px; overflow-y: auto;'>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h1>Cara Download</h1>
    <p>Konten ini adalah konten untuk Android. Untuk mendownloadnya, pastikan handset Anda sudah terinstall aplikasi Telkomstore.<p>
    <br />
    <h3>Cara Install Aplikasi Telkomstore pada handset Android</h3>
    <ol>
        <li>Download file telkomstore.apk di <a href="http://www.telkomstore.com/app" target="_blank">www.telkomstore.com/app</a></li>
        <li>Jika muncul warning box “install blocked” pilih setting, lalu check box Unknown sources Allow installation of non-market application, pilih OK, lalu ulangi download/instalasi </li>
        <li>Install apk open TelkomStore.apk </li>
        <li>Muncul question box "TelkomStore requires internet access For further information, please read terms and condition" klik OK </li>
        <li>Terima SMS info terdaftar beserta username dan password untuk login via website.</li>
    </ol>

    <p>Anda dapat melanjutkan download melalui website ini atau langsung pada aplikasi Telkomstore yang telah terinstall dengan memasukkan username dan password. </p>
    <br />
    <h3>Pembayaran</h3>
    
    <p>Khusus untuk konten non-free, Anda akan dikenakan tarif sekali bayar dengan potong pulsa untuk prabayar dan tagihan untuk pascabayar. Anda akan diberikan konfirmasi sebelum pembelian. Aplikasi kami mendukung operator Telkomsel, Flexi,  Telin Hongkong, atau Telkomcel Timor Leste.</p>
    <br />
    <h3>Pertanyaan dan Keluhan</h3>
    <p>Anda dapat menyampaikan pertanyaan dan keluhan melalui Call Center operator Anda.</p>
</div>

<!-- beri komen-->
<div id="myModal" class="modal hide fade" style='height:240px;width: 440px;'>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h2 id="myModalLabel">Berikan Rating</h2>
    </div>
    <div class="modal-body" style='padding-left:0'>
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
<script>
    var global_rating = 0;
    //we need to know if user is loggedin
    var is_loggedin = "<?php echo ($this->user_m->is_loggedin()?1:0); ?>";
    var package_id = "<?php echo $item->package_id; ?>";
    var PC = 1;
    var MOB = 2;
    var img_url="<?php echo config_item('api_sync').'apps/'; ?>";

    $(document).ready(function(){
        loadTopDownMob();
        loadTopDownPC();
        loadSubCat();
        loadcomment(package_id,1);
        $('#device li a').click(function(){
            loadSubCat($(this).attr('data'));
         });
        
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
        $('.star').tooltip('hide');
    });


    function showModalPC(){
        $('#myModalPC').modal();
    }

    function showModalMOB(){
        $('#myModalMOB').modal();
    }

    function loadTopDownMob(){
        $.post("<?php echo site_url('ajax/apps') ?>",{func:'top_download_mob',offset:0,limit:9},function(data){
        $('#top-mob-content').empty();
        if (data['found'] > 0) {
            for (var i in data['items']) {
                var d = data['items'][i];
                var package_name = d['package_name'];
                var s = "<a title='"+package_name+"' style='background-color:#FFFFFF;' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                s += "<div class='mob-uz-thumb-small'>";
                s += "<img src='" + img_url + d['icon_url'] + "' />";
                s+= "</div></a>";

                $('div#top-mob-content').append(s);
            }        
        } else {
            $('div#top-mob-content').append("<p><?php echo config_item('text_nodata'); ?></p>");
        }
        },'json');
    }

    function loadTopDownPC(){
        $.post("<?php echo site_url('ajax/apps') ?>",{func:'top_download_web',offset:0,limit:6},function(data){
        $('#top-web-content').empty();        
        if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var package_name = d['package_name'];

                    var s = "<a title='"+package_name+"' style='background-color:#FFFFFF;' href='<?php echo base_url();?>apps/detail/apps/"+d['parent_id']+"/"+d['package_id']+"' title='" +package_name+"'>";
                    s += "<div class='pc-uz-thumb-small'>";
                    s += "<center><img src='" +img_url + d['icon_url'] + "' /></center>";
                    s += "</div></a>";

                    $('div#top-web-content').append(s);
                }
                
            } else {
                $('div#top-web-content').append("<p><?php echo config_item('text_nodata'); ?></p>");
            }
        },'json');
    }

    function loadSubCat(parent_id){
        $('#loader-subcat').show();        
        
        $.post("<?php echo site_url('ajax/apps');?>",{func:'category_list',parent_id:parent_id},function(result){
        
            $('#cat-container').empty();
            
            var data = jQuery.parseJSON(result);
            if (data['found']>0){
                for (var i in data['items']){
                    var d = data['items'][i];
                    
                    var sub = d['category_name'].substring(0,20);
                    if (parent_id == 1) {
                        var s = "<li><a href='#' onclick='redir("+d['parent_id']+","+d['category_id']+");' data='"+d['category_id']+"' title='"+d['category_name']+"'>"+sub+"</li>";
                    } else {
                        var s = "<li><a href='#' onclick='redir("+d['parent_id']+","+d['category_id']+");' data='"+d['category_id']+"' title='"+d['category_name']+"'>"+sub+"</li>";
                    }

                    $('#cat-container').append(s);
                }
                
            }
            
            
            
            $('#loader-subcat').hide();
        });
    }

    function redir(parent_id,category_id){
        window.location='<?php echo base_url('apps/channel')?>#content/'+parent_id+'/'+category_id;
    }

    function comment(){
        $('#ModalComment').modal('show');
        loadcomment(package_id, 1);
        $('#comment').show();
    }

    function loadcomment(package_id, page){
        var limit = 5;
        if (page==='undefined'||page<1) page = 1;
        $.post("<?php echo site_url('apps/channel/commentview');?>",{item_id:package_id, page:page,limit:limit},function(result){
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
                s +="<blockquote style='color:#666;background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd'>"+
                            "<small id='kosong' style='color:#666;'>No Rating available</small>"+
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
        var s = "<div id='comment-one' style='color:#666;'>";
        s += "<blockquote style='background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd'>";    
        //s+= "<a href='mailto:"+d['email']+"' target='_blank' class='btn btn-inverse'>"+d['email']+"</a>";
        s += d['u_name'];
        for(var j=1;j<=5;j++){
            if(rat%2==1 && Math.round(rat/2)==j) s +="<span class='half-star-small'></span>";
            else if(Math.round(rat/2)>=j || Math.round(rat/2)==j) s +="<span class='full-star-small'></span>";
            else s +="<span class='empty-star-small'></span>";
        }
        /*
        s +="<blockquote style='background:none;padding:3px;margin-top:1px;margin-bottom:3px;border:1px solid #ddd'>"+
                "<p style='font-size:12px;'>"+d['comment']+"</p>"+
                "<small>"+d['datetime']+"</small>"+
            "</blockquote>";
            */
        s += '</blockquote>';    
        s +="</div>";
        return s;
    }

    /* function to save comment */
    function saveComment(){
        if (global_rating<0 || global_rating>10){
            alert('Rating harus antara 0 - 10');
            return;
        }
        var comment = 'comment saya';
        $.post("<?php echo site_url('ajax/apps');?>",{func:'apps_save_comment',package_id:package_id,comment:comment,rating:global_rating},function(result){
            if (result['status']==1){
                $('#commentbox').empty();
                loadcomment(package_id,1);
                alert('Rating berhasil dikirim');
                $('textarea#comment').val('');
                $('#myModal').modal('hide');
            }else{
                alert('Rating gagal dikirim (package_id' +result['item']['package_id']+')');
            }
        },'json');
    }

    /* function to create rating */
    function giveRating(package_id){
        if (is_loggedin!=='1'){
            alert("<?php echo config_item('text_no_login'); ?>");
            $('#settings').click();
        }else{
            $('#myModal').modal();
        }
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
    
</script>