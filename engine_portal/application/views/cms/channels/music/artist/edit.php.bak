<link rel="stylesheet" type="text/css" media="screen"
     href="<?=base_url()?>assets/css/datepicker.css">


    <script type="text/javascript"
     src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
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
		<?php $this->table->add_row('Artist ID',  form_input('artistId', set_value('artistId',$channel->artistId)));?>
		<?php $this->table->add_row('Artist Name',  form_input('artistName', set_value('artistName',$channel->artistName)));?>
		<?php $this->table->add_row('Artist Name Origin',  form_input('artistNameOrigin', set_value('artistNameOrigin',$channel->artistNameOrigin)));?>
		<?php $this->table->add_row('artistLImgPath',  form_input('artistLImgPath', set_value('artistLImgPath',$channel->artistLImgPath)));?>
		<?php $this->table->add_row('artistSImgPath',  form_input('artistSImgPath', set_value('artistSImgPath',$channel->artistSImgPath)));?>
		<?php $this->table->add_row('Artist Role Type Cd',  form_input('artistRoleTypeCd', set_value('artistRoleTypeCd',$channel->artistRoleTypeCd)));?>
		<?php $this->table->add_row('Birthday',  form_input('birthday', set_value('birthday',$channel->birthday), "class='datepicker'"));?>
		<?php $this->table->add_row('Death Day',  form_input('deathday', set_value('deathday',$channel->deathday), "class='datepicker'"));?>
		<?php $this->table->add_row('Debut Day',  form_input('debutDay', set_value('debutDay',$channel->debutDay), "class='datepicker'"));?>

		<?php $this->table->add_row('Blood Type',  form_input('bloodType', set_value('bloodType',$channel->bloodType)));?>
		<?php $this->table->add_row('Religion',  form_input('religion', set_value('religion',$channel->religion)));?>
		<?php $this->table->add_row('Hobby',  form_input('hobby', set_value('hobby',$channel->hobby)));?>
		<?php $this->table->add_row('Artist Priority',  form_input('artistPriority', set_value('artistPriority',$channel->artistPriority)));?>
		<?php $this->table->add_row('Twitter Url',  form_input('twitterUrl', set_value('twitterUrl',$channel->twitterUrl)));?>
		<?php $this->table->add_row('Facebook Url',  form_input('facebookUrl', set_value('facebookUrl',$channel->facebookUrl)));?>
		<?php $this->table->add_row('Artist Role Type',  form_input('artistRoleType', set_value('artistRoleType',$channel->artistRoleType)));?>
		<?php $this->table->add_row('Homepage',  form_input('homepage', set_value('homepage',$channel->homepage)));?>
		<?php $this->table->add_row('Artist Group Member',  form_input('artistGroupMember', set_value('artistGroupMember',$channel->artistGroupMember)));?>
		<?php $this->table->add_row('Domestic',  form_dropdown('domesticYN', array('Y'=>'Y', 'N'=>'N'), $channel->domesticYN));?>
		<?php $this->table->add_row('Group',  form_dropdown('groupYN', array('Y'=>'Y', 'N'=>'N'), $channel->groupYN));?>
		<?php $this->table->add_row('nationalityCd',  form_input('nationalityCd', set_value('nationalityCd',$channel->nationalityCd)));?>
		<?php $this->table->add_row('gender',  form_input('gender', set_value('gender',$channel->gender)));?>
		<?php $this->table->add_row('artistMImgPath',  form_input('artistMImgPath', set_value('artistMImgPath',$channel->artistMImgPath)));?>
		<?php $this->table->add_row('nationality',  form_input('nationality', set_value('nationality',$channel->nationality)));?>
        <?php $this->table->add_row(
                form_submit('submit', 'Save', 'class="btn btn-primary"').' '. 
                form_button('cancel','Cancel','class="btn btn-primary" onclick="window.location=\''.  site_url('/cms/music/artist').'\';"'),''
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
		});
        $('select[name=categoryId]').change(function(){
            loadGenreByCategory($(this).val());
        });
		$('select[name=categoryId]').trigger('change');
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
					if("<?=$channel->genreId?>"==d['genreId']) s+="selected='selected'";
					s +=">"+d['genreName']+"</option>";

                }
            }else{
				 s += '<option value="">- Pilih Category -</option>';
			}
			$('select[name=genreId]').append(s);
            $('div#pagination').html(data['pagination']);
        });
    }
	
</script>