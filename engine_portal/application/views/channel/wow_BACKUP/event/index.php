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
</style>
<!-- slide panel item-->
<script src="<?php echo config_item('assets_url'); ?>js/jquery.swipeplanes-1.2.min.js"></script>
<link href="<?php echo config_item('assets_url'); ?>css/style_slide_item-music.css" rel="stylesheet" type="text/css" />

<div class="uz-main-container-up">

     <div class="uz-container-1">  <!-- statis image menu wow by. Alex 8/5/2013-->
         <div class="uz-title-container"></div>
         <a href="<?php echo site_url('wow/channel/upload/'.$category->slug);?>"><img src="<?php echo config_item('image_url');?>channel/wow/<?php echo $image_big; ?>"></a>

     </div>

    <div class="uz-container-wrap"></div>
    <div class="uz-container-2">
        <div class="uz-title-container">Top 10 View</div>
        <div class="uz-container-2-content" id="top-view">
            
        </div>
    </div>
    <div class="uz-container-wrap"></div>
    <div class="uz-container-2">
        <div class="uz-title-container">Top 10 Rating</div>
        <div class="uz-container-2-content" id="top-rating">
            
        </div>
    </div>
</div>
<div class="uz-main-container-down" id="myslider-main">
    <div class='uz-title-container'></div>
    <div id='myslider1' class='myslider1'>
        <div id='myslider-content'>
        </div>
    </div>
</div>
<script>
    var event_id = "<?php echo $category->id; ?>";
    $(document).ready(function(){
        loadTopView();
        loadTopRating();
    });

    function doUpload(){
        var frm_upload = document.getElementById('frm-upload');
        frm_upload.submit();
    }

    function loadTopView(){
        $.post("<?php echo site_url('ajax/wow') ?>",{func:'get_top_view',category_id:event_id,offset:0,limit:10},function(data){
            $('#top-view').empty();

            if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var item_name = d['item_name'];
                    var img = '<?php echo config_item("userfiles"); ?>/wow/thumbnail/'+d['item_thumbnail'];
                    if (i <= 3){
                        s = "<a title='"+item_name+"' class='tile square image' style='background-color:#FFFFFF;' href='<?php echo base_url();?>wow/channel/detail/"+d['id']+"' title='" +item_name+"'>";
                        s += "<div class='uz-thumb-small'>";
                        s += "<img src='" + img + "' />";
                        s += "</div></a>";
                        $('div#top-view').append(s);      
                    } else {
                        
                        var s = "<div class='slide1 container-item'>";
                        s += "<a title='"+item_name+"' class='tile square image mob-uz-slider' style='background-color:#FFFFFF;' href='<?php echo base_url();?>wow/channel/detail/"+d['id']+"' title='" +item_name+"'>";
                        s += "<img src='" + img + "' class='rounded' width='142' height='142' />";
                        s += "</a></div>"; 

                        $('#myslider-content').append(s);
                    }
                }
            } else {
                $('div#top-view').html("<p><?php echo config_item('text_nodata'); ?></p>");
            }
            $('#myslider1').swipePlanes();
        },'json');
    }

    function loadTopRating(){
        $.post("<?php echo site_url('ajax/wow') ?>",{func:'get_top_rating',category_id:event_id,offset:0,limit:10},function(data){
            $('#top-rating').empty();

            if (data['found'] > 0) {
                for (var i in data['items']) {
                    var d = data['items'][i];
                    var item_name = d['item_name'];
                    var img = '<?php echo config_item("userfiles"); ?>/wow/thumbnail/'+d['item_thumbnail'];
                    if (i <= 3){
                        s = "<a title='"+item_name+"' class='tile square image' style='background-color:#FFFFFF;' href='<?php echo base_url();?>wow/channel/detail/"+d['id']+"' title='" +item_name+"'>";
                        s += "<div class='uz-thumb-small'>";
                        s += "<img src='" + img + "' />";
                        s += "</div></a>";
                        $('div#top-rating').append(s);      
                    } else {
                        
                        var s = "<div class='slide1 container-item'>";
                        s += "<a title='"+item_name+"' class='tile square image mob-uz-slider' style='background-color:#FFFFFF;' href='<?php echo base_url();?>wow/channel/detail/"+d['id']+"' title='" +item_name+"'>";
                        s += "<img src='" + img + "' class='rounded' width='142' height='142' />";
                        s += "</a></div>"; 

                        $('#myslider-content').append(s);
                    }
                }
            } else {
                $('div#top-rating').html("<p><?php echo config_item('text_nodata'); ?></p>");
            }
            $('#myslider1').swipePlanes();
        },'json');
    }

    function calculate_width(item_class){
        var w = 0;
        $(item_class).each(function(){
            w+= parseInt($(this).width());
        });

        return w;
    }
</script>