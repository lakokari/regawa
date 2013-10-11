<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="sync">
            
            <a href="javascript:syncronizeSongByGenre();" title="Syncronize album by selected genre">
                <i id="icon-sync-genre" class="icon-refresh"></i>
                <span id="loader-sync-genre" class="ajax-loader-small"></span> Syncronize Song by Genre
            </a> |
            
            <a href="javascript:syncronizeSongByAlbum();" title="Syncronize album by selected album">
                <i id="icon-sync-album" class="icon-refresh"></i> 
                <span id="loader-sync-album" class="ajax-loader-small"></span>
                Syncronize Song by Album
            </a>
        </p>
		
		<p>
            <?php echo btn_new('cms/music/lyric_edit','Add Lyric');?>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $catoptions, array($categoryId), $js);?>
        
        <select id="genre" name="genre"></select>
        <select id="album" name="album"></select>
        <select id="autosync">
            <option value="0">No AutoSync</option>
            <option value="1">AutoSync On Empty</option>
        </select>
        
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
					<th>songId</th>
                    <th>songName</th>
                    <th>artistName</th>
                    <th>albumName</th>
                    <th>textLyric</th>
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
        
        loadGenre($('select#category').val());
        
        $('select#category').change(function(){
            loadGenre($(this).val());
        });
        $('select#genre').change(function(){
            loadAlbum($(this).val());
        });
        $('select#album').change(function(){
            loadlyric($(this).val(),0);
        });
        $('select#album').keypress(function(){$(this).change();});
    });
    
    function loadGenre(categoryId){
        $('select#genre').empty().append('<option>Loading...</option>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_genre_by_category',categoryId:categoryId,fields:'genreId,genreName'},function(result){
            $('select#genre').empty();
            var data = jQuery.parseJSON(result);
                        
            if (data['size']>0){
                for(var i in data['items']){
                    d = data['items'][i];
                    s = '<option value="'+d['genreId']+'">';
                    s+= d['genreName'];
                    s+= "</option>";

                    $('select#genre').append(s);
                }
                
                loadAlbum($('select#genre').eq(0).val());
            }
            
            
        });
    }
    
    function loadAlbumSmart(genreId){
        $(function () {
        var list = $("#list");

        for (var i = 1; i <= 40; i++)
            list.append("<option>Item " + i + "</option>");

        var updating = false;

        $(list).scroll(function () {
            if (updating)
                return;
            if (((this.scrollTop / this.scrollHeight) * 100) > 40) {
                //Probably a right moment to use Ajax;
                //Something like that:
                updating = true;
                var start = this.length;

                if (start > 1000) { // all data is loaded
                    return;
                }

                var top = this.scrollTop;
                for (var i = start + 1; i <= start + 40; i++) {
                    list.append("<option>Item " + i + " (New)</option>");
                    this.scrollTop = top;
                }
                updating = false;
            }
        });
    });   
    }
    
    function loadAlbum(genreId){
        $('select#album').empty().append('<option>Loading...</option>');
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_album_by_genre',genreId:genreId,fields:'albumId,albumName'},function(result){
            
            $('select#album').empty();
            
            var data = jQuery.parseJSON(result);
                        
            if (data['size']>0){
                for(var i in data['items']){
                    d = data['items'][i];
                    s= '<option value="'+d['albumId']+'">';
                    s+= d['albumName'];
                    s+= "</option>";

                    $('select#album').append(s);
                }
                
                loadSongs($('select#album').eq(0).val(),0);
            }
            
            return;
            
        });
    }
    
    var songLimit = 15;
    function loadSongs(albumId,page){
        if (page===undefined) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_lyric_by_album',albumId:albumId,page:page},function(result){
            $('table#table-data tr.data').each(function(){$(this).remove();});            
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    d = data['items'][i];
                    s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['artistId']+'</td>';
                    s+= '<td>'+d['songId']+'</td>';
                    s+= '<td>'+d['songName']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                $('table#table-data').append('<tr class="data"><td colspan="5">No data</td></tr>');
            }
            
            //pagination
            $('div#pagination').html(data['pagination']);
        });
    }
    
    function syncronizeSongByGenre(){
        var genreId = $('select#genre').val();
        
        if (genreId>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                //load gif loader idocator
                //load gif loader indicator
                $('#icon-sync-genre').hide();
                $('#loader-sync-genre').show();
                $.post("<?php echo site_url('ajax/syncronize_ajax');?>",{func:'syncronize_song_by_genre',genreId:genreId},function(result){
                    //hide gif loader idocator
                    $('#loader-sync-genre').hide();
                    $('#icon-sync-genre').show();
                    
        
                    var data = jQuery.parseJSON(result);
                    
                    alert(data['sync_message']);
                    
                    if (data['sync_status']=='1'){
                        loadSongs($('select#album').eq(0).val(), 0);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-genre').hide();
                    $('#icon-sync-genre').show();
                });
            }
        }
    }
    
    function syncronizeSongByAlbum(){
        var album_id = $('select#album').val();
        
        if (album_id>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                
                //load gif loader indicator
                $('#icon-sync-album').hide();
                $('#loader-sync-album').show();
                
                $.post("<?php echo site_url('ajax/syncronize_ajax');?>",{func:'syncronize_song_by_album',albumId:album_id},function(result){
                    
                    
                    var data = jQuery.parseJSON(result);
                    
                    alert(data['sync_message']);
                    
                    if (data['sync_status']=='1'){
                        loadSongs(album_id, 0);
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