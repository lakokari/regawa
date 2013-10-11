<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Category extends MY_Model {
    protected $_table_name = 'wow_category';
    protected $_primary_key = 'category_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'category_id';
    
    public $rules = array(
        'category_name' => array(
            'field' => 'category_name', 
            'label' => 'Category Name', 
            'rules' => 'required|callback_unique_category_name|xss_clean'
        ),
        'category_title' => array(
            'field' => 'category_title', 
            'label' => 'Category Title', 
            'rules' => 'required|xss_clean'
        )
    );

    public $upload_config_icon = array(
        'upload_path'           =>  '/userfiles/wow/category/',
        'allowed_types'         =>  'jpg',
        //'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );

    public $upload_config_image = array(
        'upload_path'           =>  '/userfiles/wow/category/',
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
        $new->category_id = 0;
        $new->category_name = '';
        $new->category_title = '';
        $new->synopsis_category = '';
        $new->content_preview = '';
        $new->icon_preview = '';
        $new->image_preview = '';
        
        return $new;
    }
    
    function delete_category($category_id, &$message){
        //check if any items in this category
        $this->load->model('wow/wow_event_m');
        $found = $this->wow_event_m->get_count(array('category_id'=>$category_id));
        if ($found){
            $message = 'This category still has item members. Please delete the items first';
            return FALSE;
        }
        
        return parent::delete($category_id);
    }
}

?>
