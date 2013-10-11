<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Gamelib
 * API to acces Game channel data
 *
 * @author master
 */

class Gamelib {
    
    protected $base_api_url = 'http://project.digitalmind.co.id/ugame/';
    protected $base_api_url_alt = 'http://118.98.96.127/';
    protected $curl = NULL;
        
    function __construct() {
        $this->curl = curl_init();
    }
    
    public function allgames(){
        
        
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->base_api_url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($this->curl);
        
        return json_decode($result);
    }
    
    public function bycategory($category_name='action'){
        
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->base_api_url.'category/'.$category_name);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($this->curl);
        
        return json_decode($result);
    }
    
    public function detail($gameId){
        
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->base_api_url.$gameId);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($this->curl);
        
        return json_decode($result);
    }
    
    public function majapahit_online(){
        $api = 'http://project.digitalmind.co.id/ugame/category/mmo/majapahit-online';
        
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $api);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($this->curl);
        
        return json_decode($result);
    }
    
    public function get_game_from_api_url($api_url){
        
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $api_url);
        curl_setopt($this->curl, CURLOPT_BINARYTRANSFER, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Host: api.ugame.co.id'));
        
        $result = json_decode(curl_exec($this->curl));
        //$result = file_get_contents($api_url);
        return ($result);
    }
    
}

?>
