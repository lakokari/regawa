<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
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
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $options, 0, $js);?>
        
        <select id="event" name="event"></select>
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Total Like</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="5">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        $('select#category').change(function(){
            loadEvent($(this).val());
        });

        $('select#event').change(function(){
            loadItems($(this).val(),1);
        });
    
        loadEvent($('select#category').val());
    });
    
    var limit = 10;
    function loadEvent(category_id){
        $('select#event').empty().append('<option>Loading...</option>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_event_by_category',category_id:category_id},function(result){
            $('select#event').empty();
            var data = jQuery.parseJSON(result);
                        
            if (data['size']>0){
                for(var i in data['items']){
                    d = data['items'][i];
                    s = '<option value="'+d['id']+'">';
                    s+= d['name'];
                    s+= "</option>";

                    $('select#event').append(s);
                }
                
                loadItems($('select#event').eq(0).val(),1);
            }
            
            
        });
    }

    function loadItems(event_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_items_by_event',event_id:event_id,page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            //var thumb_url = '<?php echo base_url(config_item('userfiles')) ;?>/wow/thumbnail/';
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['id']+'</td>';
                    s+= '<td>'+d['item_name']+'</td>';
                    s+= '<td>'+d['item_like_count']+'</td>';
                    s+= '<td>'+d['detail_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="5">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
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