<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author master
 */
class MY_Controller extends CI_Controller {
    
    public $data = array();
    public $error = array();
    
    public $channels = array();
    
    public $query_string = array();
    
    protected $email_config = array(
        'useragent'     =>  'UZone',
        'protocol'      =>  'sendmail',
        'mailpath'      =>  '/usr/sbin/sendmail',
        'charset'       =>  'iso-8859-1',
        'wordwrap'      =>  TRUE,
        'newline'       =>  '\r\n',
        'crlf'          =>  '\r\n'
    );
        
    protected $_temp_folder = '_temp/';
    
    function __construct() {
        parent::__construct();
        
        //set static session id
        $this->setStaticSessionId();
        
        //excute channel list function
        $this->getChannels();
        
        //$this->create_audit_trail();
        //register_shutdown_function()
        
        /*
         * Karena selalu load dari API, performance akan turun
         * Maka, data yang selalu load dari api, akan disimpan ke temporary static file
         * untuk setiap harinya
         * Flow nya, sistem, check, apakah ada temp file tanggal hari ini,
         * jika tidak ada, load dari api, save ke temp file
         * Load temp file
         * 
         * Function check will be call in each controllers as needed
         */
        $this->_temp_folder = SITE_PATH . $this->_temp_folder;
    }
    
    function __destruct() {
        //$this->create_audit_trail();
    }
    
    protected function _check_temp_folder_exist(){
        if (!file_exists($this->_temp_folder)){
            mkdir($this->_temp_folder,0775);
            
            //create empty html
            $data = '<html><head><title>No Listing</title></head><body><h1>No Listing</h1></body></html>';
            file_put_contents($this->_temp_folder .'index.html', $data);
        }
    }
    
    /**
     * * These shouldn't be accessible from outside the controller
    **/
    protected function create_audit_trail($action_type='get',$action_status='success',$action_result='unknown?'){
        $table_audit = 'audit_trail';
        
        //Get all variables from all request
        $channel_name = 'unknown';
        if (isset($this->channel_name)){
            $channel_name = $this->channel_name;
        }elseif(isset($this->_channel_name)){
            $channel_name = $this->_channel_name;
        }
        $user_agent = $this->input->server('HTTP_USER_AGENT');
        $uri = site_url().$this->uri->uri_string();
        $user = $this->session->userdata('username')?$this->session->userdata('username'):'visitor';
        $ip_address = $this->_get_ip();
        $controller = get_called_class()?get_called_class():'_unknown_class';
        
        //try to get method filtering from all the function in class, by uri call
        $method = 'unknown';
        $all_methods_class = get_class_methods($this);
        foreach(explode('/', $this->uri->uri_string()) as $method_called){
            if (in_array($method_called, $all_methods_class)){
                $method = $method_called;
                break;
            }
        }
        
        //if method is 'unknown' probably called by ajax (presume)
        if ($method=='unknown'&&isset($_POST['func'])){
            $method = $_POST['func'];
        }elseif(method_exists($this, 'index')){
            $method = 'index';
        }
        
        $param_get = str_replace('/', ',', $this->uri->uri_string());
        $all_posts = $_POST;
        if (isset($all_posts['client_password'])){
            unset($all_posts['client_password']);
        }
        if (is_array($all_posts))
            $param_post = implode(',', $all_posts);
        else
            $param_post = $all_posts;
        $server_method= strtolower($this->input->server('REQUEST_METHOD'));
        
        $action_time = date('Y-m-d H:i:s');
        
        $data_to_post = array(
            'channel_name'  =>  $channel_name,
            'url'           =>  $uri,
            'user_agent'    =>  $user_agent,
            'user'          =>  $user,
            'ip_address'    =>  $ip_address,
            'controller'    =>  $controller,
            'method'        =>  $method,
            'param_get'     =>  $param_get,
            'param_post'    =>  $param_post,
            'server_method' =>  $server_method,
            'action_type'   =>  $action_type,
            'action_status' =>  $action_status,
            'action_result' =>  $action_result,
            'action_time'   =>  $action_time
        );
        
        $this->db->set($data_to_post)->insert($table_audit);
    }
    
    protected function _get_ip(){
        if($this->input->server('HTTP_X_FORWARDED_FOR') )
	{
		$ip = $this->input->server('HTTP_X_FORWARDED_FOR');
	} else {
		$ip = $this->input->server('REMOTE_ADDR');
	}
	return htmlspecialchars($ip);
    }
    
    protected function getQueryStringParams() {
        parse_str($_SERVER['QUERY_STRING'], $this->query_strings);
    }
    
    protected function getQueryStringValue($parameter, $default_value=NULL){
        if (isset($this->query_string[$parameter])){
            return $this->query_string[$parameter];
        }
        
        return $default_value;
    }
    
    protected function addSongIntoPlayListSession($songId){
        $playlist = $this->session->userdata('playlist');
        if (!isset($playlist['id'])||!in_array($songId, $playlist['id'])){
            $playlist['id'][] = $songId;
            $playlist['songInfo'][] = $this->getSongInfoFromId($songId);
        }
        
        $this->session->set_userdata(array('playlist'=>$playlist));
    }
    
    protected function getSongPlayListSession(){
        return $this->session->userdata('playlist');
    }
    
