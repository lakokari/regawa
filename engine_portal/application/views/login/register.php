<?php if (($register_window)):?>
<div class="channel-top-space"></div>
<div class="container-fluid" style="margin-top:120px;">
    <div class="well well-small"><h2>Register UZone Account</h2></div>
<?php endif;?>
    
<?php if(validation_errors() || $this->session->flashdata('error')){?>
    <section id="update-error">
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert"></button>
            <?php echo validation_errors(); ?>
            <strong><?php echo $this->session->flashdata('error');?></strong>
        </div>
    </section>
<?php }?>
<?php if (!isset($registered)||!$registered):?>
<form method="post" action="<?php echo site_url('auth/register');?>">
    <table class="table">
        <tr>
            <td>Full Name</td>
            <td><input type="text" id="name" name="name" value="<?php echo set_value('name');?>" /></td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td><input type="text" id="email" name="email" value="<?php echo set_value('email');?>" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" id="u_name" name="u_name" value="<?php echo set_value('u_name');?>" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" id="u_password" name="u_password" value="" /></td>
        </tr>
        <tr>
            <td>Password Confirmation</td>
            <td><input type="password" id="u_password_conf" name="u_password_conf" value="" /></td>
        </tr>
    </table>
    <input type="submit" value="Register" class="btn btn-primary">
    <?php if (($register_window)):?>
    <input type="button" class="btn btn-primary" value="Cancel" onclick="window.location='<?php echo site_url('auth');?>';">
    <?php endif;?>
</form>
<?php elseif(isset($registered)&&$registered):?>
    <p>Selamat. Account anda berhasil dibuat. Silakan login dari menu login yang disediakan</p>
<?php endif; ?>
<?php if (($register_window)):?>
</div>
<?php endif;?>