<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
    </div>
</section>
<section id="message">
    <?php if (isset($error)) echo '<p>'.$error.'</p>';?>
    <?php if (isset($message)) echo '<p>'.$message.'</p>';?>
</section>

<section id="main-page">
    
    
    <div class="container-fluid">
        <select id="channel">
            <?php foreach($channel_list as $channel):?>
            <option value="<?php echo $channel->id;?>"<?php echo $channel_id==$channel->id?' selected':'';?>><?php echo $channel->title;?></option>
            <?php endforeach;?>
        </select>
    </div>    
    <div class="container-fluid">
        <!-- pagination -->
        <div class="pagination"></div>
        <!-- main data -->
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Id</th>
                    <th>Item Name</th>
                    <th>Feature Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="5">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('select#channel').change(function(){
            window.location = "<?php echo site_url('cms/featured/index');?>/"+$(this).val();
        });
        
        loadItems("<?php echo $channel_id;?>","<?php echo $channel_name;?>",1);
    });
    
    var limit = 5;
    function loadItems(channel_id, channel_name, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'channel_featured_items',channel_id:channel_id, channel_name:channel_name, page:page,limit:limit},function(data){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
                     
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['item_id']+'</td>';
                    s+= '<td>'+d['item_name']+'</td>';
                    
                    var cover = d['cover']!==''?'<img src="'+d['cover']+'" width="40" />':'<i class="icon-remove" title="No cover image"></i>';
                    s+= '<td>'+cover+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="5">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        },'json');
    }
</script>
