<link rel="stylesheet" type="text/css" media="screen" ref="<?=base_url()?>assets/css/datepicker.css">
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>

<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p id="sync">
            <a href="javascript:syncronizeItemsAll();" title="Syncronize schedules last num of days start from date">
                <i id="icon-sync-all" class="icon-refresh"></i> 
                <span id="loader-sync-all" class="ajax-loader-small"></span>
                Syncronize All TV Schedules
            </a> <br />
            <form class="form-inline">
                <label for="startdate">Start From Date</label>
                <input type="text" class="span2 datepicker" id="startdate" name="startdate" value="<?php echo date('Y-m-d'); ?>" />
                <label for="day_length">Num of Days</label>
                <input type="text" class="input-mini" id="day_length" name="day_length" value="2" />
            </form>
            
        </p>
        <p>
            <?php echo btn_new('cms/tv/schedules_edit/','Add TV Schedules');?>
        </p>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- create dropdown category -->
        <!-- create dropdown category -->
        <?php echo form_label('Select Station', 'category');?>
        <?php $js = 'id="category"'; ?>
        <?php echo form_dropdown('category', $options, array($tv_code), $js);?>
        
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>TV Code</th>
                    <th>Tanggal</th>
                    <th>Acara</th>
                    <th>StartTime</th>
                    <th>EndTime</th>
                    <th>Source</th>
                    <th>Feat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="10">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        
        //Initial call
        var stream_type = $('select#category').val();
        loadItems(stream_type, 1);
        
        $('select#category').change(function(){
            loadItems($(this).val(), 1);
        });
    });
    
    var limit = 10;
    function loadItems(tvcode, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="10">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'tv_get_schedules',tvcode:tvcode, page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['category_buttons']+'</td>';
                    s+= '<td>'+d['tvcode']+'</td>';
                    s+= '<td>'+d['date']+'</td>';
                    s+= '<td>'+d['acara']+'</td>';
                    s+= '<td>'+d['start_time']+'</td>';
                    s+= '<td>'+d['end_time']+'</td>';
                    s+= '<td>'+d['source']+'</td>';
                    s+= '<td>'+d['is_featured']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="10">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
    /*
    * Function to set category for selected item and category
     */
    function setTVScheduleItemCategory(item_id, category_name, category_id){
        $.post("<?php echo site_url('ajax/cms'); ?>",{func:'tv_schedule_set_category',id:item_id,category:category_id},function(result){
            if (parseInt(result['status'])===1)
                $('span#catselect_'+item_id).text(category_name);
            else
                alert('Gagal');
        },'json');
    }
    
    /*
     * Function to syncronize schedules
     */
    function syncronizeItemsAll(){
        var startdate = $('#startdate').val();
        var day_length = $('#day_length').val();
        if (confirm('Syncronize will replace all data with new data from API. It will take some times. Are you sure ?')){
            //load gif loader indicator
            $('#icon-sync-all').hide();
            $('#loader-sync-all').show();

            $.post("<?php echo site_url('ajax/syncronize_tv');?>",{func:'syncronize_schedules_all',startdate:startdate,day_length:day_length},function(data){
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