<script type="text/javascript">
$(document).ready(function(){
    create_loader('my-uz-loader');
});
function setItemAsFeatured(id){
    $.post("<?php echo site_url('ajax/cms'); ?>",{func:'set_as_featured',id:id,callback:true},function(result){
           $('a#a_'+id).parent().html('<a id="a_'+id+'" href="javascript:unSetItemAsFeatured('+id+');"><i class="icon-thumbs-up" title="nominated"></i></a>');
           //$('a#a_'+item_id).remove();
    });
}

function unSetItemAsFeatured(id){
    $.post("<?php echo site_url('ajax/cms'); ?>",{func:'unset_as_featured',id:id,callback:true},function(result){
           $('a#a_'+id).parent().html('<a id="a_'+id+'" href="javascript:setItemAsFeatured('+id+');"><i class="icon-hand-right" title="unnominated"></i></a>');
           //$('a#a_'+item_id).remove();
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