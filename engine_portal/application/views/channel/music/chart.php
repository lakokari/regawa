<table class="table table-striped">
    <tr>
        <th>Ranking</th>
        <th>Album Name</th>
        <th>Artist Name</th>
        <th></th>
    </tr>
    <?php $i=1; foreach($chart->dataList as $album):?>
    <tr>
        <td><?php echo $album->ranking;?></td>
        <td><?php echo $album->songName;?></td>
        <td><?php echo $album->artistName;?></td>
        <td><a href="javascript:showAlbumDetail(<?php echo $album->albumId;?>);">Show</a></td>
    </tr>
    <?php if ($i>4) break; ?>
    <?php $i++; endforeach; ?>
</table>