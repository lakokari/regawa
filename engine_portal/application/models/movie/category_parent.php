<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Category_parent extends MY_Model {
    protected $_table_name = 'movie_category_parent';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'name';
    
    public $rules = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Category Name', 
            'rules' => 'required|callback_unique_category_name|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    
    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->name = '';
        
        return $new;
    }
    
    function delete_category($category_id, &$message){
        //check if any items in this category
        $this->load->model('movie/items');
        $found = $this->items->get_count(array('category_id'=>$category_id));
        if ($found){
            $message = 'This category still has item members. Please delete the items first';
            return FALSE;
        }
        
        return parent::delete($category_id);
    }
}

?>
