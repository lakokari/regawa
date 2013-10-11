<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="add">
            <a href="<?php echo site_url('cms/homeimage/edit') ?>"><i class="icon-file"></i>Add Cover Image</a>
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
                    <th>Filename</th>
                    <th>Extension</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Link</th>
                    <th>Sort</th>
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
        loadItems(1);
    });
    
    var limit = 10;
    function loadItems(page){
        $('#my-loader').show();
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="8">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/homeimage');?>",{func:'homeimage_getlist', page:page,limit:limit},function(data){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['name']+'</td>';
                    s+= '<td>'+d['author']+'</td>';
                    s+= '<td>'+d['publish_date']+'</td>';
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
        },'json')
        .error(function(){
            alert('Server error');
        })
        .always(function(){
            $('#my-loader').hide();
        });
    }
    
    
    function syncronizeBooksItemsByCategory(){
        var category_id = $('select#category').val();
        var category_name = $('select#category :selected').text();
        
        if (category_name!==''){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-book').hide();
                $('#loader-sync-book').show();

                $.post("<?php echo site_url('ajax/syncronize_book');?>",{func:'syncronize_items_by_category',category_name:category_name, category_id:category_id},function(data){
                    alert(data['sync_message']);

                    if (parseInt(data['sync_count'])>0){
                        loadItems(category_id,1);
                    }
                },'json')
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-book').hide();
                    $('#icon-sync-book').show();
                });
            }
        }
    }
    
    function syncronizeBooksItemsAll(){
        if (confirm('Syncronize will replace all books data with new data from API. It will take some times. Are you sure ?')){
            //load gif loader indicator
            $('#icon-sync-allbook').hide();
            $('#loader-sync-allbook').show();

            $.post("<?php echo site_url('ajax/syncronize_book');?>",{func:'syncronize_items_all'},function(data){
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
                $('#loader-sync-allbook').hide();
                $('#icon-sync-allbook').show();
            });
        }
    }
</script>