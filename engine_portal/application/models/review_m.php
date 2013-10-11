<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Item_m
 *
 * @author master
 */
class Review_m extends MY_Model {
    
    protected $_table_name = 'channel_review';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'channel_name, review_datetime DESC';
    
    public $rules_send_review = array(
        'review_text' => array(
            'field' => 'review_text', 
            'label' => 'Review Text', 
            'rules' => 'trim|required|xss_clean'
        )
    );
    //public $rules = array();
    
    function __construct() {
        parent::__construct();
    }
    
    //public function save($data, $id = NULL) {
    //    parent::save($data, $id);
    //}
    
}

/*
 * file location: /application/models/user_m.php
 */
