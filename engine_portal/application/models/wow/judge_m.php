<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Judge_m extends MY_Model {
    protected $_table_name = 'wow_judge';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id ASC';
    
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

    public function get_new(){
        $new = new stdClass();
        $new->id = '';
        $new->score = '';
        $new->comment = '';
        
        return $new;
    }
    
    function __construct() {
        parent::__construct();
    }
}

?>
