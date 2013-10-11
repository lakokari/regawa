<?php

/**
 * Description of Cms
 *
 * @author marwan
 * @email marwan
 */
class Review extends Ajax {
     
    //private $hasTriedSync = FALSE;
    
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;   
        $this->_result['size'] = 0;
    }

    protected function set_channel($channel_name){
        //load channel model
        $this->load->model('channel_m');
        $channel = $this->channel_m->get_select_where('id, title', array('name'=>$channel_name), TRUE);
        $this->channel_id = $channel->id;;
        $this->channel_name = $channel_name;
        $this->channel_title = $channel->title;
    }

    function review_get_item(){
        //load helper
        $this->load->helper('cms');
        $this->load->model('review_m');
        $MM = $this->review_m;

        
        $channel_name = $this->input->post('channel_name');
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('channel_name'=>$channel_name);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/review/edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/review/delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->review['page_title'] = "Edit Review ".$channel_name;
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadReview($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
}