<?php

/**
 * Description of Syncronize_games
 *
 * @author marwan
 * @email marwan
 */
class Syncronize_games extends Ajax {
            
    protected $channel_name = 'games';
    protected $LIB = NULL;            
    
    function __construct() {
        parent::__construct();
        
        //load Syncronize API library
        $this->load->library('syncronize/Syncgames');
        $this->LIB = $this->syncgames;
        
        $this->_result['found'] = 0;        
    }
        
    function syncronize_category(){
        $result = $this->LIB->syncronize_categories();
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
    
    function syncronize_items_all(){
        $result = $this->LIB->syncronize_items();
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
    
    function syncronize_game_by_api(){
        $api_id = $this->input->post('id');
        $result = $this->LIB->syncronize_game_by_api($api_id);
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
