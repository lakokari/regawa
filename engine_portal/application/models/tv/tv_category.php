<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class TV_Category extends MY_Model {
    protected $_table_name = 'tv_category';
    protected $_primary_key = 'category_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'category_id';
    
    public $rules = array(
            'category_name' => array(
                'field' => 'category_name', 
                'label' => 'category_name', 
                'rules' => 'trim|required|xss_clean'
            ),
            'showed_YN' => array(
                'field' => 'showed_YN', 
                'label' => 'Show', 
                'rules' => 'trim|max_length[1]|required|xss_clean'
            ) 
    );
    
    function __construct() {
        parent::__construct();
    }
    
    function get_new() {
        $new = new stdClass();
        $new->category_name = '';
        $new->showed_YN = 'y';
        
        return $new;
    }
}

?>