    protected function getSongInfoFromId($songId){
        $new_song_playlist = array('songId'=>$songId);
        
        $this->load->model('music/song');
        $song = $this->song->get_select_where('songName,albumId,artistId',array('songId'=>$songId), TRUE);
        $new_song_playlist['songName'] = $song->songName;
        $new_song_playlist['albumId'] = $song->albumId;
        $new_song_playlist['artistId'] = $song->artistId;
                
        //load album
        $this->load->model('music/album');
        $album = $this->album->get_select_where('albumName', array('albumId'=>$song->albumId), TRUE);        
        $new_song_playlist['albumName'] = $album->albumName;
        
        //load artist name
        $this->load->model('music/artist');
        $artist = $this->artist->get_select_where('artistName', array('artistId'=>$song->artistId), TRUE);
        $new_song_playlist['artistName'] = $artist->artistName;
        
        return $new_song_playlist;
    }
    
    protected function simpleMail($email_data){
        $this->load->library('email');
        $this->email->initialize($this->email_config);
        
        $this->email->from($email_data['from_email'], $email_data['from_name']);
        $this->email->to($email_data['to_email']); 
        if (isset($email_data['cc'])){
            $ccs = explode(',', $email_data['cc']);
            foreach($ccs as $cc){
                $this->email->cc($cc); 
            }
        }
        if (isset($email_data['bcc'])){
            $bccs = explode(',', $email_data['bcc']);
            foreach($bccs as $bcc){
                $this->email->bcc($bcc); 
            }
        }
        
        
        $this->email->subject($email_data['subject']);
        $this->email->message($email_data['message']);	

        return $this->email->send();
    }
    
    public function getChannels(){
        $this->load->model('channel_m');
        $channels = $this->channel_m->get();
        foreach($channels as $item){
            $this->channels [$item->name] = $item->id;
        }
    }
    
    public function getChannelId($channel_name){
        if (isset($this->channels[$channel_name])){
            return $this->channels[$channel_name];
        }
        else
            return FALSE;
    }
    
    /** 
     * Create New User Validation
     * @return boolean
     */
    public function unique_user_name(){
        //do not validate if exist
        //Unless it is the current record
        $id = $this->uri->segment(4);
        
        $this->db->where('u_name', $this->input->post('u_name'));
        !$id || $this->db->where('id !=', $id);
        
        $found = $this->user_m->get();
        if (count($found)){
            $this->form_validation->set_message('unique_user_name','%s already exists!');
            
            return FALSE;
        }
        
        return TRUE;
    }
    
    protected function setStaticSessionId(){
        if (!$this->session->userdata('MY_SESSIONID')){
            $this->session->set_userdata('MY_SESSIONID', md5($this->session->userdata('session_id').time()));
        }
    }
    
    public function getStaticSessionId(){
        return $this->session->userdata('MY_SESSIONID');
    }
    
    protected function is_device($deviceToCheck='DESKTOP'){
        $IE = stripos($_SERVER['HTTP_USER_AGENT'],"MSIE");
        $iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $iMac = stripos($_SERVER['HTTP_USER_AGENT'],"Macintosh");
        
        if(stripos($_SERVER['HTTP_USER_AGENT'],"Android") && stripos($_SERVER['HTTP_USER_AGENT'],"mobile")){
                $Android = true;
        }else if(stripos($_SERVER['HTTP_USER_AGENT'],"Android")){
                $Android = false;
                $AndroidTablet = true;
        }else{
                $Android = false;
                $AndroidTablet = false;
        }
        
        $symbianOS = stripos($_SERVER['HTTP_USER_AGENT'],"symbianOS");
        //$webOS = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $BlackBerry = stripos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
        $RimTablet= stripos($_SERVER['HTTP_USER_AGENT'],"RIM Tablet");
        $winP= stripos($_SERVER['HTTP_USER_AGENT'],"Windows Phone");
        $winM= stripos($_SERVER['HTTP_USER_AGENT'],"Windows Mobile");
        $win= stripos($_SERVER['HTTP_USER_AGENT'],"Windows");

        
        switch($deviceToCheck){
            case 'IE': return $IE; break;
            case 'IPOD': return $iPod; break;
            case 'IPHONE': return $iPhone; break;
            case 'IPAD': return $iPad; break;
            case 'IMAC': return $iMac; break;
            case 'ANDROID': return ( $Android || $AndroidTablet ? true : false); break;
            case 'ANDROIDPHONE': return $Android; break;
            case 'ANDROIDTAB': return $AndroidTablet; break;
            case 'WINMO': return ( $winP || $winM ? true : false); break;
            case 'WIN': return $win; break;
            case 'SYMBIAN': return $symbianOS; break;
            case 'BLACKBERRY': return $BlackBerry; break;
            case 'RIMTABLET': return $RimTablet; break;
            case 'MOBILE': return ( $iPad || $iPod || $iPhone || $Android || $symbianOS  || $BlackBerry || $winP || $winM ? true : false); break;
            case 'TABLET': return ( $AndroidTablet || $RimTablet ? true : false); break;
            case 'DESKTOP': return ( ($iMac || $win) ? true : false); break;
        }
        
        return FALSE;
    }
}

?>
