<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>        
        <p id="sync">
            <a href="javascript:syncronizeAlbumCategory();" title="Syncronize all album by selected category">
                <i id="icon-sync-albumcat" class="icon-refresh"></i> 
                <span id="loader-sync-albumcat" class="ajax-loader-small"></span>
                Syncronize Albums by Category
            </a>
            |
            <a href="javascript:syncronizeAlbum();" title="Syncronize album by selected genre">
                <i id="icon-sync-album" class="icon-refresh"></i> 
                <span id="loader-sync-album" class="ajax-loader-small"></span>
                Syncronize Albums by Genre
            </a>
        </p>
		<p>
            <?php echo btn_new('cms/music/album_edit','Add Album');?>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category" onChange="changeCategory(this.value);"'; ?>
        <?php echo form_dropdown('category', $catoptions, array($categoryId), $js);?>
        
        <select id="genre" name="genre"></select>
        
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>albumId</th>
                    <th>albumName</th>
                    <th>albumLImgPath</th>
                    <th>Feat</th>
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
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
    
        loadGenre($('select#category').val());
        
        $('select#genre').change(function(){
            loadAlbumsByGenre($(this).val(),1);
        });
    });
    function changeCategory(categoryId){
        loadGenre(categoryId);
    }
    
    function loadGenre(categoryId){
        $('select#genre').empty();
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_genre_by_category',categoryId:categoryId,fields:'genreId,genreName'},function(result){
            var data = jQuery.parseJSON(result);
                        
            if (data['size']>0){
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<option value="'+d['genreId']+'">';
                    s+= d['genreName'];
                    s+= "</option>";

                    $('select#genre').append(s);
                }
                
                loadAlbumsByGenre($('select#genre').eq(0).val(),0);
            }
            
            
        });
    }
    
    var albumLimit = 20;
    var img_url = 'http://melon.co.id/image.img?fileuid=';
    function loadAlbumsByGenre(genreId,page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="6">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_album_by_genre',genreId:genreId,page:page,limit:albumLimit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['albumId']+'</td>';
                    s+= '<td>'+d['albumName']+'</td>';
                    s+= '<td>'+'<img src="'+img_url+d['albumLImgPath']+'" width="40" />'+'</td>';
                    s+= '<td>'+(d['is_featured'] ? d['is_featured'] : ' - ')+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="6">No data</td></tr>';
                $('table#table-data').append(s);
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    function syncronizeAlbumCategory(){
        var categoryId = $('select#category').val();
        
        if (categoryId>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-albumcat').hide();
                $('#loader-sync-albumcat').show();
                
                $.post("<?php echo site_url('ajax/syncronize_ajax');?>",{func:'syncronize_album_by_category',categoryId:categoryId},function(result){
                    var data = jQuery.parseJSON(result);
                    
                    alert(data['sync_message']);
                    
                    if (data['sync_status']=='1'){
                        loadAlbumsByGenre($('select#genre').val(), 1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-albumcat').hide();
                    $('#icon-sync-albumcat').show();
                });
            }
        }
    }
    
    function syncronizeAlbum(){
        var categoryId = $('select#category').val();
        var genreId = $('select#genre').val();
        
        if (categoryId>0 && genreId>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader indicator
                $('#icon-sync-album').hide();
                $('#loader-sync-album').show();
                
                $.post("<?php echo site_url('ajax/syncronize_ajax');?>",{func:'syncronize_album_by_genre',genreId:genreId},function(result){
                    var data = jQuery.parseJSON(result);
                    
                    alert(data['sync_message']);
                    
                    if (data['sync_status']=='1'){
                        loadAlbumsByGenre(genreId, 1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-album').hide();
                    $('#icon-sync-album').show();
                });
            }
        }
    }
</script>