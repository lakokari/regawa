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
        ),
		'start_date' => array(
			'field' => 'start_date',
			'label' => 'Start Date',
			'rules' => 'required|xss_clean'
		),
		'stop_date' => array(
			'field' => 'stop_date',
			'label' => 'Stop Date',
			'rules' => 'required|xss_clean'
		)
    );
    
    public $upload_config_imgsmall = array(
        'upload_path'           =>  '/userfiles/wow/event/',
        'allowed_types'         =>  'jpg',
        //'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );

    public $upload_config_imgbig = array(
        'upload_path'           =>  '/userfiles/wow/event/',
        'allowed_types'         =>  'jpg',
        //'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );

    function __construct() {
        parent::__construct();
    }    
    
    public function get_new(){
        $new = new stdClass();
        $new->category_id = 1;
        $new->slug = '';
        $new->start_date = '';
        $new->stop_date = '';
        $new->allowed_movie_type = '';
        $new->max_movie_size = '';
        $new->name = '';
        $new->image_small = '';
        $new->image_big = '';
        
        return $new;
    }
    
}
