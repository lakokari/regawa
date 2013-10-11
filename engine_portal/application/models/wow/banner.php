<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Banner extends MY_Model {
    protected $_table_name = 'wow_banner';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    public $rules = array(
        'title' => array(
            'field' => 'title', 
            'label' => 'Title', 
            'rules' => 'required|xss_clean'
        ),
        'event_id' => array(
            'field' => 'event_id', 
            'label' => 'Event Name', 
            'rules' => 'required|xss_clean'
        ),
        'hyperlink' => array(
            'field' => 'hyperlink',
            'label' => 'Hyperlink',
            'rules' => 'required|xss_clean'
        ),
        'image_alt' => array(
            'field' => 'image_alt',
            'label' => 'Image Alt',
            'rules' => 'required|xss_clean'
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
        ),
        'location' => array(
            'field' => 'location',
            'label' => 'Location',
            'rules' => 'xss_clean'
        ),
        'banner_text' => array(
            'field' => 'banner_text',
            'label' => 'Banner Text',
            'rules' => 'required|xss_clean'
        )
    );

    public $upload_config_thumbnail = array(
        'upload_path'           =>  '/userfiles/wow/banner/',
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
        $new->event_id = 1;
        $new->image = '';
        $new->hyperlink = '';
        $new->title = '';
        $new->image_alt = '';
        $new->start_date = '';
        $new->stop_date = '';
        $new->banner_text = '';

        return $new;
    }
}

?>
