<?php

/**
 * Description of Search
 *
 * @author marwan
 * @email marwan
 */
class Search extends Ajax {
     
    function __construct() {
        parent::__construct();
        
        //load feature model
        $this->load->model('search_result_m');
        
        //load helper
        $this->load->helper('cms');
        
        $this->_result['found'] = 0;   
        $this->_result['size'] = 0;
    }
    
    function getSearchResult(){
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $this->_result['page'] = $page;
        $this->_result['limit'] = $limit;
        
        //count total search for this session
        $where = array('session_id' =>  $this->getStaticSessionId());
        $totalSize = $this->search_result_m->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $this->search_result_m->get_offset('*', $where, $start, $limit);
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $result;        
            $this->_result['size'] = count($result);   
            
            //create js paging
            $jsClick = 'javascript:showSearchResult($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
}

/*
 * file location: /engine/application/controllers/ajax/search.php
 */
?>
