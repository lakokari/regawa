<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Category extends MY_Model {
    protected $_table_name = 'apps_category';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'category_id';
    
    public $rules = array(
        'category_name' => array(
            'field' => 'category_name', 
            'label' => 'Category Name', 
            'rules' => 'required|callback_unique_category_name|xss_clean'
        ),
        'category_title' => array(
            'field' => 'icon_url', 
            'label' => 'Icon Url', 
            'rules' => 'required|xss_clean'
        ),
    );

    function __construct() {
        parent::__construct();
    }    

    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->category_id = '';
        $new->category_name = '';
        $new->icon_url = '';
        
        return $new;
    }


    function delete_category($id, &$message){
        //check if any items in this category
        $this->load->model('wow/items');
        $found = $this->items->get_count(array('id'=>$id));
        if ($found){
            $message = 'This category still has item members. Please delete the items first';
            return FALSE;
        }
        
        return parent::delete($id);
    }


}

?>
