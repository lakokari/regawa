<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
		<p>
            <?php echo btn_new('cms/news/edit/'.$this->uri->segment(4),'Add News');?>
        </p>
        <p><?php echo btn_syncronize(site_url('cms/music/sync/category'), ' Syncronize News') ;?></p>
    </div>
</section>
<section id="main-page">
    <div class="container-fluid">
        <?php echo create_pagination($page_total,$page_offset,$page_url);?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>newsId</th>
                    <th>item_id</th>
					<th>news_title</th>
					<th>news_datetime</th>
					<th>news_text</th>
					<th>news_by</th>
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
					<td><?php echo $item->id;?></td>
                    <td><?php echo $item->item_id;?></td>
                    <td><?php echo $item->news_title;?></td>
					<td><?php echo $item->news_datetime;?></td>
					<td><?php echo substr($item->news_text, 0, 200);?></td>
					<td><?php echo $item->news_by;?></td>
                    <td>
                        <?php echo btn_edit(site_url('cms/news/edit').'/'.$item->channel_name.'/'.$item->id, 'title="Update News"'); ?>
                        <?php echo btn_delete(site_url('cms/news/delete').'/'.$item->id.'/'.$item->channel_name, 'title="Delete News"'); ?>
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
