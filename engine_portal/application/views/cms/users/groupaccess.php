<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <select id="groups">
            <?php foreach($groups as $group):?>
            <option value="<?php echo $group->id;?>"<?php echo $group_id==$group->id?' selected':''; ?>><?php echo $group->group;?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="container-fluid">
        <!-- pagination -->
        <div id="pagination"></div>
        
        <!-- table data -->
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Access Name</th>
                    <th>Access Category</th>
                    <th>Is Enable</th>
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
        
        //Load data by groupid for page 1
        loadItems($('select#groups').val(),1);
        
        $('select#groups').change(function(){
            loadItems($(this).val(),1);
        });
    });
    
    var limit = 10;
    function loadItems(group_id,page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'groups_get_accesslist',group_id:group_id,page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['role']+'</td>';
                    s+= '<td>'+d['category']+'</td>';
                    s+= '<td>'+(d['enabled']===0?'No':'Yes')+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="5">No data</td></tr>';
                $('table#table-data').append(s);
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
</script>