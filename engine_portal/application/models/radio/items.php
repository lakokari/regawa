<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Items extends MY_Model {
    protected $_table_name = 'radio_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'display_order';
    
    public $rules = array(
		'radio_name' => array(
			'field' => 'radio_name', 
			'label' => 'Radio Name', 
			'rules' => 'trim|required|xss_clean'
		),
		'radio_site' => array(
			'field' => 'radio_site', 
			'label' => 'Radio Site', 
			'rules' => 'trim|required|xss_clean'
		),
		'radio_city' => array(
			'field' => 'radio_city', 
			'label' => 'Radio City', 
			'rules' => 'trim|required|xss_clean'
		),
		'live_stream' => array(
			'field' => 'live_stream', 
			'label' => 'Live Stream', 
			'rules' => 'trim|required|xss_clean'
		)
    );

    function __construct() {
        parent::__construct();
    }     
}

?>
