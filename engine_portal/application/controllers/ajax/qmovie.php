<?php

/**
 * Description of Movie for Ajax Call
 *
 * @author agung
 * @email agung
 */
class Qmovie extends Ajax {
            
    protected $channel_name = 'movie';
    function __construct() {
        parent::__construct();
        
        //load movie library
        $this->load->library('movie');
        $this->_result['found'] = 0;        
    }
    
    function get_by_category(){
        $category = $this->input->post('category',TRUE);
        
        $result = $this->movie->get_by_category($category);
     
        $this->_result['items'] = $result;
        if (isset($this->_result['items']))
            $this->_result['found'] = count($this->_result['items']);
            
    }
    
    function get_new_movie(){
        $this->_result['items'] = $this->movie->new_movie();
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function get_favorite_movie(){
        $this->_result['items'] = $this->movie->favoriteMovie();
        $this->_result['found'] = count($this->_result['items']);
    }
}

/*
 * file location: /engine/application/controllers/ajax/book.php
 */
?>
