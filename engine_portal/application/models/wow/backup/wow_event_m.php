<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Wow_event_m extends MY_Model {
    protected $_table_name = 'wow_event';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    public $rules = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Event Name', 
            'rules' => 'required|callback_unique_event_name|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    
    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->event_name = '';
        
        return $new;
    }
    
}
