<style>
    .ajax-loader-small{display: none;}
</style>
<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="add">
            <a href="<?php echo site_url('cms/games/apis_edit') ?>"><i class="icon-file"></i>Add API Url</a>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- pagination -->
        <div id="pagination"></div>
        
        <!-- table data -->
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>API</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="4">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        loadItems(1);
    });
    
    var limit = 10;
    function loadItems(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="4">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'games_get_apis',page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['category']+'</td>';
                    s+= '<td>'+d['api_url']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'|'+d['sync_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="4">No data</td></tr>';
                $('table#table-data').append(s);
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    function syncSelectedApi(api_id){
        $('#icon-repeat-'+api_id).show();
        $('#loader-sync-'+api_id).show();
        $.post('<?php echo site_url('ajax/syncronize_games'); ?>',{func:'syncronize_game_by_api', id:api_id},function(result){
            if (result['sync_status']===1){
                alert('Syncronize done for '+ result['sync_count']);
            }else{
                alert('Sync failed');
            }
        },'json')
        .fail(function() { alert("Server error"); })
        .always(function() { 
            //hide gif loader indicator
            $('#loader-sync-'+api_id).hide();
            $('#icon-repeat-'+api_id).show();
        });
    }
    
</script>