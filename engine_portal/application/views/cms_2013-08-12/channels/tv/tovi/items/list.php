<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/tovi/items_edit/','Add Movie Items');?>
            |
            <a href="javascript:syncronizeItemsAll();" title="Syncronize all Stations">
                <i id="icon-sync-all" class="icon-refresh"></i> 
                <span id="loader-sync-all" class="ajax-loader-small"></span>
                Syncronize All TOVI Movie
            </a> 
        </p>
    </div>
</section>

<!-- if any errors -->
<?php if($this->session->flashdata('error')){?>
<section id="update-error">
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><?php echo $this->session->flashdata('error');?></strong>
    </div>
</section>
<?php }?>

<section id="main-page">
    <div class="container-fluid">
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>code</th>
                    <th>name</th>
                    <th>actor</th>
                    <th>director</th>
                    <th>content_type</th>
                    <th>language</th>
                    <th>small_image1</th>
                    <th width="5%">Action</th>
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
    
        loadItems(1);
    });
    
    var limit = 10;
    function loadItems(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="9">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'tovi_get_items',page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['code']+'</td>';
                    s+= '<td>'+d['name']+'</td>';
                    s+= '<td>'+d['actor']+'</td>';
                    s+= '<td>'+d['director']+'</td>';
                    s+= '<td>'+d['content_type']+'</td>';
                    s+= '<td>'+d['language']+'</td>';
                    s+= '<td>'+d['image']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'|'+d['upload_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="9">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    function syncronizeItemsAll(){
        if (confirm('Syncronize will replace all data with new data from API. It will take some times. Are you sure ?')){
            //load gif loader indicator
            $('#icon-sync-all').hide();
            $('#loader-sync-all').show();

            $.post("<?php echo site_url('ajax/syncronize_tv');?>",{func:'syncronize_tovi_items_all'},function(data){
                alert(data['sync_message']);

                loadItems($('select#category').val(),1);
            },'json')
            .fail(function() { alert("Server error"); })
            .always(function() { 
                //hide gif loader indicator
                $('#loader-sync-all').hide();
                $('#icon-sync-all').show();
            });
        }
    }
</script>