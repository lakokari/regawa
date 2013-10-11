<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of QBook
 * API to acces QBaca books data
 *
 * @author master
 */

class Movie {
    
    //protected $_api_url = 'http://devel.uzone.co.id/uz-movie/api/';
    protected $_api_url = 'http://www.yovankeswani.com/uz-movie/api/';
    protected $_format = 'array';
    
    function __construct($format='array') {
        $this->_format = $format;
    }
    
    /**
     * List all movie categories
     * @return mix
     */
    public function movie_category(){
        $result = file_get_contents($this->_api_url .'getKategori');
        $result = str_replace('http://www.yovankeswani.com/uz-movie/api/', '', $result);
        
        return $this->_output($result);
    }
    /**
     * Get a new movie list
     * @return mix
     */
    public function get_by_category($param){
        $helper_url = 'getMovieByKategori/'.$param;
        
        $result = str_replace('http://www.yovankeswani.com/uz-movie/api/', '',file_get_contents($this->_api_url .$helper_url));
       
        return $this->_output($result);
    }
    /**
     * Get a new movie by category 
     * @return mix
     */
    public function favoriteMovie(){
        $result = file_get_contents($this->_api_url .'getMovieFavorite');
        $result = str_replace('http://www.yovankeswani.com/uz-movie/api/', '', $result);
        
        return $this->_output($result);
    }
    /**
     * Get a top hit movie 
     * @return mix
     */
    public function new_movie(){
        $result = file_get_contents($this->_api_url .'getMovie');
        $result = str_replace('http://www.yovankeswani.com/uz-movie/api/', '', $result);
        
        return $this->_output($result);
    }
    
    /**
     * Helper function to output return value format
     * @param mix $data
     * @return mix
     */
    public function _output($data){
        if ($this->_format=='json')
            return $data;
        else
            return json_decode ($data, TRUE);
    }
}

?>
