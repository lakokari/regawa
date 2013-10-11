<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Thumb_home extends MY_Model {
    protected $_table_name = 'book_items';
    protected $_primary_key = 'auto_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'auto_id';
    
    public $rules = array(
		'name' => array(
			'field' => 'name', 
			'label' => 'Book Name', 
			'rules' => 'trim|required|xss_clean'
		),
		'author' => array(
			'field' => 'author', 
			'label' => 'Book Author', 
			'rules' => 'trim|required|xss_clean'
		),
		'sub_publisher_name' => array(
			'field' => 'sub_publisher_name', 
			'label' => 'Publisher Name', 
			'rules' => 'trim|required|xss_clean'
		),
		'price' => array(
			'field' => 'price', 
			'label' => 'Book Price', 
			'rules' => 'trim|required|xss_clean'
		),
		'description' => array(
			'field' => 'description', 
			'label' => 'Book Description', 
			'rules' => 'trim|required|xss_clean'
		),
		'publish_date' => array(
			'field' => 'publish_date', 
			'label' => 'Publish Date', 
			'rules' => 'trim|required|xss_clean'
		)
    );

    function __construct() {
        parent::__construct();
    }    
}

?>
