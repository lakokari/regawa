<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/apps/items_edit','Add Item');?>
        </p>
        <p id="sync">
            <a href="javascript:syncronizeApps();" title="Syncronize apps items by selected category">
                <i id="icon-sync-apps" class="icon-refresh"></i> 
                <span id="loader-sync-apps" class="ajax-loader-small"></span>
                Syncronize Apps Items
            </a>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <label>Select Category</label>
        <select id="category">
            <?php foreach($category as $cat):?>
            <option parentid="<?php echo $cat->parent_id ;?>" value="<?php echo $cat->category_id ;?>"><?php echo ($cat->parent_id==1?'MOB':'PC').'-'. $cat->category_name; ?></option>
            <?php endforeach;?>
        </select>
        
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>packageId</th>
                    <th>packageName</th>
                    <th>developer</th>
                    <th>icon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="6">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    var PC = 2;
    var MOB= 1;
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        $('select#category').change(function(){
            var parent_id= $('select#category option:selected').attr('parentid');
            var category_id = $(this).val();
            loadItems(parent_id, category_id,1);
        });
        
        loadItems($('select#category option:selected').attr('parentid'),$('select#category').val(),1);
    });
    
    var limit = 10;
    function loadItems(parent_id,category_id, page){
        
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="6">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'apps_get_items',parent_id:parent_id,category_id:category_id, page:page,limit:limit},function(result){
            
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
                    s+= '<td>'+d['developer_or_publisher']+'</td>';
                    s+= '<td>'+'<img src="'+d['icon_url']+'" width="40" />'+'</td>';
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
    
    
    function syncronizeApps(){
        //check which parent id
        var parent_id= parseInt($('select#category option:selected').attr('parentid'));
        if (parent_id===MOB){
            syncronizeAppsItemsSpeedy();
        }else if(parent_id===PC){
            syncronizeAppsItems();
        }
    }
    function syncronizeAppsItems(){
        var category_id = $('select#category').val();
        
        if (category_id>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-apps').hide();
                $('#loader-sync-apps').show();

                $.post("<?php echo site_url('ajax/syncronize_apps');?>",{func:'syncronize_items_by_category',category_id:category_id},function(result){
                    var data = jQuery.parseJSON(result);

                    alert(data['sync_message']);

                    if (parseInt(data['sync_count'])>0){
                        loadItems(PC, category_id,1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-apps').hide();
                    $('#icon-sync-apps').show();
                });
            }
        }
    }
    
    function syncronizeAppsItemsSpeedy(){
        var category_id = $('select#category').val();
        
        if (category_id>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-apps').hide();
                $('#loader-sync-apps').show();

                $.post("<?php echo site_url('ajax/syncronize_apps');?>",{func:'syncronize_items_by_category_speedy',category_id:category_id},function(result){
                    var data = jQuery.parseJSON(result);

                    alert(data['sync_message']);

                    if (parseInt(data['sync_count'])>0){
                        loadItems(MOB, category_id,1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-apps').hide();
                    $('#icon-sync-apps').show();
                });
            }
        }
    }
</script>