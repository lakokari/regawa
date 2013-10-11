<?php

/**
 * Description of Music
 *
 * @author marwan
 * @email marwan
 */
class Games extends Ajax {
            
    protected $channel_name = 'games';
            
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;        
    }
    
    function games_by_category_name(){
        //load genre model
        $this->load->model($this->channel_name.'/items', 'game_items_m');
        
        $search = array('#','-');
        $category_name = strtolower(str_ireplace($search, '', $this->input->post('category_name',TRUE)));
        
        
        $offset = $this->input->post('offset');  if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        if ($category_name != 'mmo'){
            $like = array(
                'field'     =>  'categories',
                'value'     =>  $category_name,
                'position'  =>  'both'
            );

            $datalist = $this->game_items_m->get_like($like, '*', $offset, $limit);
        }else{
            $datalist = $this->game_items_m->get_offset('*', array('mmo_YN'=>'y'), $offset, $limit);
        }
        foreach($datalist as $item){
            $item->thumbnail_url = config_item('api_sync') . $this->channel_name .'/' .$item->thumbnail_url;
            $this->_result['items'][] = $item;
        }
        
        $this->_result['found'] = count($datalist);
    }
    
    function get_genre_by_category(){
        //load genre model
        $this->load->model('music/genre');
        $categoryId = $this->input->post('categoryId',TRUE);
        
        //$this->_result['items'] = $this->melon->genres_from_category($categoryId);
        $this->_result['items'] = $this->genre->get_select_where('*', array('categoryId'=>$categoryId), FALSE);
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function get_new(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 30;

        $this->load->model('games/new_r','game_newrelease_m');
        
        $datalist = $this->game_newrelease_m->get_offset('*', NULL, $offset, $limit);
        foreach($datalist as $item){
            $item->thumbnail_url = config_item('api_sync') . $this->channel_name .'/' .$item->thumbnail_url;
            $this->_result['items'][] = $item;
        }
        
        $this->_result['found'] = count($this->_result['items']);
    }


    function get_top(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 30;

        $this->load->model('games/top','game_top_m');
        $datalist = $this->game_top_m->get_offset('*', NULL, $offset, $limit);
        foreach($datalist as $item){
            $item->thumbnail_url = config_item('api_sync') . $this->channel_name .'/' .$item->thumbnail_url;
            $this->_result['items'][] = $item;
        }
        
        $this->_result['found'] = count($this->_result['items']);
    }
}

/*
 * file location: /engine/application/controllers/ajax/music.php
 */
?>
