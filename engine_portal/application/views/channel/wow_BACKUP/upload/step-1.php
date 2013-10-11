<style>
    .tengah{
        margin-left: auto;
        margin-right: auto;
        width: 555px;
    }
    .kecil {
        width: 600px;
        margin-top: 50px;
    } 
    .list_item{
        list-style-type: none;
        text-align: center;
        margin-top: 0;
        margin-bottom: 0;
        margin-left: auto;
        margin-right: auto;	
        padding: 0;
    }
    li.wow_event_list{
        display: inline; 
        width: 165px;
        padding: 10px;
        float: left;
    }
    li.wow_event_list img {
        width: 100%;
        height: auto;
    }
    .title-project {
        width: 100%;
        height: 30px;
        float : left;
        border-bottom: 2px solid #cccccc;
    }
    .title-project-text {
        width: 100%;
        height: 20px;
        padding-top : 5px;
        text-align: left;
        font-size: 13px;
        color : #d31821;
        font-weight: bold;
    }
    
    .project-icon-star {
        width: 30px;
        height: 30px;
        float : left;
        border-right: 1px solid #ccc;
        margin-right: 8px;
        background: url(<?php echo config_item('assets_wow'); ?>images/icon-star.png);
        background-position: center center;
        background-repeat: no-repeat;     
    }
    .project-icon-music {
        width: 30px;
        height: 30px;
        float : left;
        border-right: 1px solid #ccc;
        margin-right: 8px;
        background: url(<?php echo config_item('assets_wow'); ?>images/icon-music.png);
        background-position: center center;
        background-repeat: no-repeat;     
    }
    .project-icon-movie {
        width: 30px;
        height: 30px;
        float : left;
        border-right: 1px solid #ccc;
        margin-right: 8px;
        background: url(<?php echo config_item('assets_wow'); ?>images/icon-movie.png);
        background-position: center center;
        background-repeat: no-repeat;     
    }
    
    .deskripsi-project {
        width : 100%;
        height : auto;
        padding-top : 10px;
        float : left;
    }
    
</style>
<div class="container kecil">
    <div class="tengah">
        <?php if (isset($categories)): ?>
            <ul class="list_item">
                <?php $i=1; foreach ($categories as $category): ?>
                    <li class="wow_event_list">
                        <a class="wow-event" href="javascript:void(0);" onclick="goNext(<?php echo $category->category_id; ?>);" data="<?php echo $category->category_id; ?>">
                            <img src="<?php echo config_item('assets_wow') . 'images/' . $category->image_preview; ?>" height="30" width="150"/>
                        </a>
                        <div class="title-project">
                            <?php if($i==1) { 
                                echo '<div class="project-icon-star"></div>'; 
                            } else if ($i==2) {
                                echo '<div class="project-icon-music"></div>'; 
                            } else if ($i==3){
                                echo '<div class="project-icon-movie"></div>'; 
                            }
                            ?>
                            <div class="title-project-text">
                                <?php echo $category->category_title; ?>
                            </div>
                        </div>
                        <div class="deskripsi-project">
                            <?php echo $category->synopsis_category; ?> 
                        </div>
                    </li>
                <?php $i++; endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>