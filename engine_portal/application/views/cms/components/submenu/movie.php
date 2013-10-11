<ul class="dropdown-menu">
    <li>
        <a href="<?php echo site_url('cms/movie');?>">Category List</a>
    </li>
    <li>
        <a href="<?php echo site_url('cms/movie/items');?>">Item List</a>
    </li>
    <li>
        <a href="<?php echo site_url('cms/movie/featured');?>">Featured</a>
    </li>
    <li>
        <a href="<?php echo site_url('cms/movie/source');?>">Rating Source</a>
    </li>
    <li class="dropdown-submenu">
        <a class="dropdown-toggle" data-toggle="dropdown-submenu" href="#">
            Theater Schedule <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?php echo site_url('cms/movie/city');?>">City</a>
            </li>
            <li>
                <a href="<?php echo site_url('cms/movie/theater');?>">Theater</a>
            </li>
            <li>
                <a href="<?php echo site_url('cms/movie/schedule');?>">Schedule</a>
            </li>
        </ul>
    </li>
    <li class="dropdown-submenu">
        <a class="dropdown-toggle" data-toggle="dropdown-submenu" href="#">
            TOVI <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?php echo site_url('cms/tovi/parent');?>">TOVI Parent Category</a>
            </li>
            <li>
                <a href="<?php echo site_url('cms/tovi/category');?>">TOVI Category</a>
            </li>
            <li>
                <a href="<?php echo site_url('cms/tovi/items');?>">TOVI Items</a>
            </li>
        </ul>
    </li>

</ul>