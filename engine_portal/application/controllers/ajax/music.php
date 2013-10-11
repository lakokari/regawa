<?php

/**
 * Description of Music
 *
 * @author marwan
 * @email marwan
 */
class Music extends Ajax {
            
    protected $channel_name = 'music';
            
    function __construct() {
        parent::__construct();
        
        //load melon library
        $this->load->library('melon');
        $this->_result['found'] = 0;        
    }
    
    function get_genre_by_category(){
        //load genre model
        $this->load->model('music/genre');
        $categoryId = $this->input->post('categoryId',TRUE);
        
        $this->_result['items'] = $this->genre->get_select_where('*', array('categoryId'=>$categoryId), FALSE);
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function get_new_album(){
        //Load model
        $this->load->model($this->channel_name.'/album');
        
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $genreId = $this->input->post('genreId');
        
        $this->_result['items'] = $this->album->get_offset('*', array ('genreId' => $genreId), $offset, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function get_album_hot(){
        //Load model
        $this->load->model($this->channel_name.'/album');
        $this->load->model($this->channel_name.'/top_daily_m');
        
        $table_top_daily = $this->top_daily_m->get_tablename();
        $table_album = $this->album->get_tablename();
        
        $page	= $this->input->post('page'); if (!$page) $page = 1;
        $limit	= $this->input->post('limit'); if (!$limit) $limit = 20;
        
        $offset	= $page-1;
        $start	= $offset * $limit;
        $genreId = $this->input->post('genreId');
        
        $this->db->select('*')->from($table_top_daily);
        $this->db->join($table_album, $table_album .'.albumId='.$table_top_daily.'.albumId');
        $this->db->where('genreId', $genreId)->order_by('ranking asc, '.$table_top_daily.'.inserted_time desc')->offset($offset)->limit($limit);
        $this->_result['items'] = $this->db->get()->result();
        
        $this->_result['found'] = count($this->_result['items']);

    }
    
    function get_album_by_genre(){
        $genreId = $this->input->post('genreId');
        $offset = $this->input->post('offset');
        $limit = $this->input->post('limit');
        $start = $offset * $limit;
        
        //load album model
        $this->load->model('music/album');
        $totalSize = $this->album->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $datalist = $this->album->get_offset('*', array('genreId'=>$genreId), $start, $limit);
        $this->_result['totalSize'] = $totalSize;
        $this->_result['totalpage'] = $totalPages;
        $this->_result['offset'] = $offset;
        $this->_result['start'] = $start;
        $this->_result['items'] = $datalist;        
        $this->_result['size'] = count($datalist);   
    }
    
    function get_all_collection(){
        //load genre model
        $this->load->model($this->channel_name.'/album');
        
        $genreId = $this->input->post('genreId',TRUE);
        $offset = $this->input->post('offset', TRUE); if (!$offset) $offset=0;
        $limit = $this->input->post('limit'); if (!$limit) $limit =4;        
        
        
        $this->_result['items'] = $this->album->get_offset('*', array('genreId'=>$genreId), $offset, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }
}

/*
 * file location: /engine/application/controllers/ajax/music.php
 */
?>
