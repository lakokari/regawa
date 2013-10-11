<?php

/**
 * Description of Syncronize_book
 *
 * @author marwan
 * @email marwan
 */
class Syncronize_tv extends Ajax {
            
    protected $channel_name = 'tv';
    protected $TV = NULL;            
    
    function __construct() {
        parent::__construct();
        
        //load Syncronize API library
        $this->load->library('syncronize/Synctv');
        $this->TV = $this->synctv;
        
        $this->_result['found'] = 0;        
    }
    
    function syncronize_stations_all()
    {
        $result = $this->TV->sync_stations();
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
    
    function syncronize_streams_all(){
        $result = $this->TV->sync_streamurl();
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
    
    function syncronize_vod_all(){
        $result = $this->TV->sync_vod();
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
    
    function syncronize_schedules_all(){
        $startdate = $this->input->post('startdate'); if (!$startdate) $startdate = date('Y-m-d');
        $day_length = $this->input->post('day_length'); if (!$day_length) $day_length = 5;
        
        $result = $this->TV->sync_schedules($startdate, $day_length, TRUE);
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
    
    public function syncronize_tovi_items_all(){
        $result = $this->TV->sync_tovi_items();
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
