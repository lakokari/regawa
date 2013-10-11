<?php

/**
 * Description of Syncronize_book
 *
 * @author marwan
 * @email marwan
 */
class Syncronize_book extends Ajax {
            
    protected $channel_name = 'book';
    protected $BOOK = NULL;            
    
    function __construct() {
        parent::__construct();
        
        //load Syncronize API library
        $this->load->library('syncronize/Syncbook');
        $this->BOOK = $this->syncbook;
        
        $this->_result['found'] = 0;        
    }
    
    function syncronize_items_by_category()
    {
        $category_name = $this->input->post('category_name');
        $category_id = $this->input->post('category_id'); if (!$category_id) $category_id = 0;
        if ($category_name)
        {
            $result = $this->BOOK->syncronize_items_by_category($category_name, $category_id);
            if ($result){
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';

            }else{
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
            
        }
            
        
    }
    
    function syncronize_items_all()
    {
        $result = $this->BOOK->syncronize_items_all();
        if ($result){
            $this->_result['sync_status'] = 1;
            $this->_result['sync_count'] = $result;
            $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
        }
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
        }
    }
    
    function syncronize_items_by_featured(){
        $featured= $this->input->post('featured');
        $result = $this->BOOK->syncronize_by_featured($featured);
        if ($result){
            $this->_result['sync_status'] = 1;
            $this->_result['sync_count'] = $result;
            $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
        }
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
        }
    }
    
    function syncronize_featured()
    {
        $result = $this->BOOK->syncronize_feature();
        if ($result){
            $this->_result['sync_status'] = 1;
            $this->_result['sync_count'] = $result;
            $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
        }
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
        }
    }
    
    function syncronize_topdownload()
    {
        $result = $this->BOOK->syncronize_topdownload();
        if ($result){
            $this->_result['sync_status'] = 1;
            $this->_result['sync_count'] = $result;
            $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
        }
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
        }
    }
    
}

?>
