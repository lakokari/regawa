<script>
/*
$(document).ready(function(){
    $('#search-box input').keypress(function (e){
        if(e.which === 13 && $(this).val()!=='') {
            searchMe($(this));
        }
    });
});

function searchMe(obj){
    var keyword = $(obj).parent().find('input').val();
    if (keyword !==''){
        window.location = "<?php echo site_url('search/index'); ?>/"+encodeURIComponent(keyword);
    }
}
*/
function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

<?php
if ($this->session->userdata('useetv_settoken')==1){
	$token_url = $this->session->userdata('useetv_tokenurl');
	echo 'var img = new Image();';
	echo 'img.src = "'.$token_url.'";';
	
	$this->session->set_userdata('useetv_settoken',0);
}
?>
</script>