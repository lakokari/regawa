<div class="dropdown" id="cat-container">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Category
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="kategory-games">
        <?php foreach ($categories as $category): ?>
            <li>
                <a href="<?php echo base_url('games/channel').'#'.str_replace(' ','_',$category->category_name); ?>" data="<?php echo $category->category_name; ?>"><?php echo $category->category_name; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>