<div style="width: 100%; height: 5px; margin-bottom: 5px; float: left; border: 1px ">
</div>
<div class="channel-top-space"></div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span7">
            <div class="row-fluid">
                <div class="well well-small">
                    <h3>Register UZone Account</h3>
                </div>

                <?php $this->load->view('login/register');?>
            </div>
        </div>
        <div class="span4">
            <div class="row-fluid">
                <!-- internal login -->
                <div class="well well-small">
                    <h3>Insert your UZone account</h3>
                </div>
                <?php $this->load->view('login/login_internal');?>
            </div>
            <!-- social media login -->
            <div class="row-fluid">
                <div class="well well-small">
                    <h3>Or Login using social media account</h3>
                </div>
                <?php $this->load->view('login/socialmedia');?>
            </div>
        </div>
    </div>
    
    
</div>