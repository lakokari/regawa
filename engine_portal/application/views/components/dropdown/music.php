<div class="dropdown" id="kategori-musik">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Category <!-- 05/08/2013 by Alex -->
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="category">
        
        <?php 
        $no =1;
        foreach ($categories as $category) { ?>
        <?php if ($category->genreId==30) continue;?>
            <li><a href='#content/<?php echo $category->genreId; ?>/<?php echo $category->genreName; ?>' data="<?php echo $category->genreId; ?>"><?php echo $category->genreName; ?></a></li>
        <?php $no++; } ?>
    </ul>
</div>
<div class="dropdown" id="subkategori-musik">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Genre
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="cat-container">
        
    </ul>
</div>

 <div class="ajax_loader"></div> 