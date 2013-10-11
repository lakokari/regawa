<?php

/**
 * Description of Syncronize_book
 *
 * @author marwan
 * @email marwan
 */
class Syncronize_radio extends Ajax {
            
    protected $channel_name = 'radio';
    protected $RADIO = NULL;            
    
    function __construct() {
        parent::__construct();
        
        //load Syncronize API library
        $this->load->library('syncronize/Syncradio');
        $this->RADIO = $this->syncradio;
        
        $this->_result['found'] = 0;        
    }
    
    function syncronize_items_by_category()
    {
        $radio_source = $this->input->post('radio_source');
        
        if ($radio_source)
        {
            if ($radio_source == 'useetv')
                $result = $this->RADIO->syncronize_items_usee();
            elseif ($radio_source == 'suararadio')
                $result = $this->RADIO->syncronize_items_sr();
            
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
        $result = $this->RADIO->syncronize_items_all();
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
