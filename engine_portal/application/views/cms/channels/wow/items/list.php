<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/wow/items_edit','Add Item');?>
        </p>
    </div>
</section>

<!-- if any errors -->
<?php if($this->session->flashdata('error')){?>
<section id="update-error">
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><?php echo $this->session->flashdata('error');?></strong>
    </div>
</section>
<?php }?>

<section id="main-page">
    <!-- modal video player -->
    <?php 
    $modal = array('modal_title'   =>  'Play Video');
    $this->load->view('cms/_layout_modal_js', $modal); 
    ?>
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Event', 'event');?>
        <?php $js = 'id="event"'; ?>
        <?php echo form_dropdown('event', $options, 0, $js);?>
                
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>URL</th>
                    <th>Like Count</th>
                    <th>Thumbnail</th>
                    <th>Approved</th>
                    <th>Nominee</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="11">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        $('select#event').change(function(){
            loadItems($(this).val(),1);
        });
    
        loadItems($('select#event').val(),1);
    });
    
    var limit = 10;
    function loadItems(event_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="11">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_items',event_id:event_id, page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            var thumb_url = '<?php echo config_item('userfiles') ;?>wow/thumbnail/';
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['id']+'</td>';
                    s+= '<td>'+d['item_name']+'</td>';
                    s+= '<td>'+d['item_type']+'</td>';
                    s+= '<td>'+d['item_description']+'</td>';
                    s+= '<td>'+d['item_url']+'</td>';
                    s+= '<td>'+d['item_like_count']+'</td>';
                    s+= '<td><img src="'+thumb_url+d['item_thumbnail']+'" width="40" /></td>';
                    if(d['approved'] == 1){
                        s+= '<td><a href="javascript:NotApprove('+event_id+','+d['id']+');">Yes</a></td>';
                    } else {
                        s+= '<td><a href="javascript:Approve('+event_id+','+d['id']+');">No</a></td>';
                    }
                    s+= '<td>'+d['is_featured']+'</td>';
                    var playJs = '<a href="javascript:playItem('+d['id']+');"><i class="icon-play-circle" title="play"></i></a>';
                    s+= '<td>'+playJs+'|'+d['edit_url']+'|'+d['delete_url']+'|'+d['upload_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="11">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }

    function Approve(event_id,item_id){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_approve_item',event_id:event_id,item_id:item_id},function(result){
            loadItems(event_id, 1);
        });
    }

    function NotApprove(event_id,item_id){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_not_approve_item',event_id:event_id,item_id:item_id},function(result){
            loadItems(event_id, 1);
        });
    }
    
    function playItem(itemId){
        //$('div#player').show();
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_row',id:itemId},function(data){
            if (data['size']>0){
                var video_player = document.getElementById("video-movie");
                createPlayer('modal-body', data['item'],true);
                
                //show modal dialog
                //set my-modal width
                $('#my-modal').width(640).modal();
            }
        },'json');
    }
    function createPlayer(element, videos, emptyContent){
        var container = document.getElementById(element);
        
        if (emptyContent) 
            container.innerHTML = "";
        //create video
        var video = document.createElement('video');
        video.width = 600;
        video.controls = "true";
        container.appendChild(video);
        
        //add source to video element
        for(var i in videos){
            var source = document.createElement('source');
            source.src = videos[i]['item_url'];
            source.type = videos[i]['type'];
            video.appendChild(source);
        }
        //reload the video and play
        video.load();
        video.play();
    }
    
</script>