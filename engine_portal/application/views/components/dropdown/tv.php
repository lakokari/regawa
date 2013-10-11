<div class="dropdown">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Category
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu atas" id='byfeature'>
        <?php foreach($categories as $category): ?>
        <li><a href='#' data="<?php echo $category->category_id; ?>" value="<?php echo $category->category_name; ?>"><?php echo $category->category_name; ?></a></li>
        <?php endforeach; ?>
        <li><a href='#' data="0" value="Other">Other</a></li>
        <li><a href='#' data="" value="" onclick='loadSliderStation()'>Live TV</a></li>
    </ul>
</div>