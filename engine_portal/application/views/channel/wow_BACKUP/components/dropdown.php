<?php $i = 1; ?>
<?php foreach($event_active as $event): ?>
    <li><a href="#"><?php echo $event->name; ?></a>
        <ul>
            <?php foreach($dropdown[$i] as $drop): ?>
                <?php if($drop->display_order >= 1){ ?>
                    <?php if($drop->content == NULL){ ?>
                        <li><a href="<?php echo base_url('wow/channel').'/gallery/'.$drop->event_id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                    <?php } else { ?>
                        <li><a href="<?php echo base_url('wow/read').'/index/'.$drop->id; ?>" data="<?php echo $drop->id; ?>"><?php echo $drop->title; ?></a></li>
                    <?php } ?>
                <?php } ?>
            <?php endforeach; ?>
        </ul>
    </li>
    <?php $i++; ?>
<?php endforeach; ?>
<?php if($this->user_m->is_loggedin()){ ?>
<li><a href="<?php echo base_url('wow/channel/mygallery'); ?>">My
Gallery</a></li>
<?php } ?>