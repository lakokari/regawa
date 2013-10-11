<div class="dropdown" id="ddcat">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Device
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="device">
            <?php foreach ($parentcategories as $parentcategory): ?>
            <li><a href="#" data="<?php echo $parentcategory->id; ?>"><?php echo $parentcategory->name; ?></a></li>
            <?php endforeach; ?>
    </ul>
</div>

<div class="dropdown" id="ddsubcat">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Content
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="cat-container">
        
    </ul>
</div>