<style>
    #landing-page-book {
        background: white;
        color: #000;
    }
    
</style>
<div class="metro panorama" id="landing-page-book">
    <div class="panorama-sections">
        <h2>Search Result</h2>
        <div class="panorama-section tile-span-4" id="search-list">
        </div>
        <div class="panorama-section tile-span-4" id="search-list2">
        </div>
        <div class="container-fluid">
            <div id="pagination"></div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        showSearchResult(1);
    });
    
    function showSearchResult(page){
        //$('#panorama-scroll-prev').click();
        $.post('<?php echo site_url('ajax/search') ;?>',{func:'getSearchResult',page:page,limit:8},function(data){
            $('#search-list').empty();
            $('#search-list2').empty();
            if (data['size']>0){
                for (var i in data['items']){
                    
                    var d = data['items'][i];
                    var s = '<a href="<?php echo site_url() ;?>'+d['channel']+'/'+d['path']+'/'+d['id']+'" class="tile imagetext wide tile-span-8">';
                    s+= '<div class="row">';
                        s+= '<div class="tile-span-1">';
                            s+= '<img src="'+d['image']+'" width="100%" />';
                        s+= '</div>';
                        s+= '<div class="row-fluid">';
                            s+= '<strong>'+d['name']+'</strong>';
                            s+= '<p>'+d['description']+'</p>';
                        s+= '</div>';
                    s+= '</div>';
                    s+= "</a>";
                    
                    if (parseInt(i)%2===0)
                        $('#search-list').append(s);
                    else
                        $('#search-list2').append(s);
                }
            }else{
                $('#search-list').append("No data");
                $('div#pagination').empty();
            }
            
            $('div#pagination').html(data['pagination']);
        },'json');
    }
</script>