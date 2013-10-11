<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/apps/featured_edit','Add Item');?>
        </p>
        <p id="sync">
            <a href="javascript:syncronizeAppsFeatures();" title="Syncronize apps features">
                <i id="icon-sync-apps" class="icon-refresh"></i> 
                <span id="loader-sync-apps" class="ajax-loader-small"></span>
                Syncronize Apps Features
            </a>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">                
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>packageId</th>
                    <th>packageName</th>
                    <th>category</th>
                    <th>developer</th>
                    <th>icon</th>
                    <th>Feat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="8">No data</td></tr>
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
        
        $('table#table-data').append('<tr class="data"><td colspan="8">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'apps_get_featured',page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['package_id']+'</td>';
                    s+= '<td>'+d['package_name']+'</td>';
                    s+= '<td>'+d['category']+'</td>';
                    s+= '<td>'+d['developer_or_publisher']+'</td>';
                    s+= '<td>'+'<img src="'+d['icon_url']+'" width="40" />'+'</td>';
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
    
    
    function syncronizeAppsFeatures(){
        //if (category_id>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-apps').hide();
                $('#loader-sync-apps').show();

                $.post("<?php echo site_url('ajax/syncronize_apps');?>",{func:'syncronize_featured'},function(result){
                    var data = jQuery.parseJSON(result);

                    alert(data['sync_message']);

                    if (parseInt(data['sync_count'])>0){
                        loadItems(1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-apps').hide();
                    $('#icon-sync-apps').show();
                });
            }
        //}
    }
</script>