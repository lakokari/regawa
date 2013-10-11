<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
    </div>
</section>

<section id="main-page">
    <div class="container-fluid">
        <!-- pagination -->
        <div id="pagination"></div>
        
        <!-- table data -->
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Fullname</th>
                    <th>Occupation</th>
                    <th>Facebook</th>
                    <th>Twitter</th>
                    <th>Age</th>
                    <th>Creation</th>
                    <th>Motto</th>
                    <th>Description</th>
                    <th>Avatar</th>
                    <th>Event</th>
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
        
        loadJury(1);
    });
    
    var limit = 10;
    function loadJury(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="5">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_jury',page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['u_name']+'</td>';
                    s+= '<td>'+d['sure_name']+'</td>';
                    s+= '<td>'+d['occupation']+'</td>';
                    s+= '<td>'+d['facebook_id']+'</td>';
                    s+= '<td>'+d['tweeter_id']+'</td>';
                    s+= '<td>'+d['age']+'</td>';
                    s+= '<td>'+d['creation']+'</td>';
                    s+= '<td>'+d['motto']+'</td>';
                    s+= '<td>'+d['description']+'</td>';
                    s+= '<td>'+d['avatar']+'</td>';
                    s+= '<td>'+d['event_name']+'</td>';
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