<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Items extends MY_Model {
    protected $_table_name = 'game_items';
    protected $_primary_key = 'autoId';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'inserted_time DESC';
    
    public $rules = array(
		'title' => array(
			'field' => 'title', 
			'label' => 'Game Name', 
			'rules' => 'trim|required|xss_clean'
		),
		'description' => array(
			'field' => 'description', 
			'label' => 'Description', 
			'rules' => 'trim|required|xss_clean'
		)
    );
    
    function __construct() {
        parent::__construct();
    }    
}

?>
