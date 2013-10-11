<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Featured
 *
 * @author master
 */
class Featured extends MY_Model {
    protected $_table_name = 'apps_feature';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'package_id';

    public $rules = array(
        'category' => array(
            'field' => 'category', 
            'label' => 'category', 
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
