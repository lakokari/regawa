<?php

/**
 * Description of Apps for Ajax Call
 *
 * @author marwan
 * @email marwan
 */
class Apps extends Ajax {
            
    protected $APPS = NULL;
    protected $channel_name = 'apps';
            
    function __construct() {
        parent::__construct();
        
        //load library
        $this->load->library('Apstore');
        $this->APPS = $this->apstore;
        
        $this->_result['found'] = 0;        
    }
    
    function category_list(){
        $this->load->model('apps/category');

        $parent_id = $this->input->post('parent_id');
        $where = array('parent_id'=>$parent_id);
        $this->_result['items'] = $this->category->get_select_where('*',$where,NULL);

        $this->_result['found'] = count($this->_result['items']);
    }
    
    function category_items(){
        $parent_id = $this->input->post('parent_id');
        $category_id = $this->input->post('category_id');

        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $this->load->model('apps/items');
        $where = array('parent_id'=>$parent_id,'category_id'=>$category_id);
        $this->_result['items'] = $this->items->get_offset('*', $where, $start, $limit);
        
        $this->load->model('apps/category');
        $this->_result['cat_name'] = $this->category->get_select_where('category_name',array('parent_id'=>$parent_id,'category_id'=>$category_id), TRUE);
        
        $this->load->model('apps/parentcategory');
        $this->_result['parent_name'] = $this->parentcategory->get_select_where('name',array('id'=>$parent_id), TRUE);

        $this->_result['found'] = count($this->_result['items']);
    }

    function top_download_mob(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $this->load->model('apps/top');
        $where = array('parent_id'=>'2');
        $this->_result['items'] = $this->top->get_offset('*', $where, $start, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }

    function top_download_web(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $this->load->model('apps/top');
        $where = array('parent_id'=>'1');
        $this->_result['items'] = $this->top->get_offset('*', $where, $start, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }

    function apps_save_comment(){
        $package_id = $this->input->post('package_id');
        $rating = $this->input->post('rating');
        $comment = $this->input->post('comment');
        $user_email = $this->session->userdata('email');
        $user_name = $this->session->userdata('username');
        
        if ($rating>10) 
            $rating = 10;
        else if($rating<0)
            $rating = 0;
        
        //set default return status
        $this->_result['status'] = 0;
        
        if ($package_id){
            //load model
            $this->load->model('comment_rating_m');
            $data_post = array(
                'channel_name'  =>  'apps',
                'item_id'       =>  $package_id,
                'comment'       =>  $comment,
                'rating'        =>  $rating,
                'email'         =>  $user_email,
                'username'      =>  $user_name,
                'datetime'      =>  date('Y-m-d H:i:s'),
                'u_name'		=>  $user_name
            );
            
            if ($this->comment_rating_m->save($data_post)){
                $this->_result['status'] = 1;
            }
            
        }
    }

    function get_topmob(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $this->load->model('apps/items');
        $this->_result['items'] = $this->items->get_offset('*', array('parent_id'=>'2'), $start, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }

    function get_toppc(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $this->load->model('apps/items');
        $this->_result['items'] = $this->items->get_offset('*', array('parent_id'=>'1'), $start, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }

}

/*
 * file location: /engine/application/controllers/ajax/apps.php
 */
?>
