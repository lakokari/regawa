<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/apps/category_edit','Add Category');?>
        </p>
        <p id="sync">
            <a href="javascript:syncronizeCategory();" title="Syncronize category">
                <i id="icon-sync-category" class="icon-refresh"></i> 
                <span id="loader-sync-category" class="ajax-loader-small"></span>
                Syncronize Store Category
            </a>
            |
            <a href="javascript:syncronizeCategorySpeedy();" title="Syncronize category">
                <i id="icon-sync-category-speedy" class="icon-refresh"></i> 
                <span id="loader-sync-category-speedy" class="ajax-loader-small"></span>
                Syncronize Store Category (Speedy)
            </a>
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
                    <th>category_id</th>
                    <th>category_name</th>
                    <th>icon</th>
                    <th>Action</th>
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
        
        loadCategory(1);
    });
    
    var limit = 10;
    function loadCategory(page){
        $('#my-uz-loader').show();
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'apps_get_category',page:page,limit:limit},function(result){
            
            $('#my-uz-loader').hide();
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['category_id']+'</td>';
                    s+= '<td>'+d['category_name']+'</td>';
                    s+= '<td>'+'<img src="'+d['icon_url']+'" width="40" />'+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="5">No data</td></tr>';
                $('table#table-data').append(s);
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    
    function syncronizeCategory(){
        if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
            $('#my-uz-loader').show();
            //load gif loader indicator
            $('#icon-sync-category').hide();
            $('#loader-sync-category').show();
                
            $.post("<?php echo site_url('ajax/syncronize_apps');?>",{func:'syncronize_category'},function(result){
                var data = jQuery.parseJSON(result);
                    
                alert(data['sync_message']);
                    
                if (parseInt(data['sync_count'])>0){
                    loadCategory(1);
                }
            })
            .fail(function() { alert("Server error"); })
            .always(function() { 
                //hide gif loader indicator
                $('#my-uz-loader').hide();
                $('#loader-sync-category').hide();
                $('#icon-sync-category').show();
            });
        }
    }
    
    function syncronizeCategorySpeedy(){
        if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
            //load gif loader indicator
            $('#icon-sync-category-speedy').hide();
            $('#loader-sync-category-speedy').show();
                
            $.post("<?php echo site_url('ajax/syncronize_apps');?>",{func:'syncronize_category_speedy'},function(result){
                var data = jQuery.parseJSON(result);
                    
                alert(data['sync_message']);
                    
                if (parseInt(data['sync_count'])>0){
                    loadCategory(1);
                }
            })
            .fail(function() { alert("Server error"); })
            .always(function() { 
                //hide gif loader indicator
                $('#loader-sync-category-speedy').hide();
                $('#icon-sync-category-speedy').show();
            });
        }
    }
</script>