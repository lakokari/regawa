<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Rating extends MY_Model {
    protected $_table_name = 'movie_rating';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';

    public $rules = array(
        'rating' => array(
            'field' => 'rating', 
            'label' => 'Rating', 
            'rules' => 'required|xss_clean'
        ),

        'source_id' => array(
            'field' => 'source_id', 
            'label' => 'Source', 
            'rules' => 'required|callback_unique_source_id|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }


    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->item_id = '';
        $new->source_id = '';
        $new->source_link = '';
        $new->rating = '';
        
        return $new;
    }
 
}

?>
