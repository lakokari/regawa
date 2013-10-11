<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of home_random_image_m
 *
 * @author master
 */
class Home_random_image_m extends MY_Model {
    
    protected $_table_name = 'random_home_channels_image';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'channel_id, inserted_time DESC';
    
    function __construct() {
        parent::__construct();
    }
    
}

