<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Game_apis extends MY_Model {
    protected $_table_name = 'game_api_url';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'category';
    
    public $rules = array(
        'category' => array(
            'field' => 'category', 
            'label' => 'Category Name', 
            'rules' => 'trim|required|xss_clean'
        ),
        'api_url' => array(
            'field' => 'api_url', 
            'label' => 'API Url', 
            'rules' => 'trim|required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    
    function get_new(){
        $new = new stdClass();
        $new->category = '';
        $new->api_url = '';
        
        return $new;
    }
}

?>
