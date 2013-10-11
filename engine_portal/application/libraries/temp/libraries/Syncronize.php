<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Syncronize
 *
 * @author master
 */
class Syncronize {
    protected $CI = NULL;
    protected $API_M = NULL;
    
    function __construct() {
        $this->CI = & get_instance();
        
        //load api_m module as always be used
        $this->CI->load->model('api_m');
        $this->API_M = $this->CI->api_m;
    }
    
}

?>
