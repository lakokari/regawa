<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Category extends MY_Model {
    protected $_table_name = 'radio_sod_category';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    function __construct() {
        parent::__construct();
    }    
    
    function get_new(){
        $category = new stdClass();
        $category->id = '';
        $category->category = '';
        $category->orderNum = 0;
    }
}

?>
