<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p><?php echo btn_syncronize(site_url('cms/music/sync/category'), ' Syncronize Category') ;?></p>
		<p>
            <?php echo btn_new('cms/music/category_edit','Add Category');?>
        </p>
    </div>

</section>

<section id="main-page">
    <div class="container-fluid">
        <?php echo create_pagination($page_total,$page_offset,$page_url);?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>categoryId</th>
                    <th>categoryName</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($data)):
                $start=$page_offset+1;
                foreach($data as $item): ?>
                <tr>
                    <td><?php echo $start++;?></td>
                    <td><?php echo $item->genreId;?></td>
                    <td><?php echo $item->genreName;?></td>
                    <td>
                        <?php echo btn_edit(site_url('cms/music/category_edit').'/'.$item->id, 'title="Update category"'); ?>
                        <?php echo btn_delete(site_url('cms/music/category_delete').'/'.$item->id, 'title="Delete category"'); ?>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else: ?>
                <tr><td colspan="4">No data</td></tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php echo create_pagination($page_total,$page_offset,$page_url);?>
    </div>
</section>
