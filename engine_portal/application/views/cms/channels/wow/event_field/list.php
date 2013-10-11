<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/wow/event_field_edit','Add Item');?>
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
        <!-- create dropdown category -->
        <?php echo form_label('Select Category', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $options, 0, $js);?>
        
        <select id="event" name="event"></select>
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Event Field</th>
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
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        $('select#category').change(function(){
            loadEvent($(this).val());
        });

        $('select#event').change(function(){
            loadField($(this).val(),1);
        });
    
        loadEvent($('select#category').val());
    });
    
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
                
                loadField($('select#event').eq(0).val(),1);
            }
            
            
        });
    }

    var limit = 10;
    function loadField(event_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="4">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_event_field',event_id:event_id, page:page,limit:limit},function(result){
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            var totalSize = data['totalSize'];
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['id_event_field']+'</td>';
                    s+= '<td>'+d['event_field']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="4">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
</script>