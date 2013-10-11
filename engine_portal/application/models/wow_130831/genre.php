<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Genre extends MY_Model {
    protected $_table_name = 'wow_genre';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
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
    
    function __construct() {
        parent::__construct();
    }    
    
    public function get_new(){
        $new = new stdClass();
        $new->category_id = 0;
        $new->category_name = '';
        $new->category_title = '';
        
        return $new;
    }
    
    function delete_category($category_id, &$message){
        //check if any items in this category
        $this->load->model('wow/items');
        $found = $this->items->get_count(array('category_id'=>$category_id));
        if ($found){
            $message = 'This category still has item members. Please delete the items first';
            return FALSE;
        }
        
        return parent::delete($category_id);
    }
}

?>
