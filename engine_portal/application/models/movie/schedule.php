<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Schedule extends MY_Model {
    protected $_table_name = 'movie_schedule';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'schedule_date asc, schedule_time asc';
    
    public $rules = array(
        'item_id' => array(
            'field' => 'item_id', 
            'label' => 'Movie Title', 
            'rules' => 'required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    

    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->city_id = '';
        $new->theater_id = '';
        $new->item_id = '';
        $new->schedule_date = date('y-m-d');
        $new->schedule_time = date('H:i:s');

        
        return $new;
    }
}

?>
