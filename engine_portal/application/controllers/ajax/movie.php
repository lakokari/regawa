<?php

/**
 * Description of Movie for Ajax Call
 *
 * @author agung
 * @email agung
 */
class Movie extends Ajax {
            
    protected $channel_name = 'movie';
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;        
    }
    
    function load_top_view(){
        $this->load->model('movie/items');
        $offset = $this->input->post('offset', TRUE); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit', TRUE); if (!$limit) $limit = 10;
        
        //Load top view
        $top_view_result = $this->items->get_offset('*', array('top_viewYN'=>'y'), $offset, $limit);
        $top_view = array();
        foreach($top_view_result as $item){
            $item->item_thumbnail = config_item('api_sync').'movie/'.$item->item_thumbnail;
            $item->item_thumbnail_big = config_item('api_sync').'movie/'.$item->item_thumbnail_big;
            
            $top_view [] = $item;
        }
        $this->_result['items'] = $top_view;
        $this->_result['found'] = count($top_view);
    }
    
    function load_all_data(){
        $this->load->model('movie/items');
        
        $categories = $this->input->post('categories', TRUE);
        
        $field_key = '';
        $offset = 0;
        switch ($categories){
            case 'top_paid': 
                $field_key = 'top_paidYN'; 
                $offset = 6;
                break;
            case 'top_view': 
                $field_key = 'top_viewYN'; 
                $offset = 6;
                break;
            case 'newrelease': 
            default: 
                $field_key = 'new_releaseYN';
                $offset = 3;
        }
        
        $result_items = $this->items->get_offset('*', array($field_key=>'y'), $offset, 30);
        
        $items = array();
        foreach ($result_items as $item){
            $item->item_thumbnail = config_item('api_sync').'movie/'.$item->item_thumbnail;
            $item->item_thumbnail_big = config_item('api_sync').'movie/'.$item->item_thumbnail_big;
            $items [] = $item;
        }
        
        $this->_result['found'] = count($items);
        $this->_result['items'] = $items;
    }
}

/*
 * file location: /engine/application/controllers/ajax/book.php
 */
?>
