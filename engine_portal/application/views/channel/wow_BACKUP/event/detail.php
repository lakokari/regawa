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
    .uz-container-2-wide {
        width: 700px;
        height: auto;
        float : left;
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
    .wow-uz-thumb-big {
        width : 236px;
        max-height: 314px;
        float : left;
        border : 1px solid #fff;
    }
    .wow-uz-thumb-big img {
        width : 236px;
        max-height: 314px;
        padding-top: 39px;
        padding-bottom: 39px;
        background-color: #CFCFCF;
    }
    .blok-paragraph {
        width: 100%;
        float : left;
        height: auto;
    }
    .rating-wow-scroll {
        width: 100%;
        height: 320px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    .item-rating-container {
        width: auto;
        margin-right: 20px;
        margin-bottom: 20px;
        border : 1px solid #95a6ae;
        border-radius: 5px;
        height: auto;
        padding: 20px;
    }
    .rating-border {
        width: 100%;
        height: auto;
        border-bottom: 1px solid #95a6ae;
        padding-bottom: 5px;
    }
    .comment-rating {
        width: 100%;
        height: auto;
        margin-top: 5px;
    }
    .full-star-small {
        background: url('<?php echo config_item('assets_url');?>img/star/Full-Star-small.png') no-repeat;
        width: 18px;
        height: 18px;
        display: inline-block;
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

<!-- modal -->
<script type="text/javascript" src="<?php echo config_item('assets_url'); ?>js/jquery.cool.dialog.js"></script>
<link rel="stylesheet" href="<?php echo config_item('assets_url'); ?>css/cool_dialog.css" />

<div class="uz-main-container-up">
     <div class="uz-container-1">
         <div class="uz-title-container"></div>
         <div id="player"></div>
     </div>

    <div class="uz-container-wrap"></div>
    <div class="uz-container-2-wide">
        <div class="uz-title-container" style="width: 100%; margin-bottom: 10px;">
            WOW > Uzone <?php echo ucwords($category->name);?> > <?php echo $item->item_name; ?>
        </div>
        <div class="blok-paragraph">
            <p>Vote : Did you like this movie digital idol ?</p>
            <p>Vote this movie : </p>
            <p>
                <button onclick="javascript:giveRating('<?php echo $item->id; ?>');" class='btn-small btn-success'>
                    <i class="icon-chat"></i> Rating
                </button>
            </p>
            <!-- Like -->
            <span data='like'><?php echo $item->item_like_count?></span> Likes
                <?php if($is_loggedin): ?>
                    <div class="btn-group" id='unlike'>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:unlike('<?php echo $item->id?>')">Unlike</a></li>
                        </ul>
                        <a class="btn dropdown-toggle btn-mini" data-toggle="dropdown">Liked</a>
                    </div>
                    <a href="javascript:like('<?php echo $item->id?>')" class="btn btn-mini" id='like'><i class="icon-thumbs-up-2"></i> Like</a>
                <?php endif; ?>
            <p>Rating </p>
            <div class="rating-wow-scroll" id="rating-wow-list"><!-- content comment & rating list filled by ajax--></div>
        </div>
    </div>
</div>
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
    var item_id = "<?php echo $item->id;?>";
    var likelist = "<?php echo $likelist; ?>";
    
    $(document).ready(function(){
        loadRating(item_id, 1);
        likebox();
        //play video
        jwplayer("player").setup({
            file: '<?php echo config_item('userfiles').'wow/'.$item->item_url; ?>',
            image: '<?php echo config_item('userfiles').'wow/thumbnail/'.$item->item_thumbnail; ?>',
            autostart: false,
            'modes': [
                {type: 'flash', src: "jwplayer.flash.swf"},
                {type: 'html5'}
            ],
            height: 340,
            width: 420
	    });
        $('.star').tooltip('hide');
    });

    /* function untuk like & unlike */
    function likebox(){
        if(likelist==0){
            $('#unlike').hide();
            $('#like').show();
        }else{
            $('#like').hide();
            $('#unlike').show();
        }
    }

    function like(item_id){
        $.post("<?php echo base_url('wow/channel/like')?>/", {item_id:item_id}).success(function(){
            likelist=1;
            $('span[data=like]').html(parseFloat($('span[data=like]').html())+1);
            likebox();
        });
    }
    function unlike(id){
        $.post("<?php echo base_url('wow/channel/unlike')?>/", {item_id:item_id}).success(function(){
            likelist=0;
            $('span[data=like]').html(parseFloat($('span[data=like]').html())-1);
            likebox();
        });
    }

    /* function untuk comment & rating */
    function comment(){
        $('#ModalComment').modal('show');
    }

    /* function to create rating */
    function giveRating(item_id){
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

    /* function to save comment */
    function saveComment(){
        if (global_rating<0 || global_rating>10){
            alert('Rating harus antara 0 - 10');
            return;
        }
        var comment = 'comment saya';
        $.post("<?php echo site_url('ajax/wow');?>",{func:'wow_save_comment',item_id:item_id,comment:comment,rating:global_rating},function(result){
            if (result['status']==1){
                $('#commentbox').empty();
                loadRating(item_id,1);
                alert('Rating berhasil dikirim');
                $('textarea#comment').val('');
                $('#myModal').modal('hide');
            }else{
                alert('Rating gagal dikirim (item_id' +result['item']['item_id']+')');
            }
        },'json');
    }

    function loadRating(item_id, page){
        //set default page number
        if (page!==undefined || parseInt(page)<=0)
            page = 1;
        
        //call ajax request
        $.post('<?php echo site_url('ajax/wow'); ?>',{func:'get_rating_list',wow_id:item_id,page:page,limit:20},function(data){
            
            $('#rating-wow-list').empty();
            
            if (data['found']>0){
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<div class="item-rating-container">';
                        s+= '<div class="rating-border">';
                            //create loop for showing star
                            s+= drawStars(parseInt(d['rating']));

                            //show sender name
                            s+= 'diberikan oleh '+ d['u_name'];

                            //Comment text view
                            /*
                            s+= '<div class="comment-rating">';
                                s+= d['comment'];
                            s+= '</div>';
                            */
                        s+= '</div>';
                    s+= '</div>';
                    $('#rating-wow-list').append(s);
                }
            }else{
                $('#rating-wow-list').append('<p>No rating for now</p>');
            }
        },'json');
    }
    
    function drawStars(rating_val){
        var s = '';
        for(var j=1;j<=5;j++){
            if(rating_val%2===1 && Math.round(rating_val/2)===j) 
                s +="<span class='half-star-small'></span>";
            else if(Math.round(rating_val/2)>=j || Math.round(rating_val/2)===j) 
                s +="<span class='full-star-small'></span>";
            else 
                s +="<span class='empty-star-small'></span>";
	   }
        
        return s;
    }

    
</script>