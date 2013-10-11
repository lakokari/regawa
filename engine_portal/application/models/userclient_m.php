<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of user_m
 *
 * @author master
 */
class Userclient_m extends MY_Model {
    protected $_table_name = 'userclient_map';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'client_app';
    
    public $clientapp_fb = 'facebook';
    public $clientapp_twitter = 'twitter';
    
    public $rules = array(
        'id' => array(
            'field' => 'id', 
            'label' => 'Id', 
            'rules' => 'xss_clean'
        ), 
        'userid' => array(
            'field' => 'userid', 
            'label' => 'UserId', 
            'rules' => 'numeric|required'
        ),
        'client_userid' => array(
            'field' => 'client_userid', 
            'label' => 'Client Id', 
            'rules' => 'required|xss_clean'
        ),
        'client_app' => array(
            'field' => 'client_app', 
            'label' => 'Client App', 
            'rules' => 'required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
    
}

/*
 * file location: /application/models/user_client_m.php
 */
