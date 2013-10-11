<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="add">
            <a href="<?php echo site_url('cms/radio/genre_add') ?>"><i class="icon-file"></i>Add Genre</a>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $options, 0, $js);?> 

        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Genre Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="3">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        $('select#category').change(function(){
            loadItems($(this).val(),1);
        });
    
        loadItems($('select#category').val(),1);
    });
    
    var limit = 10;
    function loadItems(category_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="3">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'radio_get_genres',category_id:category_id,page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['genre_name']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="6">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    
    function syncronizeItemsByCategory(){
        var radio_source = $('select#category').val();
        
        if (radio_source!==''){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-items').hide();
                $('#loader-sync-items').show();

                $.post("<?php echo site_url('ajax/syncronize_radio');?>",{func:'syncronize_items_by_category',radio_source:radio_source},function(data){
                    alert(data['sync_message']);

                    if (parseInt(data['sync_count'])>0){
                        loadItems(radio_source,1);
                    }
                },'json')
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-items').hide();
                    $('#icon-sync-items').show();
                });
            }
        }
    }
    
    function syncronizeItemsAll(){
        if (confirm('Syncronize will replace all books data with new data from API. It will take some times. Are you sure ?')){
            //load gif loader indicator
            $('#icon-sync-all').hide();
            $('#loader-sync-all').show();

            $.post("<?php echo site_url('ajax/syncronize_radio');?>",{func:'syncronize_items_all'},function(data){
                alert(data['sync_message']);

                if (parseInt(data['sync_count'])>0){
                    var radio_source = $('select#category').eq(0).val();
                    $('select#category').val(0);
                    loadItems(radio_source,1);
                }
            },'json')
            .fail(function() { alert("Server error"); })
            .always(function() { 
                //hide gif loader indicator
                $('#loader-sync-all').hide();
                $('#icon-sync-all').show();
            });
        }
    }
    
    function sendMessageActari(){
        $.get('http://www.actarifm.com/apis/data/message',{sender:'Bagus',message:'Hello',type:'c'},function(result){
            alert(result);
        });
    }
    function sendMessageTri(){
        $.post('http://www.trijayafmplg.co.id/apis/data/message',{sender:'Bagus',message:'Hello',type:'c'},function(result){
            alert(result);
        });
    }
    
</script>