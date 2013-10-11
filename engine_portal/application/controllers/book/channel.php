<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Book
 *
 * @author master
 */
class Channel extends U_Controller {
    
    protected $_channel_name = 'book';
    
    function __construct() {
        parent::__construct();        
    }
    
    public function index($category=NULL){  
        
        //load all book categories
        //load category model
        $this->load->model('book/category');
        $this->data['categories'] = $this->category->get();
        $this->data['category'] = $category;
        
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/index';
        $this->load->view('_layout_main', $this->data);
    }
    
}

?>