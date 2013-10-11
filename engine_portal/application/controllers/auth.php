<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Auth
 *
 * @author master
 */
class Auth extends U_Controller {
    
    protected $referrer = NULL;
    function __construct() {
        parent::__construct();
        
        //$this->load->library('session');
        //$this->load->model('user_m');
        
        //load library validation
        $this->load->library('form_validation');
        
        //This parse_str important for CI to use facebook sdk properly
        parse_str( $this->input->server('QUERY_STRING'), $_REQUEST );
        
        /****************************** FACEBOOK LOGIN BASIC ****************************/
        //load Facebook Auth Lib
        $this->load->library(
            'facebook/Facebook',
                array(
                    'appId'     =>  config_item('fb_app_id'), 
                    'secret'    =>  config_item('fb_app_secret'),
                    'cookie'    =>  TRUE
             )
        );
        
        //set facebook login url once, and destroy after logout
        if (!$this->session->userdata('facebook_login_url')){
            $fb_login_redirect= site_url('auth/fb_login');
            $fb_login_url = $this->facebook->getLoginUrl(
                    array(
                        'redirect_uri'=>$fb_login_redirect,
                        'scope'=> config_item('fb_scope')
                    )
            );
            $this->session->set_userdata('facebook_login_url', $fb_login_url);
        }
        /***************** END OF FACEBOOK LOGIN BASIC ************************/
    }
    
    protected function _create_auth_log($message, $writeLine=FALSE){
        $folder = SITE_PATH .'_temp';
        $file_log = 'login_log.log';
        
        if (!file_exists($folder)){
            mkdir($folder, 0777, TRUE);
        }
        
        // Get time of request
        if( ($time = $_SERVER['REQUEST_TIME']) == '') {
            $time = time();
        }
 
        // Get IP address
        if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
            $remote_addr = "REMOTE_ADDR_UNKNOWN";
        }
 
