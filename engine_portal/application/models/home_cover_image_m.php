<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Home_cover_image_m
 *
 * @author master
 */
class Home_cover_image_m extends MY_Model {
    
    protected $_table_name = 'home_cover_images';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'sort';
    
    public $rules = array(
        'file_name' => array(
            'field' => 'file_name', 
            'label' => 'file_name', 
            'rules' => 'trim|required|xss_clean'
        ),
        'file_ext' => array(
            'field' => 'file_ext', 
            'label' => 'file_ext', 
            'rules' => 'trim|required|xss_clean'
        ),
        'image_width' => array(
            'field' => 'image_width', 
            'label' => 'image_width', 
            'rules' => 'trim|required|xss_clean'
        ),
        'image_height' => array(
            'field' => 'image_height', 
            'label' => 'image_height', 
            'rules' => 'trim|required|xss_clean'
        ),
        'link_url' => array(
            'field' => 'link_url', 
            'label' => 'link_url', 
            'rules' => 'trim|xss_clean'
        ),
        'sort' => array(
            'field' => 'sort', 
            'label' => 'sort', 
            'rules' => 'trim|numeric|xss_clean'
        )
    );
    //public $rules = array();
    
    function __construct() {
        parent::__construct();
    }
    
}

/*
 * file location: /application/models/home_cover_image_m.php
 */
