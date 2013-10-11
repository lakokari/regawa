<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Coverstory_m
 *
 * @author master
 */
class Coverstory_m extends MY_Model {
    
    protected $_table_name = 'cover_story';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'sort';
    
    public $cover_w = 815;
    public $cover_h = 240;
    public $image_path = 'images/cover_story/';
    
    public $cover_config = array(
        'upload_path'           =>  'images/cover_story/',
        'allowed_types'         =>  'jpg',
        'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
    public $cover_resize = array(
        'image_library'         =>  'gd2',
        'create_thumb'          =>  FALSE,
        'maintain_ratio'        =>  FALSE,
        'width'                 =>  815,
        'height'                =>  240
    );
    
    public $rules = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Cover name', 
            'rules' => 'trim|required|xss_clean' //|callback_unique_coverstory_name
        ), 
        'title' => array(
            'field' => 'title', 
            'label' => 'Cover title', 
            'rules' => 'trim|xss_clean'
        ), 
        'sort' => array(
            'field' => 'sort', 
            'label' => 'Sort order', 
            'rules' => 'numeric|xss_clean'
        ), 
        'showed' => array(
            'field' => 'showed', 
            'label' => 'Showed', 
            'rules' => 'numeric|xss_clean'
        ), 
        'image_url' => array(
            'field' => 'image_url', 
            'label' => 'Cover Image', 
            'rules' => 'xss_clean'
        ),
        'target_url' => array(
            'field' => 'target_url', 
            'label' => 'Target url', 
            'rules' => 'xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_new(){
        $new = new stdClass();
        
        $new->id = 0;
        $new->name = '';
        $new->title = '';
        $new->sort = 0;
        $new->showed = 1;
        $new->image_url = '';
        $new->target_url = '';
        
        return $new;
    }
    
    public function delete($id) {
        //get filename image
        $image_name = $this->get_select_where('image_url', array('id'=>$id), TRUE);
        if ($image_name && file_exists(SITE_PATH . $this->image_path . $image_name)){
            unlink(SITE_PATH . $this->image_path . $image_name);
        }
        //delete record
        parent::delete($id);
    }
}

?>
