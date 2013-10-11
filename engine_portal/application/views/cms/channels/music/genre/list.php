<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="sync">
            <a href="javascript:syncronizeGenre();" title="Syncronize genres by selected category">
                <i class="icon-refresh"></i> Syncronize Music Genres
            </a>
        </p>
		<p>
            <?php echo btn_new('cms/music/genre_edit','Add Genre');?>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php echo form_dropdown('category', $options, array($categoryId), 'id="category"');?>
        
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>genreId</th>
                    <th>genreName</th>
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
    var genreLimit = 10;
    $(document).ready(function(){
        loadGenreByCategory($('select#category').val(),0);
        
        $('select#category').change(function(){
            loadGenreByCategory($(this).val(),1);
        });
    });
    
    function loadGenreByCategory(categoryId, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){
            $(this).remove();
        });
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_genre_by_category',categoryId:categoryId,page:page,limit:genreLimit},function(result){
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['genreId']+'</td>';
                    s+= '<td>'+d['genreName']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="4">No data</td></tr>';
            }
            $('div#pagination').html(data['pagination']);
        });
    }
    
    
    function syncronizeGenre(){
        var categoryId = $('select#category').val();
        
        if (categoryId>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                $.post("<?php echo site_url('ajax/syncronize_ajax');?>",{func:'syncronize_genre',categoryId:categoryId},function(result){
                    var data = jQuery.parseJSON(result);
                    
                    alert(data['sync_message']);
                    
                    if (data['sync_status']=='1'){
                        loadGenreByCategory(categoryId, 0);
                    }
                });
            }
        }
    }
</script>