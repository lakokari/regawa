<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
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
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Event Field</th>
                    <th>Item Field Value</th>
                    <th>Detail</th>
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
        
        $('select#category').change(function(){
            loadEvent($(this).val());
        });

        $('select#event').change(function(){
            loadFieldValue($(this).val(),1);
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
                
                loadFieldValue($('select#event').eq(0).val(),1);
            }
            
            
        });
    }

    function loadFieldValue(event_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="6">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_field_value',event_id:event_id,page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            //alert(result);
            var data = jQuery.parseJSON(result);
            if (data['size']>0){
                var start = parseInt(data['start']);
                //var f = data['']
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['item_id']+'</td>';
                    s+= '<td>'+d['item_name']+'</td>';
                    //loop event_field
                    s+= '<td><table class="table-condensed">';
                    for(var j in data['event_field']){
                    	var f = data['event_field'][j];
                    	s+= '<tr><td>'+f['event_field']+'</td></tr>';
                    }
                    s+= '</table></td>';
                    //loop field_value
                    s+= '<td><table class="table-condensed">';
                    for(var k in d['field_value']){
                    	s+= '<tr><td>'+d['field_value'][k]+'</td></tr>';
                    }
                    s+= '</table></td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="6">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
</script>