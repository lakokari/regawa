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
        <?php echo form_open();?>
        <?php echo form_label('Pilih Kategori');?>
        <?php $js = 'id="category" onChange="changeCategory(this.value);"'; ?>
        <?php echo form_dropdown('category', $channel_categories, $category_id, $js); ?>
        <?php echo form_close();?> 
        <?php echo create_pagination($channel_total_pages,$offset,  site_url('cms/items/index/'.$channel_id.'/'.$category_id.'/%i/'.$limit));?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category</th>
                    <th>Item Id</th>
                    <th>Item Name</th>
                    <th>Feature Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($channel_items)):
                $start=$offset*$limit+1;
                foreach($channel_items as $item): ?>
                <tr>
                    <td><?php echo $start++;?></td>
                    <td><?php echo $item->category_name;?></td>
                    <td><?php echo $item->item_id;?></td>
                    <td><?php echo $item->name;?></td>
                    <td><?php echo isset($item->cover)?'<img src="'.  site_url('images/feature_list').'/'.$channel_name.'/'. $item->cover.'" width="50" height="50" />':'no-image';?></td>
                    <td>
                        <?php echo btn_edit(site_url('cms/items/edit').'/'.$item->channel_id.'/'.$item->item_id.'/'.$offset.'/'.$limit, 'title="Update feature image"'); ?>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else: ?>
                <tr><td colspan="6">No data</td></tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php echo create_pagination($channel_total_pages,$offset,  site_url('cms/items/index/'.$channel_id.'/'.$category_id.'/%i/'.$limit));?>
    </div>
</section>

<script>
    function changeCategory(categoryId){
        window.location = "<?php echo site_url('cms/items/index/'.$channel_id);?>/"+categoryId;
    }
</script>