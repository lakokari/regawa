<div class="dropdown" id="cat-container">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Category
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="kategory-buku">
        <?php foreach ($categories as $category): ?>
            <li>
                <a href='#' data="<?php echo $category->category_id; ?>" name="<?php echo $category->category_name; ?>"><?php echo $category->category_name; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>