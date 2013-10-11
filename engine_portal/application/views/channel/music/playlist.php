<table class="table table-striped">
    <?php for($i=count($playlist)-1, $num=1;$i>=0;$i--, $num++):?>
    <tr>
        <td><?php echo $playlist[$i]['songName']; ?></td>
        <td><?php echo $playlist[$i]['artistName']; ?></td>
        <td><a href="javascript:showAlbumDetail(<?php echo $playlist[$i]['albumId'];?>);">Show</a></td>
    </tr>
    <?php if ($num==10) break;?>
    <?php endfor;?>
</table>
