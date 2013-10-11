<div class="dropdown">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Category<b class="caret"></b>
    </a>
    <ul class="dropdown-menu atas" id='byfeature'>
        <?php foreach($subcategory as $category): ?>
        <li><a href='<?php echo base_url('movie/channel'); ?>#feature/<?php echo $category['name']; ?>' data="<?php echo $category['name']; ?>"><?php echo $category['title']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="ajax_loader" style="display: none;"></div>