<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Book Category Model
 *
 * @author master
 */
class Category extends MY_Model {
    protected $_table_name = 'book_category';
    protected $_primary_key = 'category_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'category_id';
    
    public $rules = array(
		'category_name' => array(
			'field' => 'category_name', 
			'label' => 'Category Name', 
			'rules' => 'trim|required|xss_clean|is_unique[uz_radio_category.category_name]'
		)
    );
    
    function __construct() {
        parent::__construct();
    }    
}

?>
