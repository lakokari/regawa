<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author master
 */
class Search extends U_Controller {
    
    protected $channel_name = 'search';
    
    function __construct() {
        parent::__construct();
        $this->data['active_menu'] = $this->channel_name;
    }
    
    function index($keyword=NULL){
        
        if (!$keyword)
            $keyword = $this->input->post('keyword');
        
        $this->data['keyword'] = urldecode($keyword);
        
        $this->data['search_result'] = array();
        
        //create search by calling search function
        $search_result = $this->search_by_api($keyword);
        //$this->data['search_found'] = isset($search_result->found)?$search_result->found:0;
        $this->data['search_found'] = $search_result->found;
        
        //load feature model
        $this->load->model('search_result_m');
        
        $this->data['subview'] = 'search/index';
        $this->load->view('_layout_main', $this->data);
    }
    
    protected function search_by_api($keyword){
        $fields = array(
            'client_appid'      =>  urlencode('uzone'),
            'client_password'   =>  urlencode(md5('uzoneregawa')),
            'keyword'           =>  urlencode(trim($keyword)),
            'session_id'        =>  urlencode($this->getStaticSessionId())
	);
        
	//set api url
        $action_url = base_url('api/search/all');
        
	$ch = curl_init(); 
	
	//configure url
	curl_setopt($ch, CURLOPT_URL, $action_url);
	
	//configure a POST request with some options
	curl_setopt($ch, CURLOPT_POST, 1);
	
	//put data to send
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);    
		
	//we dont want to get result ( as a string)        
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return expected

	//execute request
	$result = curl_exec($ch);
	curl_close($ch);
        
	return json_decode($result);
    }
    
    
}



?>
