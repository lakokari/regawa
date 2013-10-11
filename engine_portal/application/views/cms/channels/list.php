<section id="title-page">
    <div class="container-fluid">
        <h1><?php echo $page_title;?></h1>
        <p><?php echo btn_new('cms/channels/edit') ;?></p>
    </div>
</section>
<section id="message">
    <?php if (isset($error)) echo '<p>'.$error.'</p>';?>
    <?php if (isset($message)) echo '<p>'.$message.'</p>';?>
</section>

<section id="main-page">
    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Channel Name</th>
                    <th>Channel Title</th>
                    <th>Channel Desc</th>
                    <th>Order</th>
                    <th>Show</th>
                    <th>Cover</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($channel_list as $channel): ?>
                <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $channel->name;?></td>
                    <td><?php echo $channel->title;?></td>
                    <td><?php echo $channel->description;?></td>
                    <td><?php echo $channel->sort;?></td>
                    <td><?php echo $channel->showed?'Yes':'No';?></td>
                    <td><?php echo ($channel->cover)?'<img src="'.site_url(config_item('channel_img_url')).'/thumbs/'. $channel->cover.'" width="50" height="50" />':'no-image';?></td>
                    
                    <td>
                        <?php echo btn_edit(site_url('cms/channels/edit').'/'.$channel->id); ?>
                        <?php echo btn_delete(site_url('cms/channels/delete').'/'.$channel->id); ?>
                        <?php //echo btn_syncronize(site_url('cms/channels/sync').'/'.$channel->id); ?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</section>