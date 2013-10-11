<header>
    <menu>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <a class="brand" href="#">UZone</a>
                <ul class="nav">
                    <li class="dropdown<?php echo $active_menu=='channels'?' active':'';?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Channels <b class="caret"></b>
                        </a>
                        <?php $this->load->view('cms/components/submenu/channel'); ?>
                    </li>
                    <?php foreach($channel_list as $channel):?>
                    <li class="dropdown<?php echo $active_menu==$channel->name?' active':'';?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo $channel->title; ?> <b class="caret"></b>
                        </a>
                        <?php $this->load->view('cms/components/submenu/'.$channel->name, $channel); ?>
                    </li>
                    <?php endforeach; ?>
                    <li class="dropdown<?php echo $active_menu=='users'?' active':'';?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            User Management <b class="caret"></b>
                        </a>
                        <?php $this->load->view('cms/components/submenu/users'); ?>
                    </li>
                </ul>
            </div>
        </div>
    </menu>
</header>