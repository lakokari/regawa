<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p><?php echo btn_new('cms/coverstory/edit') ;?></p>
    </div>
</section>
<section id="message">
    <?php if (isset($error)) echo '<p>'.$error.'</p>';?>
    <?php if (isset($message)) echo '<p>'.$message.'</p>';?>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- pagination -->
        <div class="pagination"></div>
        <!-- main data -->
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Sort</th>
                    <th>Visible</th>
                    <th>Target Url</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="8">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function(){
        loadItems(1);
    });
    
    var limit = 5;
    function loadItems(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="8">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'coverstory_items', page:page,limit:limit},function(data){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
                     
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['name']+'</td>';
                    s+= '<td>'+d['title']+'</td>';
                    s+= '<td>'+d['sort']+'</td>';
                    s+= '<td>'+(d['showed']===1?+'<i class="icon-ok"></i>':'<i class="icon-remove"></i>')+'</td>';
                    s+= '<td>'+(d['target_url'])+'</td>';
                    var cover_image = d['image_url']!==''?'<img src="'+d['image_url']+'" width="40" />':'<i class="icon-remove" title="No cover image"></i>';
                    s+= '<td>'+cover_image+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="8">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        },'json');
    }
</script>
