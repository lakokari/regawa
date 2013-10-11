<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Stations extends MY_Model {
    protected $_table_name = 'tv_stations';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    function __construct() {
        parent::__construct();
    }
	public $rules = array(
			'tv_name' => array(
				'field' => 'tv_name', 
				'label' => 'tv_name', 
				'rules' => 'trim|required|xss_clean'
			), 
			'tv_code' => array(
				'field' => 'tv_code', 
				'label' => 'tv_code', 
				'rules' => 'trim|required|xss_clean'
			), 
			'tv_description' => array(
				'field' => 'tv_description', 
				'label' => 'tv_description', 
				'rules' => 'trim|xss_clean'
			), 
		);
	}

?>
