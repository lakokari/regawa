
<div class="channel-top-space"></div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="well well-small" style="margin-top: 150px;">
            <h3>Update Your Profile</h3>
        </div>
        
        <!-- if any errors -->
        <?php if(validation_errors() || $this->session->flashdata('error')){?>
        <div class="row-fluid" style="margin-top: 20px;">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert"></button>
                <?php echo validation_errors(); ?>
                <strong><?php echo $this->session->flashdata('error');?></strong>
            </div>
        </div>
        <?php }?>
        
        <form method="post" action="<?php echo site_url('auth/profile_update');?>">
            <table class="table">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" id="name" name="name" value="<?php echo set_value('name', $user->name);?>" /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" id="email" name="email" value="<?php echo set_value('email', $user->email);?>" /></td>
                </tr>
                <?php if ($user->type==0):?>
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
                <?php endif;?>
            </table>
            <input type="submit" value="Update" class="btn btn-primary">
            <input type="button" class="btn btn-primary" value="Cancel" onclick="window.location='<?php echo site_url();?>';">
        </form>
    </div>
    
    
</div>