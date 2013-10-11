<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of U_Controller
 *
 * @author master
 */
class U_Controller extends MY_Controller {
    
    protected $_channel_name = '';
    protected $AM = NULL;
            
    function __construct() {
        parent::__construct();
		
        /****************** Added by Esgi  / edited by Marwan****************************/
        $this->_clean_header();
        //$this->data['meta_title'] = 'UZone';
        /************************* End by Esgi *****************************************/
        
        //load channel model because will be use widely
        $this->load->model('channel_m');
        
        //nee to check wheather user is loggedin or not
        $this->load->model('user_m');
        $this->data['is_loggedin'] = $this->user_m->is_loggedin();
        
        //Load api model
        $this->load->model('api_m');
        $this->AM = $this->api_m;
        
        //load channels list      
        $channels = $this->channel_m->get_by(array('showed'=>1));
        
        //store channel into global data
        $this->data['channels'] = $channels;
        
        //set active channel
        $this->data['active_menu'] = $this->_channel_name;
        
        //load general uzone language file
        $this->lang->load('uzone');
        
        //load helper
        $this->load->helper('uzone');
                
        $this->data['IS_DESKTOP'] = $this->is_device('DESKTOP');
        $this->data['IS_MOBILE'] = $this->is_device('MOBILE');
        $this->data['IS_IPAD'] = $this->is_device('IPAD');
        $this->data['IS_ANDROID'] = $this->is_device('ANDROID');
    }
	
	protected function _clean_header(){
        $not_allowed_chars = '/[\'^£$%&*()}{@#~?><>,|=+¬]/';
        if (preg_match($not_allowed_chars, current_url()))
        {
            //redirect('error/notfound404');
            set_status_header(404);
	}
        
        if($this->uri->segment(2)=='notfound404'){
            $this->data['meta_title'] = 'File Not Found';
	}else{
            $this->data['meta_title'] = 'UZone';
        }
    }
}
