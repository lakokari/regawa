<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Items extends MY_Model {
    protected $_table_name = 'wow_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    public $thumb_width = 200;
    public $thumb_height = 200;
    
    public $upload_video = array(
        'upload_path'           =>  '/userfiles/wow/',
        'allowed_types'         =>  'webm|ogg|mp4|3gp',
        //'max_size'              =>  5000,
        'overwrite'             =>  FALSE,
        'remove_spaces'          =>  TRUE
    );
    
    public $upload_config_thumbnail = array(
        'upload_path'           =>  '/userfiles/wow/thumbnail/',
        'allowed_types'         =>  'jpg',
        //'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
    
    public $config_thumb_resize = array(
        'image_library'         =>  'gd2',
        'source_image'          =>  '',
        'create_thumb'          =>  FALSE,
        'maintain_ratio'        =>  TRUE,
        'width'                 =>  200,
        'height'                =>  200
    );

    public $rules = array(
        'event_id' => array(
            'field' => 'event_id', 
            'label' => 'Event', 
            'rules' => 'required|xss_clean'
        ),
        'item_name' => array(
            'field' => 'item_name', 
            'label' => 'Item Name', 
            'rules' => 'required|xss_clean'
        ),
        'item_description' => array(
            'field' => 'item_description', 
            'label' => 'Item Description', 
            'rules' => 'xss_clean'
        )
    );
    
    public $rules_upload = array(
        'item_url' => array(
            'field' => 'item_url', 
            'label' => 'Video File', 
            'rules' => 'xss_clean'
        ),
        'item_thumbnail' => array(
            'field' => 'item_thumbnail', 
            'label' => 'Image File', 
            'rules' => 'xss_clean'
        )
    );
    
    
    function __construct() {
        parent::__construct();
    }
    
    function get_new(){
        $new =  new stdClass();
        $new->event_id = 0;
        $new->item_name = '';
        $new->item_type = 'movie';
        $new->item_url = '';
        $new->item_description = '';
        $new->tag_line = '';
        $new->approved = 0;
        
        return $new;
    }
    
}

?>
