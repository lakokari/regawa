<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ajax
 *
 * @author master
 */
class Ajax extends MY_Controller {
    protected $_result = array();
    protected $_output = 'json';
    protected $_automatic_output = TRUE;
    protected $AM = NULL;
            
    function __construct() {
        parent::__construct();
        
        //load model api
        $this->load->model('api_m');
        $this->AM = $this->api_m;
    }
    
    public function index(){
        $function = $this->input->post('func');

        if (method_exists($this, $function)){
            //execute exsisting function
            $this->$function();
            
        }else{
            $this->_result['message'] = 'No function defined';
        }
        
        //response output to caller
        if ($this->_automatic_output)
            $this->output();
    }
    
    public function output(){
        switch($this->_output){
            case 'html': echo $this->_result; break;
            case 'json':
            default:    echo json_encode($this->_result);
        }
    }
}

/*
 * file location: /engine/application/libraries/Ajax.php
 */
?>
