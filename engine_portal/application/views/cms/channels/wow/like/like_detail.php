<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <h4><?php echo $item_name; ?></h4>
        <p>
            <a href="<?php echo base_url('cms/wow/like'); ?>" like="" list=""><i class="icon-th-list"></i> Like List </a>
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
        
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Like Date</th>
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
    var item_id = "<?php echo $item_id; ?>"
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
    
        loadLikeList(1);
    });
    var limit = 10;
    function loadLikeList(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="4">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_like',item_id:item_id, page:page,limit:limit},function(result){
            
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            var thumb_url = '<?php echo base_url(config_item('userfiles')) ;?>/wow/thumbnail/';
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['user_name']+'</td>';
                    s+= '<td>'+d['like_date']+'</td>';
                    var playJs = '<a href="javascript:playItem('+d['id']+');"><i class="icon-play-circle" title="play"></i></a>';
                    s+= '<td>'+d['delete_url']+'</td>';
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