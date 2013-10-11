<?php

/**
 * Description of Syncronize_apps
 *
 * @author marwan
 * @email marwan
 */
class Syncronize_apps extends Ajax {
            
    protected $channel_name = 'apps';
    protected $APPS = NULL;            
    
    function __construct() {
        parent::__construct();
        
        //load Syncronize API library
        $this->load->library('syncronize/Syncapps');
        $this->APPS = $this->syncapps;
        
        $this->_result['found'] = 0;        
    }
    
    function syncronize_featured()
    {
        $result = $this->APPS->sync_featured();
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
    
    function syncronize_category(){
        $result = $this->APPS->category_all();
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
    
    function syncronize_items_by_category()
    {
        $category_id = $this->input->post('category_id');
        if ($category_id)
        {
            $result = $this->APPS->syncronize_items_by_category($category_id);
            if ($result){
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';

            }
        }
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
            
        }
            
        
    }
    
    function syncronize_category_speedy(){
        $result = $this->APPS->category_all_speedy();
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
    
    function syncronize_items_by_category_speedy()
    {
        $category_id = $this->input->post('category_id');
        if ($category_id)
        {
            $result = $this->APPS->syncronize_items_by_category_speedy($category_id);
            if ($result){
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';

            }
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
