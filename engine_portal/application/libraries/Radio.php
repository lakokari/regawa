<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Radio
 * API to acces Radio channel data
 *
 * @author master
 */

class Radio {
    
    protected $_api_url_usee = 'http://cms.useetv.com/uzone-api?req=radio';
    protected $_api_url_sr = 'http://api.suararadio.com/streaming/lists';
    
    function __construct() {
    }
    
    public function items_usee(){
        $result = file_get_contents($this->_api_url_usee);
        
        return $this->_output($result);
    }
    
    public function items_sr(){
        $result = file_get_contents($this->_api_url_sr);
        
        return $this->_output($result);
    }
    
    public function send($sender='John', $message ='Hello!', $type='c'){
        $fields = array (
            'sender'    =>  urlencode($sender),
            'message'   =>  urlencode($message),
            'type'      =>  $type
        );
        $api_url = 'http://www.trijayafmplg.co.id/apis/data/message/';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = curl_exec($curl);
	
        
        return $data;
    }
    
    public function send_get($sender, $message, $type='c'){
        
        
        $fields = array (
            'sender'    => urlencode($sender),
            'message'   => urlencode($message),
            'type'      =>  $type
        );
        $api_url = 'http://www.actarifm.com/apis/data/message';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = curl_exec($curl);
        
        return $data;
    }
    
    /**
     * Helper function to output return value format
     * @param mix $data
     * @return mix
     */
    public function _output($data){
        return json_decode ($data);
    }
}

?>
