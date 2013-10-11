<script type="text/javascript">
$(document).ready(function(){
    create_loader('my-uz-loader');
});
function setItemAsFeatured(channel_id, item_id){
    $.post("<?php echo site_url('ajax/cms'); ?>",{func:'set_as_featured',channel_id:channel_id,item_id:item_id,callback:true},function(result){
        if (parseInt(result)>0){
           $('a#a_'+item_id).parent().append('<i class="icon-thumbs-up" title="Is featured"></i>');
           $('a#a_'+item_id).remove();
        }
    });
}

function create_loader(id)
{
    if ($('div#'+id).length===0){
        //create loader-bg
        var s="<div id='"+id+"' class='loader-bg'></div>";
    
        $('body').append(s);
        
        //set width & height
        var window_w = $(window).width();
        var window_h = $(window).height();
        
        
        $('div#'+id).css('width',window_w+'px');
        $('div#'+id).css('height',window_h+'px');
        
        //append the loader
        $('div#'+id).append("<div id='loader-circle' class='loader'></div>");
        //set margin to put in the center
        $('div#loader-circle').css('margin-top',(parseInt(window_h/2)-15)+'px');
        $('div#loader-circle').css('margin-left',(parseInt(window_w/2)-15)+'px');
    } 
}
</script>