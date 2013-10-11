<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/movie/schedule_edit','Add Theater');?>
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
        <select name="city_id" id="city_id">
            <option value="">Select City</option>
            <?php
                foreach ($city as $key) {
                    echo '<option value="'.$key->id.'">'.$key->name.'</option>';
                }
            ?>
         </select> 


        <select name="get_theater" id="get_theater">
            <option value="">Select Theater</option>
         </select> 

        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>City</th>
                    <th>Theater</th>
                    <th>Movie Title</th>
                    <th>Schedule Date</th>
                    <th>Schedule Time</th>
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

        $('select#get_theater').change(function(){
            loadItems($(this).val(),1);
        });
    
        loadItems($('select#get_theater').val(),1);

        $("#city_id").change(function(){
            var city_id = $("#city_id").val();
            $.ajax({
               type : "POST",
               url  : "<?php echo base_url(); ?>cms/movie/schedule_get_theater",
               data : "city_id=" + city_id,
               success: function(data){
                   $("#get_theater").html(data);
               }
            });
        });

    });

    var limit = 10;
    function loadItems(theater_id, page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="4">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'movie_get_schedule',theater_id:theater_id, page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['city_name']+'</td>';
                    s+= '<td>'+d['theater_name']+'</td>';
                    s+= '<td>'+d['movie_title']+'</td>';
                    s+= '<td>'+d['schedule_date']+'</td>';
                    s+= '<td>'+d['schedule_time']+'</td>';
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