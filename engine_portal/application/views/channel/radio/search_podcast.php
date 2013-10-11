<style>
    ul.rod_list {
        list-style-type: none;
        padding: 0px;
        margin: 0px;
        font-size: 12px;
    }
    ul.rod_list li{
        border-bottom : 1px solid #697c8d;
        padding-top : 2px;
        padding-bottom : 2px;
    }

    ul.rod_list li a{
        color : #151515;
        text-decoration : none;
    }

    ul.rod_list li a:hover{
        color : #151515;
        text-decoration : underline;
    }    
    
    .category-title-container {
        color: #151515;
        font-size: 17px;
        margin-bottom: 10px;
    }
    .sub-cat-title-container {
        width: 100%;
        height : auto;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: center;
        border: 1px solid #797979;
        border-radius: 5px;
    }
</style>
<?php if (!empty($_GET['search_podcast'])) { ?>
<div class="category-title-container">
    Search Podcast
    </div>
    <div class="sub-cat-title-container">
        <?php echo $_GET['search_podcast']; ?>
    </div>

    <ul class="rod_list">
        <?php
        $no = 1;
        foreach ($search_podcast as $search_podcast) {
            ?>
            <li><a href="javascript:void(0);" onclick='javascript:loadRODPlayer("Podcast > <?php echo cleanString($search_podcast->title); ?>","<?php echo $search_podcast->file; ?>","<?php echo $search_podcast->attachment; ?>");'>
                <?php echo $search_podcast->title; ?></a>
            </li>
            <?php
            $no++;
        }
        ?>
    </ul>
<?php } ?>



