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
    $modal = array(
        'modal_title'   =>  'Play Video',
        'modal_id'      =>  'my-modal'
    );
    $this->load->view('cms/_layout_modal_js', $modal); 
    ?>

    <!--modal score juri -->
    <?php 
    $modal = array(
        'modal_title'   =>  'Beri Nilai',
        'modal_id'      =>  'judge-modal'
        );
    $this->load->view('cms/_layout_modal_js', $modal); 
    ?>
    <div class="container-fluid">
        <!-- message -->
        <div id="message"></div>
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Like Count</th>
                    <th>Thumbnail</th>
                    <th>Nilai</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="9">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    var event_id = "<?php echo $this->session->userdata('wow_event_id'); ?>";
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        if (event_id == 0){
            $('#pagination').hide();
            $('#table-data').hide();
            $('#message').html("<h4>Anda Belum Memiliki Akses Wow Event.</h4>");
        }
        loadItems(1);
    });
    
    var limit = 10;
    function loadItems(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="9">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_items_judge',page:page,limit:limit},function(result){
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            var thumb_url = '<?php echo config_item('userfiles') ;?>/wow/thumbnail/';
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
                    s+= '<td>'+d['item_like_count']+'</td>';
                    s+= '<td><img src="'+thumb_url+d['item_thumbnail']+'" width="40" /></td>';
                    if(d['nilai']){
                        s+= '<td><a href="javascript:beriNilai('+d['id']+');">'+d['nilai']+'</a></td>';
                    } else {
                        s+= '<td><a href="javascript:beriNilai('+d['id']+');">not yet</a></td>';
                    }
                    var playJs = '<a href="javascript:playItem('+d['id']+');"><i class="icon-play-circle" title="play"></i></a>';
                    s+= '<td>'+playJs+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="9">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }

    function beriNilai(item_id){
        var retUrl = '<?php echo base_url()."cms/juri/items"; ?>';
        var thumbUrl = '<?php echo config_item("userfiles")."wow/thumbnail/"; ?>';
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_data_item_judge',item_id:item_id},function(result){
            //alert(result);
            var data = jQuery.parseJSON(result);
            if(data['size']>0) {
                var it = data['item'];
                var sc = data['score'];
                $('#judge-modal').width(640).modal();
                var s= '<h4>'+it['item_name']+'</h4>';
                s+= '<center><img src="'+thumbUrl+it['item_thumbnail']+'?>" /></center><br />';
                s+= '<form name="juri" method="post" action="javascript:saveNilai('+item_id+');">';
                s+= '<table id="modal-table">';
                s+= '<tr><td>Nilai (1-100)</td>';
                s+= '<td><input type="nilai" name="score" style="width:30px;" value="'+sc['score']+'" /></td></tr>';
                s+= '<tr><td>Comment</td>';
                s+= '<td><textarea id="comment" name="comment" rows="5" cols="20">'+sc['comment']+'</textarea>'+
                    '<input type="hidden" name="id" value="'+sc['id']+'" />'+
                    '</td></tr>';
                //s+= '';
                s+= '<tr><td><input type="submit" name="submit" value="Save" class="btn btn-primary"></td>';
                s+= '</table></form>';
                $('#judge-modal #modal-body').html(s);
            } else {
                $('#judge-modal #modal-body').html("data tidak ditemukan");
            }
        });
    }

    

    function saveNilai(item_id){
        var id = document.forms["juri"]["id"].value;
        var score = document.forms["juri"]["score"].value;
        var comment = document.getElementById("comment").value;

        if((score>100) || (isNaN(score))){
            alert("nilai hanya 1-100");
        } else {
            //alert("lanjut");
            $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_update_nilai_judge',id:id,item_id:item_id,score:score,comment:comment},function(result){
                //alert(result['status']);
                var data = jQuery.parseJSON(result);
                //alert(data['status']);
                if(data['status'] == 1){
                    $('#judge-modal').modal('hide');
                    loadItems($('select#event').val(), 1);
                }
            });
        }
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