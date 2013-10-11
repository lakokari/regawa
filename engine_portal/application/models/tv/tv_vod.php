<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tvod
 *
 * @author master
 */
class Tv_vod extends MY_Model {
    protected $_table_name = 'tv_od';
    protected $_primary_key = 'autoId';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';

    public $thumb_width = 200;
    public $thumb_height = 200;

    public $rules = array(
        'id' => array(
            'field' => 'id', 
            'label' => 'id', 
            'rules' => 'required|xss_clean'
        ),
        'vod_name' => array(
            'field' => 'vod_name', 
            'label' => 'Vod Name', 
            'rules' => 'required|xss_clean'
        ),
        'vod_language' => array(
            'field' => 'vod_language', 
            'label' => 'vod language', 
            'rules' => 'xss_clean'
        )
    );

    public $upload_config_thumbnail = array(
        'upload_path'           =>  '/userfiles/tv/tv_vod/',
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
        'vod_image' => array(
            'field' => 'vod_image', 
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
        $new->vod_name = '';
        $new->vod_description = '';
        $new->vod_actor = '';
        $new->vod_director = '';
        $new->vod_language = '';
        $new->vod_stream = '';
        $new->vod_year = '20'.date('y');
        
        return $new;
    }

}
?>
