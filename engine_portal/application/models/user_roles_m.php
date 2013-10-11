<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of user_m
 *
 * @author master
 */
class User_roles_m extends MY_Model {
    protected $_table_name = 'user_roles';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'group_id';
    
    public $rules = array(
        'id' => array(
            'field' => 'id', 
            'label' => 'Id', 
            'rules' => 'xss_clean'
        ), 
        'role' => array(
            'field' => 'role', 
            'label' => 'Role', 
            'rules' => 'numeric|required'
        ),
        'group_id' => array(
            'field' => 'group_id', 
            'label' => 'Group Id', 
            'rules' => 'numeric|required'
        ),
        'enabled' => array(
            'field' => 'enabled', 
            'label' => 'Is Enable', 
            'rules' => 'numeric|required'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
}

/*
 * file location: /application/models/user_roles_m.php
 */
