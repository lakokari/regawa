<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tv
 *
 * @author MSU203
 */
class tv extends Ajax {
    
    protected $channel_name = 'tv';
    
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;        
    }
    
    function get_schedule(){
        $this->load->model($this->channel_name.'/tv_schedules');
        $this->load->model($this->channel_name.'/stations');
        
        $tvcode = $this->input->post('tvcode', TRUE); if (!$tvcode) $tvcode = NULL;
        $category = $this->input->post('category', TRUE);
        $datetime = $this->input->post('date', TRUE);
        $limit = $this->input->post('limit', TRUE); if (!$limit) $limit = 50;
        
        //get schedule from tv module
        $where = NULL;
        if ($category && $category > 0)
            $where['category'] = $category;
        
        if ($tvcode)
            $where['tvcode'] = $tvcode;
        
        if ($datetime && $datetime > 0){
            $where['date'] = $date = date('Y-m-d', $datetime);
        }
        
        $res_items = $this->tv_schedules->get_by($where);
        $items = array();
        foreach($res_items as $item){                    
            if ($this->is_device('MOBILE'))
                $item->tvod_stream = base64_encode($item->tvod_stream_mobile);
            else
                $item->tvod_stream = base64_encode($item->tvod_stream);
            
            $image_base_url = config_item('api_sync') .'tv/';
            
            //Format acara to uppercase
            $item->acara = ucfirst($item->acara);
            
            //get image station from different model
            $station = $this->stations->get_select_where('small_logo1,big_logo1',array('tv_code'=>$item->tvcode), TRUE);
            if ($station){
                $item->small_logo1 = base64_encode($image_base_url. $station->small_logo1);
                $item->big_logo1 = base64_encode($image_base_url. $station->big_logo1);
            }
            
            $items [] = $item;
        }
        $this->_result['items'] = $items;
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function get_station(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 40;
        $start = $offset * $limit;

        $this->load->model('tv/stations');
        
        $res_items = $this->stations->get_offset('*', NULL, $start, $limit);
        $station_items = array();
        foreach($res_items as $item){
            if ($this->is_device('MOBILE'))
                $item->live_stream = base64_encode($item->live_stream_mobile);
            else
                $item->live_stream = base64_encode($item->live_stream);
            
            //encode image
            $img_base_url = config_item('api_sync') .'tv/';
            $item->small_logo1 = base64_encode($img_base_url.$item->small_logo1);
            $item->big_logo1 = base64_encode($img_base_url.$item->big_logo1);
            
            $station_items [] = $item;
        }
        
        $this->_result['items'] = $station_items;
        $this->_result['found'] = count($this->_result['items']);
    }

    function get_most_popular(){
        $this->load->model($this->channel_name.'/tv_most_popular');
        
        $offset = $this->input->post('offset', TRUE); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit', TRUE); if (!$limit) $limit = 20;
        
        
        $result_tv_popular = $this->tv_most_popular->get_offset('*', NULL, $offset, $limit);;
                
        $popularitems = array();
        foreach($result_tv_popular as $item){
            if ($this->is_device('MOBILE')){
                $item->stream_url = base64_encode($item->hls);
            }else{
                $item->stream_url = base64_encode($item->rtmp);
            }
            $item->thumbnail = base64_encode(config_item('api_sync'). 'tv/' .$item->thumbnail);
            
            $popularitems[] = $item;
        }
        
        
        $this->_result['items'] = $popularitems;
        $this->_result['found'] = count($this->_result['items']);
    }

}