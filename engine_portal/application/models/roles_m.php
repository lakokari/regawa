<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of user_m
 *
 * @author master
 */
class Roles_m extends MY_Model {
    protected $_table_name = 'roles';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'category';
    
    public $rules = array(
        'id' => array(
            'field' => 'id', 
            'label' => 'Id', 
            'rules' => 'xss_clean'
        ), 
        'category' => array(
            'field' => 'category', 
            'label' => 'Category', 
            'rules' => 'trim|required'
        ),
        'role' => array(
            'field' => 'role', 
            'label' => 'Role Name', 
            'rules' => 'trim|required'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
}

/*
 * file location: /application/models/user_m.php
 */
