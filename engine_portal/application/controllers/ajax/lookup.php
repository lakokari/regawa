<?php

/**
 * Description of Lookup for Ajax Call
 *
 * @author marwan
 * @email marwan
 */
class Lookup extends Ajax {
            
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;        
    }
    
    function lookup_movie_tag(){
        //Load movie tag
        $this->load->model('movie/movietag');
        
        //get posted keyword
        $keyword = $this->input-post('keyword');
        
        //make query to database
        $like = array(
            'field'     =>  'tag',
            'value'     =>  $keyword,
            'position'  =>  'both'
        );
        $match_tags = $this->movietag->get_like($like, 'tag', 0, 20, 'result');
        
        //store result query to variable
        $this->_result['items'] = $match_tags;
        $this->_result['found'] = count($match_tags);
    }
}

/*
 * file location: /engine/application/controllers/ajax/lookup.php
 */
?>
