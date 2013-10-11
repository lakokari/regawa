<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Tv_most_popular extends MY_Model {
    protected $_table_name = 'uz_tv_most_popular';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'inserted_time desc, id desc';
    
    function __construct() {
        parent::__construct();
    }
	
    
}
