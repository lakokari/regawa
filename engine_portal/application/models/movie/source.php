<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Source extends MY_Model {
    protected $_table_name = 'movie_rating_source';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    public $rules = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Name of source', 
            'rules' => 'required|callback_unique_source_name|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    
    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->name = '';
        $new->alias = '';
        
        return $new;
    }
}

?>
