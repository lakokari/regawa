    <script src="<?php echo config_item('assets_wow'); ?>js/jquery.swipeplanes-1.2.js"></script>
	<div class="content-container">
            <style>
                /*coming soon style*/
                .coming-soon-wrap {
                    margin-right: auto;
                    margin-left: auto;
                    width: 505px;
                    height: 440px;
                }
                .coming-soon-title {
                    border-top: 1px solid white;
                    border-bottom: 1px solid white;
                    padding: 30px 0;
                    font-size: 81px;
                    font-weight: bold;
                    letter-spacing: -9px;
                    height: 91px;                    
                }
                .coming-soon-desc {
                    text-align: center;
                    font-weight: bold;
                    font-size: 20px;
                    padding: 23px 20px;                    
                }

                .coming-soon-btn-wrap {
                    width: 100%;
                    height: 63px;
                    margin-top: 8px;
                    color: white;
                    font-size: 20px;
                    font-weight: bold                 
                }

                .coming-soon-btn-red {
                    background-color: red;
                    float: left;
                    height: 39px;
                    width: 168px;
                    text-align: center;
                    padding-top: 18px; 
                    cursor: pointer;
                }

                .coming-soon-btn {
                    background-color: black;
                    float: left;
                    height: 39px;
                    width: 162px;
                    text-align: center;
                    padding-top: 18px;
                    margin-left: 5px;                  
                    cursor: pointer;
                }
                a.coming-soon-btn:link {text-decoration:none;}
                .coming-soon-email {

                }
                .coming-soon-email-wrap .coming-soon-btn-red {
                    float: left;
                    width: 76px;
                    height: 30px;
                    padding-top: 13px;                    
                }
                .coming-soon-email-input {
                    float: left;
                    width: 427px;
                    height: 41px;
                    background-color: rgba(255,255,255,0.1);
                    border: 1px solid rgba(255, 255, 255, .1);
                }

                .coming-soon-email-input input {
                    height: 100%;
                    width: 100%;
                    border: none;
                    background-color: rgba(255,255,255,0);
                    color: white;
                    font-size: 21px;
                    padding: 0 5px;
                }

                .coming-soon-social-wrap {

                }
                .coming-soon-social-wrap a{
                    font-size: 16px;
                }
                .coming-soon-social-wrap .social-fb-wrap {
                    float: left;
                    margin-left: 92px;
                    padding-top: 10px;                    
                }
                .coming-soon-social-wrap .social-tw-wrap {
                    float: left;
                    margin-left: 45px;
                    margin-top: 7px;                    
                }
            </style>
            <div class="coming-soon-wrap">
                <div class="coming-soon-title">COMING SOON</div>
                <div class="coming-soon-desc">This website is actually under construction, We will be live soon, stay tuned!</div>
                <div class="coming-soon-btn-wrap">
                    <div class="coming-soon-btn-red">Notify</div>
                    <div class="coming-soon-btn" onclick="javascript:window.history.back()">Go Back</div>
                    <a href="<?php echo site_url('wow/channel/contact'); ?>" class="coming-soon-btn">Contact Us</a>
                </div>
                <div class="coming-soon-email-wrap">
                    <div class="coming-soon-email-input"><input type="text" placeholder="Email me when it's ready"></div>
                    <div class="coming-soon-btn-red">Send</div>
                </div>
                <div class="coming-soon-social-wrap">
                    <div class="social-fb-wrap"><a href="https://www.facebook.com/UZoneIndonesia" target="_blank" class="footer-sosmed facebook">/UZoneIndonesia</a></div>
                    <div class="social-tw-wrap"><a href="https://www.twitter.com/uzoneindonesia" target="_blank" class="footer-sosmed twitter">@uzoneindonesia</a></div>
                </div>  
            </div>
            
<?php if (isset($page))$this->load->view('channel/wow/page/footer'); ?>