<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tovi_category
 *
 * @author master
 */
class Tovi_category extends MY_Model {
    protected $_table_name = 'tv_tovi_category';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'name';

    public $rules = array(
            'name' => array(
                'field' => 'name', 
                'label' => 'name', 
                'rules' => 'trim|required|xss_clean'
            ),
            'description' => array(
                'field' => 'description', 
                'label' => 'description', 
                'rules' => 'trim|required|xss_clean'
            ) 
    );
    
    function __construct() {
        parent::__construct();
    }

    function get_new() {
        $new = new stdClass();
        $new->name = '';
        $new->description = '';
        
        return $new;
    }

}
?>
