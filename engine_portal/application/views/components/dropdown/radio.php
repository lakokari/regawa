<div class="dropdown" id="kategori-radio">
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Category
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="category">
        <?php
        foreach ($sod_cat_list as $category) {
            echo "<li "; if($category->id == 1){echo "class='active'";}echo "><a href='#' data='". $category->id."'>".$category->category ."</a></option>";
        }
        ?>
    </ul>
</div>


<div class="dropdown" id="subcat-radio">
       
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        By Sub Category
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="cat-container">
        
    </ul>
</div>
<div class="loading-circle"></div>


