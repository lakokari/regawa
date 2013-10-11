<?php

/**
 * Description of Homeimage for Ajax Call
 *
 * @author marwan
 * @email marwan
 */
class Homeimage extends Ajax {
            
    protected $APPS = NULL;
    protected $channel_name = 'none';
            
    function __construct() {
        parent::__construct();
        
        //load library
        $this->load->library('Apstore');
        $this->APPS = $this->apstore;
        
        $this->_result['found'] = 0;        
    }
    
    function homeimage_getlist(){
        $this->load->model('home_cover_image_m');
        
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;
        
        $fields = 'package_id,package_name,icon_url';
        
        $result = $this->featured->get_offset($fields, NULL, $start, $limit);
        
        if ($result)
        {
            $this->_result['items'] = $result;
        }

        $this->_result['found'] = count($this->_result['items']);
            
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
    
    function get_apps_comment(){
        $package_id = $this->input->post('package_id');
        $page = $this->input->post('page'); if (!$page) $page = 1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 30;
        
        $start = ($page-1) * $limit;
        //load library
        $this->load->library('Apstore');
        
        $comments = array();
        //get comments from internal database
        $this->load->model('comment_rating_m');
        $comments_in = $this->comment_rating_m->get_by(array('channel_name'=>'apps','item_id'=>$package_id));
        foreach ($comments_in as $c){
            $comments[] = array(
                'rating'        =>  $c->rating? $this->create_rating_image($c->rating):'',
                'comment'       =>  $c->comment?$c->comment:'',
                'sender'        =>  $c->email?$c->email:''
            );
        }
        //try to get comments from API
        $comments_api = $this->apstore->speedy_comment($package_id, $start, $limit);
        if ($comments_api->result){
            foreach($comments_api->comments as $c){
                $comments[] = array(
                'rating'        =>  $c->rating? $this->create_rating_image($c->rating):0,
                'comment'       =>  $c->comment?$c->comment:'',
                'sender'        =>  $c->customer?$c->customer:''
                );
            }
            
        }
        
        $this->_result['items'] = $comments;
        $this->_result['found'] = count($this->_result['items']);
    }
    function create_rating_image($rating=0){
        $img_url = site_url('/assets/img/rating.png');
        $str = '';
        for($i=0;$i<$rating; $i++)
            //$str .= '<img src="'.$img_url.'">';
            $str .= '<div style="width:9px; height:13px; float:left;"><img src="'.$img_url.'" /></div>';
        return $str;
    }
    
    function apps_save_comment(){
        $package_id = $this->input->post('package_id');
        $rating = $this->input->post('rating');
        $comment = $this->input->post('comment');
        $user_email = $this->session->userdata('email');
        
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
                'datetime'      =>  date('Y-m-d H:i:s')
            );
            
            if ($this->comment_rating_m->save($data_post)){
                $this->_result['status'] = 1;
            }
            
        }
        
    }
}

/*
 * file location: /engine/application/controllers/ajax/apps.php
 */
?>
