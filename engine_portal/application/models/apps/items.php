<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Items extends MY_Model {
    protected $_table_name = 'apps_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'package_id';
    
    public $rules = array(
        'category_id' => array(
            'field' => 'category_id', 
            'label' => 'category_id', 
            'rules' => 'required|xss_clean'
        ),
        'package_name' => array(
            'field' => 'package_name', 
            'label' => 'Package Name', 
            'rules' => 'required|xss_clean'
        ),
        'description' => array(
            'field' => 'description', 
            'label' => 'Description', 
            'rules' => 'xss_clean'
        )
    );


    function __construct() {
        parent::__construct();
    }    

}

?>
