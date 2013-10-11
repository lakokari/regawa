<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="sync">
            
            <a href="javascript:syncronizeSongModByCategory();" title="Syncronize sonmod by selected category">
                <i id="icon-sync-songmod" class="icon-refresh"></i>
                <span id="loader-sync-songmod" class="ajax-loader-small"></span> Syncronize SongMode by Category
            </a>
        </p>
		<p>
            <?php echo btn_new('cms/music/songmode_edit','Add Song Mode');?>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $catoptions, array($categoryId), $js);?>
                
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>songId</th>
                    <th>songName</th>
                    <th>playtime</th>
                    <th>bitRateCd</th>
                    <th>codecTypeCd</th>
                    <th>fileSize</th>
                    <th>fullFilePath</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="9">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        loadSongMod($('select#category').val());
        
        $('select#category').change(function(){
            loadSongMod($(this).val());
        });
    
    });
    
    var songLimit = 10;
    var autoSync = 1;
    function loadSongMod(categoryId, page){
        if (page==='undefined') page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        $('table#table-data').append('<tr class="data"><td colspan="9">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_songmod_by_category',categoryId:categoryId,page:page,limit:songLimit},function(result){
            $('table#table-data tr.data').each(function(){$(this).remove();});            
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    d = data['items'][i];
                    s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['songId']+'</td>';
                    s+= '<td>'+d['songName']+'</td>';
                    s+= '<td>'+d['playtime']+'</td>';
                    s+= '<td>'+d['bitRateCd']+'</td>';
                    s+= '<td>'+d['codecTypeCd']+'</td>';
                    s+= '<td>'+d['fileSize']+'</td>';
                    s+= '<td>'+d['fullFilePath']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
                
                $('div#pagination').html(data['pagination']);
            }else{
                $('div#pagination').html('');
                $('table#table-data').append('<tr class="data"><td colspan="9">No data</td></tr>');
            }
            
            
        });
    }
    
    function syncronizeSongModByCategory(){
        var categoryId = $('select#category').val();
        
        if (categoryId>0){
            if (confirm('Syncronize will replace old data with new data from API. It will take some times. Are you sure ?')){
                
                //load gif loader indicator
                $('#icon-sync-songmod').hide();
                $('#loader-sync-songmod').show();
                
                
                $.post("<?php echo site_url('ajax/syncronize_ajax');?>",{func:'syncronize_song_mod_by_category',categoryId:categoryId},function(result){
                    
                    //hide gif loader indicator
                    $('#loader-sync-songmod').hide();
                    $('#icon-sync-songmod').show();
                    
                    var data = jQuery.parseJSON(result);
                    
                    alert(data['sync_message']);
                    
                    if (parseInt(data['sync_count'])>0){
                        loadSongs(album_id, 1);
                    }
                })
                .fail(function() { alert("Server error"); })
                .always(function() { 
                    //hide gif loader indicator
                    $('#loader-sync-songmod').hide();
                    $('#icon-sync-songmod').show();
                    
                });
            }
        }
    }
</script>