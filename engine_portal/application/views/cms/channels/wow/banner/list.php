<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/wow/banner_edit','Add Banner');?>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $options, 0, $js);?>

        <select id="event" name="event"></select>
        <!-- pagination -->
        <div id="pagination"></div>
        
        <!-- table data -->
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Event Name</th>
                    <th>Image</th>
                    <th>Image Alt</th>
                    <th>Hyperlink</th>
                    <th>Start Date</th>
                    <th>Stop Date</th>
                    <th>Text Banner</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="11">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        $('select#category').change(function(){
            loadEvent($(this).val());
        });

        $('select#event').change(function(){
            loadBanner($(this).val(),1);
        });
    
        loadEvent($('select#category').val());
    });
    
    var limit = 10;
    function loadEvent(category_id){
        $('select#event').empty().append('<option>Loading...</option>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_event_by_category',category_id:category_id},function(result){
            $('select#event').empty();
            var data = jQuery.parseJSON(result);
                        
            if (data['size']>0){
                for(var i in data['items']){
                    d = data['items'][i];
                    s = '<option value="'+d['id']+'">';
                    s+= d['name'];
                    s+= "</option>";

                    $('select#event').append(s);
                }
                
                loadBanner($('select#event').eq(0).val(),1);
            }
            
            
        });
    }

    function loadBanner(event_id,page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="11">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_banner',event_id:event_id,page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            //var imgUrl = "<?php echo config_item('userfiles').'wow/banner/'; ?>";
            var imgUrl = "<?php echo base_url().'userfiles/wow/banner/'; ?>";
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['id']+'</td>';
                    s+= '<td>'+d['title']+'</td>';
                    s+= '<td>'+d['event_name']+'</td>';
                    s+= '<td><img src="'+imgUrl+d['image']+'" width="20" /></td>';
                    s+= '<td>'+d['image_alt']+'</td>';
                    s+= '<td><a href="'+d['hyperlink']+'" target="_blank">'+d['hyperlink']+'</a></td>';
                    s+= '<td>'+d['start_date']+'</td>';
                    s+= '<td>'+d['stop_date']+'</td>';
                    //s+= '<td>'+d['banner_text'].substr(0,100)+'</td>';
                    s+= '<td>'+d['banner_text']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="11">No data</td></tr>';
                $('table#table-data').append(s);
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
</script>