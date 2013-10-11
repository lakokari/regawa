<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/wow/static_edit','Add Item');?>
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
        <?php echo form_label('Select Item', 'item');?>
        <?php $js = 'id="item_name"'; ?>
        <?php echo form_dropdown('item', $options, 0, $js);?>
                
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item ID</th>
                    <th>Datetime</th>
                    <th>Title</th>
                    <th>TOC</th>
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
        
        $('select#item_name').change(function(){
            loadItems($(this).val(),1);
        });
    
        loadItems($('select#item_name').val(),1);
    });
    
    var limit = 10;
    function loadItems(event_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="6">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_static',event_id:event_id, page:page,limit:limit},function(result){
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            var totalSize = data['totalSize'];
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start);
                    if(d['display_order'] != 0) {
                        if(d['display_order'] == 1) {
                            s+= '<a href="javascript:moveDown('+event_id+','+d['id']+');"><i class="icon-arrow-down"></i></a>';
                        } else if(start == totalSize) {
                            s+= '<a href="javascript:moveUp('+event_id+','+d['id']+');"><i class="icon-arrow-up"></i></a>';
                        } else {
                            s+= '<a href="javascript:moveUp('+event_id+','+d['id']+');"><i class="icon-arrow-up"></i></a>/'+
                            '<a href="javascript:moveDown('+event_id+','+d['id']+');"><i class="icon-arrow-down"></i></a>';
                        }
                    }
                    s+= '</td>';
                    s+= '<td>'+d['id']+'</td>';
                    s+= '<td>'+d['datetime']+'</td>';
                    s+= '<td>'+d['title']+'</td>';
                    if(d['toc']==1){
                        s += '<td>Yes</td>';
                    } else {
                        s+= '<td><a href="javascript:updateTOC('+event_id+','+d['id']+');">No</a></td>';
                    }
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

    function moveUp(event_id,item_id){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_static_move_up',event_id:event_id,item_id:item_id},function(result){
            loadItems(event_id, 1);
        });
    }

    function moveDown(event_id,item_id){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_static_move_down',event_id:event_id,item_id:item_id},function(result){
            loadItems(event_id, 1);
        });
    }
    
    function updateTOC(event_id,item_id){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_static_update_toc',event_id:event_id,item_id:item_id},function(result){
            loadItems(event_id, 1);
        });
    }
</script>