<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of feature_m
 *
 * @author master
 */
class Feature_m extends MY_Model {
    protected $_table_name = 'channel_feature_images';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'channel_id';
    
    public $feature_image_path = 'images/feature_list/';
    
    public $cover_config = array(
        'upload_path'           =>  '/userfiles/movie/thumbnail/',
        'allowed_types'         =>  'jpg',
        'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
    
    public $cover_resize = array(
        'image_library'         =>  'gd2',
        'create_thumb'          =>  FALSE,
        'maintain_ratio'        =>  FALSE,
        'width'                 =>  787,
        'height'                =>  237
    );
    
    public $rules = array(
        'channel_id' => array(
            'field' => 'channel_id', 
            'label' => 'Channel id', 
            'rules' => 'required|xss_clean'
        ),
        'category_id' => array(
            'field' => 'category_id', 
            'label' => 'Category id', 
            'rules' => 'required|xss_clean'
        ),
        'item_id' => array(
            'field' => 'category_id', 
            'label' => 'Category id', 
            'rules' => 'required|xss_clean'
        ),
        'cover' => array(
            'field' => 'cover', 
            'label' => 'Cover image feature', 
            'rules' => 'xss_clean'
        )
    );
    
    
    function __construct() {
        parent::__construct();
    }
    
    function get_featured($channel_id, $limit=5, $not_empty=TRUE){
        $where = array('channel_id'=>$channel_id);
        if ($not_empty){
            $where['cover !='] = '';
        }
        $featured = $this->get_offset('*', $where, 0, $limit);
        
        return $featured;
    }
    
    function is_featured($channel_id, $item_id){
        //try to find first
        $data = array('channel_id'=>$channel_id, 'item_id'=>$item_id);
        return (bool) $this->get_count($data)>0;
    }
    
    function set_as_featured($channel_id, $item_id){
        //try to find first
        $data = array('channel_id'=>$channel_id, 'item_id'=>$item_id);
        $found = $this->get_count($data);
        if ($found==0){
            //save as new featured channel
            $this->save($data);
        }
    }
    
    function save_cover($channel_id, $item_id, $cover=''){
        $id = $this->get_select_where('id', array('channel_id'=>$channel_id, 'item_id'=>$item_id), TRUE)->id;
        
        if ($id){
            return parent::save(array('cover'=>$cover), $id);
        }
    }
}

?>
