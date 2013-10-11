<link rel="stylesheet" type="text/css" media="screen"
     href="<?php echo config_item('assets_url'); ?>css/datepicker.css">


    <script type="text/javascript"
     src="<?php echo config_item('assets_url'); ?>js/bootstrap-datepicker.js"></script>
<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
    </div>
</section>

<!-- if any errors -->
<?php if(validation_errors() || $this->session->flashdata('error')){?>
<section id="update-error">
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo validation_errors(); ?>
        <strong><?php echo $this->session->flashdata('error');?></strong>
    </div>
</section>
<?php }?>
<section id="main-page">
    <div class="container-fluid">
        <?php echo form_open_multipart();?>
        <?php $this->table->set_template($table_tmpl);?>
		<?php $this->table->add_row('Category ID',  form_dropdown('categoryId', $items, $channel->categoryId));?>
		<?php $this->table->add_row('Genre ID',  form_dropdown('genreId', array(''=>'- Pilih Genre -')));?>
		<?php $this->table->add_row('Artist ID',  form_dropdown('artistId'));?>
		<?php $this->table->add_row('Album ID',  form_dropdown('albumId', array(''=>'- Pilih Album -')));?>
		<?php $this->table->add_row('Song ID',  form_input('songId', set_value('songId',$channel->songId)));?>
		<?php $this->table->add_row('Song Name',  form_input('songName', set_value('songName',$channel->songName)));?>
		<?php $this->table->add_row('Song Name Origin',  form_input('songNameOrigin', set_value('songNameOrigin',$channel->songNameOrigin)));?>
		<?php $this->table->add_row('PlayTime',  form_input('playtime', set_value('playtime',$channel->playtime)));?>
		<?php $this->table->add_row('Adult',  form_dropdown('adultYN', array('Y'=>'Y', 'N'=>'N'), $channel->adultYN));?>
		<?php $this->table->add_row('MOD',  form_dropdown('modYN', array('Y'=>'Y', 'N'=>'N'), $channel->modYN));?>
		<?php $this->table->add_row('VOD',  form_dropdown('vodYN', array('Y'=>'Y', 'N'=>'N'), $channel->vodYN));?>
		<?php $this->table->add_row('Sell Stream',  form_dropdown('sellStreamYN', array('Y'=>'Y', 'N'=>'N'), $channel->sellStreamYN));?>
		<?php $this->table->add_row('Sell Drm',  form_dropdown('sellDrmYN', array('Y'=>'Y', 'N'=>'N'), $channel->sellDrmYN));?>
		<?php $this->table->add_row('Sell Non Drm',  form_dropdown('sellNonDrmYN', array('Y'=>'Y', 'N'=>'N'), $channel->sellNonDrmYN));?>
		<?php $this->table->add_row('Sell Alacarte',  form_dropdown('sellAlacarteYN', array('Y'=>'Y', 'N'=>'N'), $channel->sellAlacarteYN));?>
		<?php $this->table->add_row('SLF Lyric',  form_dropdown('slfLyricYN', array('Y'=>'Y', 'N'=>'N'), $channel->slfLyricYN));?>
		<?php $this->table->add_row('Text Lyric',  form_dropdown('textLyricYN', array('Y'=>'Y', 'N'=>'N'), $channel->textLyricYN));?>
		<?php $this->table->add_row('RT',  form_dropdown('rtYN', array('Y'=>'Y', 'N'=>'N'), $channel->rtYN));?>
		<?php $this->table->add_row('RBT',  form_dropdown('rbtYN', array('Y'=>'Y', 'N'=>'N'), $channel->rbtYN));?>
		<?php $this->table->add_row('Available',  form_dropdown('availableYN', array('Y'=>'Y', 'N'=>'N'), $channel->availableYN));?>
		<?php $this->table->add_row('Disk No',  form_input('diskNo', set_value('diskNo',$channel->diskNo)));?>
		<?php $this->table->add_row('Track No',  form_input('trackNo', set_value('trackNo',$channel->trackNo)));?>
		<?php $this->table->add_row('Title Song',  form_dropdown('titleSongYN', array('Y'=>'Y', 'N'=>'N'), $channel->titleSongYN));?>
		<?php $this->table->add_row('hitSongYN',  form_input('hitSongYN', set_value('hitSongYN',$channel->hitSongYN)));?>
		<?php $this->table->add_row('Drm Price',  form_input('drmPrice', set_value('drmPrice',$channel->drmPrice)));?>
		<?php $this->table->add_row('Non Drm Price',  form_input('nonDrmPrice', set_value('nonDrmPrice',$channel->nonDrmPrice)));?>
		<?php $this->table->add_row('Issue Date',  form_input('issueDate', set_value('issueDate',$channel->issueDate), "class='datepicker'"));?>
		<?php $this->table->add_row('drmPaymentProdId',  form_input('drmPaymentProdId', set_value('drmPaymentProdId',$channel->drmPaymentProdId)));?>
		<?php $this->table->add_row('nonDrmPaymentProdId',  form_input('nonDrmPaymentProdId', set_value('nonDrmPaymentProdId',$channel->nonDrmPaymentProdId)));?>
		<?php $this->table->add_row('lcStatusCd',  form_input('lcStatusCd', set_value('lcStatusCd',$channel->lcStatusCd)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/music/song').'\';"'),''
              );
        ?>
        
        <?php echo $this->table->generate();?>
        <?php echo form_close();?>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		}).on('changeDate', function(ev) {
			$(this).val($(this).val().replace(/-/g,''));
		});
        $('select[name=categoryId]').change(function(){
            loadGenreByCategory($(this).val());
        });
		$('select[name=categoryId]').trigger('change');
		$('select[name=genreId]').change(function(){
            loadArtistByGenre($(this).val());
        });
		$('select[name=artistId]').change(function(){
            loadAlbumByGenre($(this).val());
        });
    });

	function loadGenreByCategory(categoryId){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_genre_by_category',categoryId:categoryId},function(result){
            var data = jQuery.parseJSON(result);
            $('select[name=genreId]').html('');
			 var s='';
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    s += "<option value='"+d['genreId']+"'";
					if("<?php echo $channel->genreId?>"==d['genreId']) s+="selected='selected'";
					s +=">"+d['genreName']+"</option>";

                }
            }else{
				 s += '<option value="">- Pilih Category -</option>';
			}
			$('select[name=genreId]').append(s);
			$('select[name=genreId]').trigger('change');
            $('div#pagination').html(data['pagination']);
        });
    }
	function loadArtistByGenre(genreId){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_artist_by_genre',genreId:genreId},function(result){
            var data = jQuery.parseJSON(result);
			 var s;
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    s += "<option value='"+d['artistId']+"'";
					if("<?php echo $channel->artistId?>"==d['artistId']) s+="selected='selected'";
					s +=">"+d['artistName']+"</option>";
                }
            }else{
				 s += '<option value="">- Pilih Artist -</option>';
			}
			$('select[name=artistId]').html(s);
			$('select[name=artistId]').trigger('change');
            $('div#pagination').html(data['pagination']);
        });
    }
	function loadAlbumByGenre(artistId){
        $.post("<?php echo site_url('ajax/cms');?>",{func:'get_album_by_artist',artistId:artistId},function(result){
            var data = jQuery.parseJSON(result);
			 var s;
            if (data['size']>0){
                var start = parseInt(data['start']);
                for(var i in data['items']){
                    var d = data['items'][i];
                    s += "<option value='"+d['albumId']+"'";
					if("<?php echo $channel->albumId?>"==d['albumId']) s+="selected='selected'";
					s +=">"+d['albumName']+"</option>";
                }
            }else{
				 s += '<option value="">- Pilih ALbum -</option>';
			}
			$('select[name=albumId]').html(s);
            $('div#pagination').html(data['pagination']);
        });
    }

	
</script>