<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="sync">
            <a href="javascript:syncronizeBookFeatures();" title="Syncronize apps features">
                <i id="icon-sync-book" class="icon-refresh"></i> 
                <span id="loader-sync-book" class="ajax-loader-small"></span>
                Syncronize Books Features
            </a>
        </p>
        <p id="add">
            <a href="<?php echo site_url('cms/book/featured_add') ?>"><i class="icon-file"></i>Add Featured</a>
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
                    <th>Book Name</th>
                    <th>Author</th>
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
        
        loadItems(1);
    });
    
    var limit = 10;
    function loadItems(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'book_get_featured',page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['name']+'</td>';
                    s+= '<td>'+d['author']+'</td>';
                    s+= '<td>'+'<img src="'+d['thumbnail_url']+'" width="40" />'+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
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
    
    
    function syncronizeBookFeatures(){
        //if (category_id>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-book').hide();
                $('#loader-sync-book').show();

                $.post("<?php echo site_url('ajax/syncronize_book');?>",{func:'syncronize_featured'},function(result){
                    var data = jQuery.parseJSON(result);

                    alert(data['sync_message']);

                    if (parseInt(data['sync_count'])>0){
                        loadItems(1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-book').hide();
                    $('#icon-sync-book').show();
                });
            }
        //}
    }
</script>