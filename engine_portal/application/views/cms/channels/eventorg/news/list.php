<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p>
            <?php echo btn_new('cms/eventorg/news_edit','Add Item');?>
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
        <!-- message -->
        <div id="message"></div>
        <div id="pagination"></div>
        <table id="table-data" class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>newsId</th>
                    <th>event</th>
                    <th>news_title</th>
                    <th>news_datetime</th>
                    <th>news_text</th>
                    <th>news_by</th>
                    <th>Type</th>
                    <th>img_path</th>
                    <th>video_path</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="data"><td colspan="11">No data</td></tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    $(document).ready(function(){
        //hide all ajax loader first
        $('.ajax-loader-small').hide();
        loadNews(1);
    });
    
    var limit = 10;
    function loadNews(page){
        if (page==='undefined'||page<1) page = 1;
        
        $('table#table-data tr.data').each(function(){$(this).remove();});
        
        $('table#table-data').append('<tr class="data"><td colspan="11">Loading data...</td></tr>');
        
        $.post("<?php echo site_url('ajax/cms');?>",{func:'wow_get_news_eventorg',page:page,limit:limit},function(result){
            $('table#table-data tr.data').each(function(){$(this).remove();});
            var data = jQuery.parseJSON(result);
            var image_url = '<?php echo config_item('userfiles') ;?>/wow/news/';
            var limit_text = 25;
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    var s = '<tr class="data">';
                    s+= '<td>'+(++start)+'</td>';
                    s+= '<td>'+d['id']+'</td>';
                    s+= '<td>'+d['event_name']+'</td>';
                    s+= '<td>'+d['news_title']+'</td>';
                    var date = d['news_datetime'].split(" ");
                    s+= '<td>'+date[0]+'</td>';
                    if(d['news_text'].length > limit_text){
                        var text = d['news_text'].substr(0,limit_text)+'...';
                    } else {
                        var text = d['news_text'];
                    }
                    s+= '<td>'+text+'</td>';
                    s+= '<td>'+d['news_by']+'</td>';
                    s+= '<td>'+d['type']+'</td>';
                    s+= '<td><img src="'+image_url+d['img_path']+'" width="50" height="50" /></td>';
                    s+= '<td>'+d['video_path']+'</td>';
                    s+= '<td>'+d['edit_url']+'|'+d['delete_url']+'</td>';
                    s+= "</tr>";

                    $('table#table-data').append(s);
                }
            }else{
                var s = '<tr class="data"><td colspan="11">No data</td></tr>';
                $('table#table-data').append(s);
                
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        });
    }
    
</script>