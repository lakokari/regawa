<div class="dropdown" >
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        <?php echo (isset($category_active_name)?$category_active_name:'Featured');?>
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="byfeature">
        <?php foreach ($categories as $category): ?>
        <li><a href="
            <?php 
            if($category->id == 2) {
                echo base_url('wow/read/index/24/');
            }elseif($category->id == 3) {
                echo base_url('wow/read/index/23/');
            }else{
                echo base_url('wow/channel/event').'/'.$category->slug; 
            }
            ?>
               " data="<?php echo $category->id; ?>"><?php echo $category->name; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php //if (isset($static_menu)):?>
<?php if (0):?>
<div class="dropdown" >
    <a class="header-dropdown dropdown-toggle accent-color" data-toggle="dropdown" href="#">
        Pilih Menu
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu" id="byfeature">
        <?php foreach ($static_menu as $menu): ?>
        <li><a href="<?php echo base_url('wow/read/index').'/'.$menu->id; ?>" data="<?php echo $menu->id; ?>"><?php echo $menu->title; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif;?>

<div class="dropdown">
    <?php if ($this->session->flashdata('upload_message')): ?>
    <div id="alert" class="alert alert-error" style="max-width:300px;">
        <strong><?php echo $this->session->flashdata('upload_message');?></strong>
    </div>
    <?php endif;?>
</div>