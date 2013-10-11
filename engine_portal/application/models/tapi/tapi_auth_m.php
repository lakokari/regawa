<?php

/**
 * Description of t_auth_m
 *
 * @author master
 */
class Tapi_auth_m  extends CI_Model{
    
    protected $_table_name = 'api_users';
    
    
    function __construct() {
        parent::__construct();
    }
    
    function authenticate($client_appid, $client_password){
    	$this->db->select('id,client_appid,client_name');
        $this->db->where(array(
            'client_appid'   =>  $client_appid,
            'client_password'   => $client_password
        ));
        
        $t_user = $this->db->get($this->_table_name)->row();
        if ($t_user)
            return $t_user;
        else
            return NULL;
    }
}

?>