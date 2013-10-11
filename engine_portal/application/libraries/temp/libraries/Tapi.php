<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tapi
 *
 * @author master
 */
class Tapi extends MY_Controller {
        
    public $return = array();
    
    protected $_req_auth        = TRUE;
    protected $_log_requests    = TRUE;
    
    protected $_allowed_methods = 'post,get';
    protected $_request_method;
    
    protected $_client_appid     = 'guest';
    
    protected $_format = 'json';


    /** RETURN CODE **/
    protected $ERR_CODE = array(
        'E0000'     =>  'Success, no error',
        'E0010'     =>  'Need Authentication',
        'E0011'     =>  'Authentication failed',
        'E0020'     =>  'Request method is not allowed',
        'E0021'     =>  'Wrong request method',
        'E0030'     =>  'Return format is not allowed',
        'E0040'     =>  'Other Error'
    );
    
            
    function __construct($log_enabled=TRUE) {
        parent::__construct();
        //Load default model
        $this->load->model('tapi/tapi_auth_m');
        $this->load->model('tapi/tapi_log_m');
        
        //get client method used to access this resource
        $this->_request_method = strtolower($this->input->server('REQUEST_METHOD'));
        
        //Only allowed request in specific methods
        if (!in_array($this->_request_method, explode(',',  $this->_allowed_methods))){
            return $this->send_error(array(
                'status'                =>  'Failed',
                'retCode'               =>  'E0020'
            ));
        }
        
        //Is it required to authenticate request ?
        if ($this->_req_auth){
            if (!$this->_check_auth()){
                return $this->send_error(array(
                    'status'                =>  'Failed',
                    'retCode'               =>  'E0011'
                )); 
            }
        }
        
        //set wheater to log every request
        
        $this->_log_requests = $log_enabled;
        if ($this->_log_requests)
            $this->create_log();
        
        //If no problems, script will continue the execution
    }
    
    protected function send_error($err){
        $this->return['status'] = !isset($err['status'])? 'Failed':$err['status'];;
        $this->return['retCode'] = $err['retCode'];
        $this->return['retCodeMessage'] = !isset($err['retCodeMessage'])? $this->ERR_CODE[$err['retCode']]:$err['retCodeMessage'];
        
        //send ouput to user
        return($this->_send_output());
    }
    
    protected function _check_auth(){
        $client_appid = $this->input->post('client_appid', TRUE);
        $client_password = $this->input->post('client_password');
            
        //store client appid to shared class variable
        $this->_client_appid = $client_appid;
            
        if (!$client_appid && !$client_password){
            return $this->send_error(array(
                'status'                =>  'Failed',
                'retCode'               =>  'E0010'
            )); 
        }elseif(!$client_appid || !$client_password){
            return $this->send_error(array(
                'status'                =>  'Failed',
                'retCode'               =>  'E0011'
            )); 
        }
            
        //check database ?
        return $this->tapi_auth_m->authenticate($client_appid, $client_password);
    }
       
    protected function _send_output(){
        $this->_output_json();
        exit;
    }
    
    protected function _output_json($set_header=TRUE){
        //set header
        if ($set_header) header('Content-Type: application/json');
        
        //send data output
        $this->return['format'] = 'json';
        echo json_encode($this->return);
    }
    
    protected function get_ip(){
        if($this->input->server('HTTP_X_FORWARDED_FOR') )
	{
		$ip = $this->input->server('HTTP_X_FORWARDED_FOR');
	} else {
		$ip = $this->input->server('REMOTE_ADDR');
	}
	return htmlspecialchars($ip);
    }
    
    protected function create_log(){
    	$appid = $this->_client_appid;
    	if (!$appid) $appid = 'unknown';
    	
    	$meta = array();
    	$query = $this->input->server('QUERY_STRING') ? '?'.$this->input->server('QUERY_STRING') : '';
	$meta['uri'] = site_url().$this->uri->uri_string(). $query;
	$meta['agent'] = $this->input->server('HTTP_USER_AGENT');
    	
    	$data = array(
    	    'req_date'		=> date('Y-m-d H:i:s'),
    	    'client_appid'	=> $appid,
    	    'client_ip'		=> $this->get_ip(),
    	    'meta'		=> json_encode($meta)
    	);
    	
    	$this->tapi_log_m->log_request($data);
    }
    
}

/* End of file Tapi.php */
/* Location: ./application/Libraries/Tapi.php */