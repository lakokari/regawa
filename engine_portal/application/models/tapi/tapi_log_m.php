<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of t_log_m
 *
 * @author master
 */
class Tapi_log_m extends CI_Model {
    
    protected $_tablename = 'api_requests';
    
    function __construct() {
        parent::__construct();
    }
    
    function log_request($data){
        $this->db->insert($this->_tablename, $data);
    }
    
}