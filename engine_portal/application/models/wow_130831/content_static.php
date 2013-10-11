<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Content_static extends MY_Model {
    protected $_table_name = 'wow_static';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'display_order ASC';
    /*
    public $rules = array(
        'category_name' => array(
            'field' => 'category_name', 
            'label' => 'Category Name', 
            'rules' => 'required|callback_unique_category_name|xss_clean'
        ),
        'category_title' => array(
            'field' => 'category_title', 
            'label' => 'Category Title', 
            'rules' => 'required|xss_clean'
        )
    );
    */
    function __construct() {
        parent::__construct();
    }
}

?>
