<form class="" method="post" action="<?php echo site_url('auth/internallogin/'.str_replace('/', '-', $this->uri->uri_string()));?>">
    <label for="win-theme-select">Insert your UZone account </label>
    <input type="text" id="u_name" name="u_name" placeholder="Username">
    <input type="password" id="u_password" name="u_password" placeholder="Password">
    <input type="submit" value="Signin">
</form>

