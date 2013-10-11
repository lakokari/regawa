<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="sync">
            <a href="javascript:syncronizeItemsAll();" title="Syncronize all games">
                <i id="icon-sync-all" class="icon-refresh"></i> 
                <span id="loader-sync-all" class="ajax-loader-small"></span>
                Syncronize Games All
            </a>
            
            <a href="javascript:testLoad();" title="Syncronize all games">
                <i id="icon-sync-all" class="icon-refresh"></i> 
                <span id="loader-sync-all" class="ajax-loader-small"></span>
                Test Load
            </a>
        </p>
        <p id="add">
            <a href="<?php echo site_url('cms/games/items_add') ?>"><i class="icon-file"></i>Add Games</a>
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
                    <th>Game Name</th>
                    <th>Description</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Thumbnail</th>
                    <th>Feat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="8">No data</td></tr>
            </tbody>
        </table>
    </div>
    
    <div class="container-fluid" id="test"></div>
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
    
    var limit = 5;
    function loadItems(category_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="8">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'games_get_items',category_id:category_id, page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['title']+'</td>';
                    s+= '<td>'+d['description']+'</td>';
                    s+= '<td>'+d['width']+'</td>';
                    s+= '<td>'+d['height']+'</td>';
                    s+= '<td>'+'<img src="'+d['thumbnail_url']+'" width="40" />'+'</td>';
                    s+= '<td>'+d['is_featured']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="8">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    function testLoad(){
        $.post('http://devgame.uzone.co.id/',function(data){
            $('div#test').html(data);
        });
    }
    function syncronizeItemsAll(){
        if (confirm('Syncronize will replace all books data with new data from API. It will take some times. Are you sure ?')){
            //load gif loader indicator
            $('#icon-sync-all').hide();
            $('#loader-sync-all').show();

            $.post("<?php echo site_url('ajax/syncronize_games');?>",{func:'syncronize_items_all'},function(data){
                alert(data['sync_message']);

                if (parseInt(data['sync_count'])>0){
                    var category_id = $('select#category').eq(0).val();
                    $('select#category').val(0);
                    loadItems(category_id,1);
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
</script>