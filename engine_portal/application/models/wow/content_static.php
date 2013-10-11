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
    
    public $rules = array(
        'title' => array(
            'field' => 'title', 
            'label' => 'Title', 
            'rules' => 'required|callback_unique_title|xss_clean'
        ),
        'content' => array(
            'field' => 'content', 
            'label' => 'Content', 
            'rules' => 'required||xss_clean'
        ),
        'event_id' => array(
            'field' => 'event_id', 
            'label' => 'Event Id', 
            'rules' => 'required||xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
}

?>
