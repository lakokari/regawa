<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Featured
 *
 * @author master
 */
class Featured extends MY_Model {
    protected $_table_name = 'book_feature';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
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
		'amount_charged' => array(
			'field' => 'amount_charged', 
			'label' => 'Amount Charged', 
			'rules' => 'trim|required|xss_clean'
		)
    );
    
    function __construct() {
        parent::__construct();
    }    
}

?>
