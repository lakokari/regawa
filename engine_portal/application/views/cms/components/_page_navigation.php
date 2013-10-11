<header>
    <menu>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <a class="brand" href="#">UZone</a>
                <ul class="nav">
                    <?php //if ($this->user_m->is_user_has_access('MANAGE_CHANNELS')):?>
                    <?php if ($this->user_m->is_user_has_access('MANAGE_CHANNELS')):?>
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
                    <?php endif;?>
                    <?php 
						//check user group == Admin Wow
						$this->load->model('usergroup_m');
						$group_id = $this->session->userdata('group_id');
						$group_name = $this->usergroup_m->get_select_where('*', array('id'=>$group_id), TRUE)->group;
						
						if ($group_name == 'Admin Wow'):
					?>
                    <li class="dropdown<?php echo $active_menu=='wow'?' active':'';?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Wow <b class="caret"></b>
                        </a>
                        <?php $this->load->view('cms/components/submenu/wow'); ?>
                    </li>
                    <?php endif;?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="<?php echo site_url('auth/logout');?>">
                            Logout <b class="caret"></b>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </menu>
</header>