        // Get requested script
        if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
            $request_uri = "REQUEST_URI_UNKNOWN";
        }

        // Format the date and time
        $date = date("Y-m-d H:i:s", $time);

        // Append to the log file
        if($fd = @fopen($folder . '/'. $file_log, "a")) {
            fputcsv($fd, array($date, $remote_addr, $message));
            //fputcsv($fd, array($date, $message));
            if ($writeLine){
                fputs($fd, str_repeat('*', 70).PHP_EOL);
            }
            fclose($fd);
        }
    }
    
    public function read_log(){
        $folder = SITE_PATH .'_temp';
        $file_log = 'login_log.log';
        
        if (file_exists($folder .'/'. $file_log)){
            echo nl2br(file_get_contents($folder .'/'.$file_log));
        }else{
            echo 'No log file found';
        }
    }
    public function clear_log(){
        $folder = SITE_PATH .'_temp';
        $file_log = 'login_log.log';
        
        if (file_exists($folder .'/'. $file_log)){
            unlink($folder .'/' . $file_log);
        }
        
        echo 'Log file cleared !';
    }
    
    public function index(){
        !$this->user_m->is_loggedin() || redirect('cms/admin');
        
        //load helper form
        $this->load->helper('form');
        
        $this->data['facebook_login_url'] = $this->session->userdata('facebook_login_url');
        
        //Load Twitter Auth Lib
        $tw_login_redirect= site_url('auth/tw_login');
        $this->data['twitter_login_url'] = $tw_login_redirect;
        
        $this->data['register_window'] = FALSE;
        //set active menu
        $this->data['active_menu'] = 'login';        
        
        $this->data['subview'] = 'login/index';
        $this->load->view('_layout_main', $this->data);
    }
    
    /**
     * Logout and clear session
     */
    public function logout($retUrl=NULL){
        if (!$retUrl) $retUrl = 'home';
        
        $clientapp = $this->session->userdata('clientapp');
        //create auth log
        $this->_create_auth_log('user '.$this->session->userdata('username'). ' is trying to logout');
        
        $this->user_m->logout();
        
        //check wheather if user was loggedin using fb, then logout also fb
        
        if ($clientapp){
            $clientapp = base64_decode($clientapp);
            if ($clientapp=='facebook'){
                $this->load->library('facebook/Facebook',array('appId'=>  config_item('fb_app_id'), 'secret'=>  config_item('fb_app_secret')));
                $this->facebook->destroySession();
            }
        }
        
        //if not from clientapp these line below will be executed
        
        if ($retUrl){
            $retUrl = str_replace('-', '/', cleanString($retUrl));
        }
        
        redirect($retUrl);
    }
    
    /**
     * Register new account
     */
    public function register($retUrl=NULL, $send_email = FALSE){
        $this->data['registered'] = FALSE;
        
        $rules = $this->user_m->rules_new;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // get all post data
            $post_data = $this->user_m->array_from_post(array('name','email','u_name','u_password'));
            $post_data['u_password'] = $this->user_m->hash($post_data['u_password']);
            $post_data['group_id'] = 2; //Member
            //auto active
            $post_data['is_activeYN'] = 'y';
            if ($this->user_m->save($post_data) == TRUE) {
                //do we need to send email to the user
                if ($send_email && $post_data['email']!=''){
                    $message_body = 'Selamat. Pendaftaran akun UZone anda berhasil.'.PHP_EOL;
                    $message_body.= 'Username anda:'. $post_data['u_name'].' dan password:'.  $this->input->post('u_password');
                    $email = array(
                        'from_email'    =>  'webmaster@uzone.co.id',
                        'from_name'     =>  'UZone',
                        'to_email'      =>  $post_data['email'],
                        'subject'       =>  'UZone - Registrasi Berhasil',
                        'message'       =>  $message_body
                    );
                    
                    $result = $this->simpleMail($email);
                    if (!$result){
                        $this->session->set_flashdata('error','Email new created accound failed while sent');
                    }
                }
                $this->session->set_flashdata('error', 'Your account has been created successfully. Please login using menu above if has activated');
                
                $this->data['registered'] = TRUE;
            } else {
                $this->session->set_flashdata('error', 'Kombinasi Username / password tidak ditemukan');
                redirect('auth');
            }
        }
        $this->data['register_window'] = TRUE;
        //set active menu
        $this->data['active_menu'] = 'login';        
        
        $this->data['subview'] = 'login/register';
        $this->load->view('_layout_main', $this->data);
    }

    
    /**
     * Login for internal user (UZone account)
     * @param type $retUrl
     */
    public function internallogin($retUrl=NULL){
        if ($retUrl) 
            $retUrl = str_replace ('-', '/', $retUrl);
        else
            $retUrl = 'wow/channel';
        
        if ($this->user_m->is_loggedin()){
            if ($this->user_m->can_cp())
                redirect('cms/admin');
            else 
                redirect($retUrl);
        }
        // Set form
        $rules = $this->user_m->rules_login;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            if ($this->user_m->login() == TRUE) {
                //create auth log
                $this->_create_auth_log('user '.$this->session->userdata('username'). ' is login');
                
                if ($this->user_m->can_cp()){                    
                    redirect('cms/admin');
                }else{
                    redirect($retUrl);
                }
            } else {
                $this->session->set_flashdata('error', 'Kombinasi Username / password tidak ditemukan');
                redirect('auth');
            }
        }
    }
    
    
    /**
     * Login by Facebook Account
     */    
    
    public function fb_login_init($retUrl=NULL){
        //Save the return url into session
        if (!$retUrl) $retUrl = 'home';
        $this->session->set_userdata('sosmed_login_ret_url', $retUrl);
        
        //create auth log
        $this->_create_auth_log('user is trying login using facebook');
                    
        //check if some one is loggedin facebook
        $userfb = $this->facebook->getUser();
        if($userfb){
            return $this->fb_get_data($userfb);
        }else{
            
            //create auth log
            $this->_create_auth_log('user is not logged in facebook, redirecting to facebook login');
        
            //If not,  redirect to facebook to login
            $fb_login_url = $this->session->userdata('facebook_login_url');

            //Redirect to facebook for login, the FB will return to our auth/fb_login
            echo '<script> top.location.href=\''.$fb_login_url.'\'</script>';
            //echo "<script>window.location.href='$fb_login_url';</script>";
        }
    }
    
    public function fb_login(){
        //create auth log
        $this->_create_auth_log('User redirected from facebook to auth/fb_login');
        
        //check if any fb user is loggedin
        $userfb = $this->facebook->getUser();
        if ($userfb){
            //create auth log
            $this->_create_auth_log('No problem in returning, get facebook user profile');
            
            //check if any error
            $this->fb_get_data($userfb);
        }else{
            //create auth log
            $this->_create_auth_log('Problem in returning. Try to redirect again to facebook');
            $fb_login_url = $this->session->userdata('facebook_login_url');
            echo '<script> top.location.href=\''.$fb_login_url.'\'</script>';
        }
    }
    
    function fb_get_data($userid){
        //create auth log
        $this->_create_auth_log('User is logged in Facebook. Trying to get facebook user profile in auth/fb_get_data');
            
        //we have user loggedin but not sure if token is valid so we try
        try{
            // Proceed knowing you have a logged in user who's authenticated.
            $user_profile = $this->facebook->api('/me');
        }  catch (FacebookApiException $e){
            $user_profile = NULL;
            
            //create auth log
            $this->_create_auth_log('Problem in getting facebook profile. Do not know what to do');
            exit('Problems with facebook login. Please refresh yout application');
        }
        
        if ($user_profile){
            //create log
            $this->_create_auth_log('Successfully login and get facebook user profile', TRUE);
        }
        //next check if this FB user registered in UZone database
        $check_user_info = new stdClass();
        $check_user_info->id = $user_profile['id'];
        $check_user_info->name = $user_profile['name'];
        $check_user_info->email = isset($user_profile['email'])?$user_profile['email']:'';
        $check_user_info->username = $user_profile['username'];

        //try get user avatar   
        
        $fb_avatar = @file_get_contents('https://graph.facebook.com/'.$check_user_info->id.'/picture?width=30&height=30&redirect=false');
        if ($fb_avatar){
            $fb_avatar_json = json_decode($fb_avatar);
            $check_user_info->avatar = $fb_avatar_json->data->url;
            $this->session->set_userdata('client_avatar', $check_user_info->avatar);
            
            //create log
            $this->_create_auth_log('Successfully get facebook avatar', TRUE);
            
        }else{
            $check_user_info->avatar = '';
        }
        //test token doang
        $fb_token = '000023233';
        return $this->check_save_clientuser($check_user_info, $fb_token, 'facebook');
    }
    
    /**
     * Login By Twitter
     */
    public function tw_login_init($retUrl=NULL){
        //Save the return url into session
        if (!$retUrl) $retUrl = 'home';
        $this->session->set_userdata('sosmed_login_ret_url', $retUrl);
        //create log
        $this->_create_auth_log('User trying login using twitter', TRUE);
        //redirect to twitter login function
        redirect('auth/tw_login');
    }
    
    public function tw_login(){
        $tw_options = array(
            'consumer_key'      => config_item('tw_cs_key'),
            'consumer_secret'   => config_item('tw_cs_secret')
        );
        /* Start session and load library. */
        $this->load->library('twitter/Twitteroauth', $tw_options);
        $connection = $this->twitteroauth;
        
        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken(site_url('auth/tw_login_validate'));
		
		//create log
        $this->_create_auth_log('Get temporary credential twitter', TRUE);
		
        //exit(var_dump($request_token));
        /* Save temporary credentials to session. */
        $token = $request_token['oauth_token'];
		
		//create log
        $this->_create_auth_log('Save twitter credential', TRUE);
        
        foreach($request_token as $token_key=>$token_val){
            $this->session->set_userdata($token_key, $token_val);
        }
        
        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) {
            case 200:
                /* Build authorize URL and redirect user to Twitter. */
                $url = $connection->getAuthorizeURL($token);
				//create log
				$this->_create_auth_log('Build authorize URL and redirect to twitter', TRUE);
                redirect ($url);
                break;
            default:
				//create log
				$this->_create_auth_log('Something went wrong, redirecting to auth/index', TRUE);
                /* Show notification if something went wrong. */
                $this->session->set_flashdata('error', 'Could not connect to Twitter. Refresh the page or try again later.');
                redirect('auth/index');
        }
    }
    
    public function tw_login_validate(){
        /*
         * Now user come back from twitter login page to our website
         */
        
        //Check if Auth Token exist, if not, redirect to sign in page
        $oauth_token = $this->session->userdata('oauth_token');
        $oauth_token_secret = $this->session->userdata('oauth_token_secret');
        
		//create log
        $this->_create_auth_log('Check if twitter auth token exists', TRUE);
		
        //If no value redirect to twitter login page
        if (!$oauth_token || !$oauth_token_secret){
			//create log
			$this->_create_auth_log('Twitter auth token not exists, redirect to auth/tw_login', TRUE);
            redirect('auth/tw_login');
        }
		
		//create log
        $this->_create_auth_log('Create Twitter OAuth object', TRUE);
        /* Create OAuth Object From Temporary token. */
        $this->load->library('twitter/Twitteroauth.php', array(
            'consumer_key'          => config_item('tw_cs_key'),
            'consumer_secret'       => config_item('tw_cs_secret'),
            'oauth_token'           => $oauth_token,
            'oauth_token_secret'    => $oauth_token_secret
        ));
        $connection = $this->twitteroauth;
        
        if ($this->input->get_post('oauth_verifier'))
        {
            /*
             * Now we ask Twitter for long lasting token credentials. 
             * These are specific to the application and user and will act like password to make future requests. 
             * Normally the token credentials would get saved in your database but for this example we are just using sessions
             */
            $token_credentials = $connection->getAccessToken($this->input->get_post('oauth_verifier'));

            /*
             * With the token credentials we build a new TwitterOAuth object.
             */

            $this->load->library('twitter/Twitteroauth.php', array(
                'consumer_key'          => config_item('tw_cs_key'),
                'consumer_secret'       => config_item('tw_cs_secret'),
                'oauth_token'           => $token_credentials['oauth_token'],
                'oauth_token_secret'    => $token_credentials['oauth_token_secret']
            ));
            $connection = $this->twitteroauth;
            
            /*
             * And finally we can make requests authenticated as the user
             */
            
            /* Get logged in user to get info. */
            $userinfo = $connection->get('account/verify_credentials');
			
			//create log
			$this->_create_auth_log('User is loggedin using twitter', TRUE);
        }else{
			//create log
			$this->_create_auth_log('Something went wrong, redirect to auth/tw_login', TRUE);
            redirect('auth/tw_login');
        }
        
        //exit(var_dump($userinfo));
        //next check if this twitter user registered in UZone database
        $check_user_info = new stdClass();
        $check_user_info->id = $userinfo->id;
        $check_user_info->name = $userinfo->name;
        $check_user_info->email = NULL;
        $check_user_info->avatar = $userinfo->profile_image_url;
        $check_user_info->username = $userinfo->screen_name;
        //set user avatar
        $this->session->set_userdata('client_avatar', $userinfo->profile_image_url);
        
        $this->check_save_clientuser($check_user_info, $oauth_token, 'twitter');
    }
        
    /**
     * Helper function to check clientuser exists, if not create it
     * @param stdClass $userinfo id, name, email
     * @param string $token 
     * @param string $client_app
     */
    protected function check_save_clientuser($userinfo, $token, $client_app='facebook'){
        //Load model for userclient, and get type for user FB
        $this->load->model('userclient_m');
        $client_id = $userinfo->id;
        $client_name= $userinfo->name;
        $client_email = $userinfo->email?$userinfo->email:'';
        $client_username = (isset($userinfo->username)?$userinfo->username:$client_app.'_'.$client_id);
        
        if ($client_id){
            $userid_db = NULL;
            //If no clientuser in database, means the first time user login using this FB account, so create it one
            if ($this->userclient_m->get_count(array('client_userid'=>$client_id, 'client_app'=>$client_app))==0)
            {
                //create new user with automatically is Active
                $new_pwd = $this->user_m->hash($client_app);
                $new_user = $this->user_m->create_ext_user(array('u_name'=>$client_username,'u_password'=>$new_pwd,'name'=>$client_name, 'email'=>$client_email ,'is_activeYN'=>'y'));
                
                $userid_db = $new_user->id;

                //create new in userclient
                $this->userclient_m->save(array('userid'=>$userid_db,'client_userid'=>$client_id,'client_app'=>$client_app, 'token'=>$token));
                
            }else{
                //if exist, we will update with new token only
                //use table name to build query instead of using parent function prototype
                $userclient_tbl = $this->userclient_m->get_tablename();
                $this->db->set(array('token'=>$token))->where(array('client_userid'=>$client_id, 'client_app'=>$client_app))->update($userclient_tbl);
                
            }
            //Now, create session meant a user has successfully loggedin in to system
            //try to use existing userid if any
            if (!$userid_db){
                $userid_db = $this->userclient_m->get_select_where('userid',array('client_userid'=>$client_id, 'client_app'=>$client_app),TRUE)->userid;
            }
            //create actual session
            $user_row = $this->user_m->get($userid_db, TRUE);
            //create normal login session
            $this->user_m->create_session($user_row);
            
            //add additional information into session
            $session_data = array(
                'token'=>  base64_encode($token), 
                'clientid'=>base64_encode($client_id), 
                'clientapp' => base64_encode($client_app)
            );
            $this->session->set_userdata($session_data);
            
            //ask for update profile if email not exists
            if (!$this->session->userdata('email')){
                redirect('auth/profile_update');
            }else{
            
                /**************************** SSO USEETV *****************************************************************************/
                //Update sso if email exists
            
                $sso_result = $this->_sso_register($this->session->userdata('email'), $client_id, $client_username, $client_name, $client_app);
                if ($sso_result){
                    
                    if ($sso_result->token){
                        //save useetv token into session
                        $this->session->set_userdata('useetv_token', $sso_result->token);
                        
                        //send token for autologin useetv
                        $this->_useetv_sendtoken($sso_result->token);
                    }
                    //save new registered sso into our database
                    $this->_save_new_sso($userid_db, $client_name, $client_email, $client_id, $client_username, $client_app, $sso_result->token , 'useetv');
                }
            }
                /**************************************** END F SSO USEETV ****************************************************/
            
            $last_page_in_session = $this->session->userdata('sosmed_login_ret_url');
            if ($last_page_in_session) 
                $last_page_in_session = str_replace('-', '/', $last_page_in_session);
            else
                $last_page_in_session = 'home';
            
            redirect($last_page_in_session);
        }else{
            $this->session->set_flashdata('error','Login via '.$client_app.' failed!');
            redirect('auth/index');
        }
    }
    
    public function profile_update(){
        if (!$this->user_m->is_loggedin())
            redirect('auth');
        
        $userid = $this->session->userdata('userid');
        $usertype = $this->session->userdata('type');
        
        $rules = array(
            'name'  =>   array(
                'field' =>  'name',
                'label' =>  'Name',
                'rules' =>  'trim|required|xss_clean'
            ),
            'email'  =>   array(
                'field' =>  'email',
                'label' =>  'Email',
                'rules' =>  'trim|required|valid_email|xss_clean'
            )
        );
        
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            if ($usertype!=0){
                $post_data = $this->user_m->array_from_post(array('name','email'));
            }else{
                $post_data = $this->user_m->array_from_post(array('name','email'));
            }
            
            if ($this->user_m->save($post_data, $userid)){
                $this->session->set_userdata('email', $post_data['email']);
                redirect('home');
            }else{
                $this->session->set_flashdata('error', 'Profile gagal diupdate');
            }
        }
        
        $this->data['user'] = $this->user_m->get($userid);
        
        //var_dump($this->data['user']);exit;
        //set active menu
        $this->data['active_menu'] = 'login';        
        
        $this->data['subview'] = 'login/update_profile';
        $this->load->view('_layout_main', $this->data);
    }
    
    protected function _sso_register($email,$app_uid,$app_username,$fullname,$app_name='facebook'){
        
        $result = $this->_register_apiuseetv($email, $app_uid, $app_username, $fullname, $app_name);
        //exit(var_dump($result));
                
        if (isset($result->result)&&$result->result==FALSE){
            $message = $result->msg;
            //return FALSE;
        }else{
            if (isset($result->resultCode)){
                $message = $result->resultMessage;
                //create new record in our sso table
                return $result;
            }
        }
        
        return FALSE;
    }
    
    protected function _register_apiuseetv($email,$app_uid,$app_username,$fullname,$app_name='facebook'){
        $fields = array(
            'email'     =>  $email,
            'uid'       =>  $app_uid,
            'source'    =>  $app_name,
            'username'  =>  $app_username,
            'name'      =>  urlencode($fullname)
        );
        //initiate curl
        $api_url = 'http://www.useetv.com/services/uzregisterapi?';
        
        $curl = curl_init();
        
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_URL, $api_url . http_build_query($fields));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        
        curl_close($curl);
        
        //insert into sso log
        $this->load->model('sso_log_m');
        $this->sso_log_m->save(array(
            'sso_request_param' =>  $api_url. http_build_query($fields),
            'sso_target'        =>  'useetv',
            'sso_result'        =>  $result
        ));
        
        return json_decode($result);
    }
    
    protected function _save_new_sso($userid,$fullname,$email,$clientapp_id,$clientapp_username,$clientapp_name, $sso_token, $sso_target='useetv'){
        //Load model 
        $this->load->model('sso_client_m');
        
        $return_val = new stdClass();
        $return_val->result = FALSE;
        
        $data_post = array(
            'userid'                =>  $userid,
            'fullname'              =>  $fullname,
            'email'                 =>  $email,
            'clientapp_id'          =>  $clientapp_id,
            'clientapp_username'    =>  $clientapp_username,
            'clientapp_name'        =>  $clientapp_name,
            'sso_target'            =>  $sso_target,
            'sso_token'             =>  $sso_token
        );
        
        //check weather exists
        $sso_client_registered = $this->sso_client_m->get_by(array('userid' => $userid, 'sso_target'=>$sso_target), TRUE);
        if ($sso_client_registered){
            $this->sso_client_m->save($data_post, $sso_client_registered->id);
            $return_val->message = 'User SSO sudah terdaftar di database';
            
            return $return_val;
        }else{
            $data_post['sso_datetime'] = date('Y-m-d H:i:s');
            
            if ($this->sso_client_m->save($data_post)){
                $return_val->result = TRUE;
                $return_val->message = 'User SSO berhasil disimpan ke database';
            }else{
                $return_val->message = 'User SSO gagal disimpan ke database';
            }
        }
        
        return $return_val;
        
    }
    
    protected function _useetv_sendtoken($token){
        $url = 'http://www.useetv.com/settoken?token='.$token;
        
        $this->session->set_userdata('useetv_settoken', 1);
        $this->session->set_userdata('useetv_tokenurl', $url);
        /*
        $result = file_get_contents($url);
        //insert into sso log
        $this->load->model('sso_log_m');
        $this->sso_log_m->save(array(
            'sso_request_param' =>  $url,
            'sso_target'        =>  'useetv',
            'sso_result'        =>  $result
        ));*/
    }
}




/*
 * file location: /application/controllers/auth.php
 */