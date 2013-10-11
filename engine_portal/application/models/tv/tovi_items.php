<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tovi_items
 *
 * @author master
 */
class Tovi_items extends MY_Model {
    protected $_table_name = 'tv_tovi_items';
    protected $_primary_key = 'autoId';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'year desc, id';
    
    public $thumb_width = 200;
    public $thumb_height = 200;
    
    public $img_base_url = 'http://118.98.96.50/img';
    public $video_base_url = 'http://www.useetv.com/v?';
    
    public $rules = array(
        'id' => array(
            'field' => 'id', 
            'label' => 'id', 
            'rules' => 'required|xss_clean'
        ),
        'name' => array(
            'field' => 'name', 
            'label' => 'Name', 
            'rules' => 'required|xss_clean'
        ),
        'code' => array(
            'field' => 'code', 
            'label' => 'code', 
            'rules' => 'required|xss_clean'
        )
    );

    public $upload_config_thumbnail = array(
        'upload_path'           =>  '/userfiles/tv/tv_tovi/',
        'allowed_types'         =>  'jpg',
        //'max_size'              =>  500,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
    
    public $config_thumb_resize = array(
        'image_library'         =>  'gd2',
        'source_image'          =>  '',
        'create_thumb'          =>  FALSE,
        'maintain_ratio'        =>  FALSE,
        'width'                 =>  200,
        'height'                =>  200
    );

    public $upload_rules = array(
        'tovi_image' => array(
            'field' => 'tovi_image', 
            'label' => 'Image File', 
            'rules' => 'xss_clean'
        )
    );


    function __construct() {
        parent::__construct();
    }

    public function get_new(){
        $new = new stdClass();
        $new->id = '';
        $new->code = '';
        $new->name = '';
        $new->description = '';
        $new->actor = '';
        $new->director = '';
        $new->language = '';
        $new->package_code = '';
        $new->year = '20'.date('y');
        $new->length = '';
        $new->can_download = '';
        $new->can_onlineplay = '';
        $new->content_type = '';
        
        return $new;
    }

}
?>
