<?php

/**
 * Description of Book for Ajax Call
 *
 * @author marwan
 * @email marwan
 */
class Book extends Ajax {
            
    protected $channel_name = 'book';
    
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;        
    }

    function get_new_release(){
        $limit = $this->input->post('limit',TRUE); if (!$limit) $limit = 10;
        $offset = $this->input->post('offset',TRUE); if (!$offset) $offset = 0;

        $this->load->model('book/items');

        $items = $this->items->get_offset('*',array('newrelease_YN'=>'y'), $offset, $limit);
        $this->_result['items'] = $items;
        $this->_result['found'] = count($this->_result['items']);
    }


    function get_best_seller(){
        $limit = $this->input->post('limit',TRUE); if (!$limit) $limit = 10;
        $offset = $this->input->post('offset',TRUE); if (!$offset) $offset = 0;

        $this->load->model('book/items');
        $items = $this->items->get_offset('*',array('bestseller_YN'=>'y'), $offset, $limit);
        $this->_result['items'] = $items;
        $this->_result['found'] = count($this->_result['items']);
    }

    function get_comic_mako(){
        //load book by category
        $this->load->model('book/makko');
        $MM = $this->makko;
        $perPage = $this->input->post('limit'); if (!$perPage) $perPage = 20;
        $exclude_id = $this->input->post('exclude_id');
        
        if ($exclude_id)
        {
            if (!is_array($exclude_id))
                $exclude_id = explode(',', $exclude_id);

            $where_not_in = array(
                'id'    =>  $exclude_id
            );
            $result = $MM->get_wherenotin_offset('*', null, $where_not_in, 0, $perPage);
        }else{
            $result = $MM->get_offset('*', null, 0, $perPage);
        }
        

        //get usedId
        $usedId = array();
        foreach ($result as $item) {
            $usedId [] = $item->id;
        }
        $this->_result['usedId'] = $usedId;
        $this->_result['items'] = $result;
        $this->_result['found'] = count($this->_result['items']);
            
    }

    function get_book_by_category(){
        //load book by category
        $this->load->model('book/items');
        $MM = $this->items;
        
        //$category_id = $this->input->post('category_id',TRUE);
        $category = $this->input->post('category',TRUE);
        $limit = $this->input->post('limit',TRUE); if (!$limit) $limit = 20;
        
        $like = array('field'=>'category_name','value'=>$category,'position'=>'both');
        $result = $MM->get_like($like, '*', 0, $limit);
        
        foreach ($result as $item) {
            $usedId [] = $item->content_id_token;
        }
        $this->_result['usedId'] = $usedId;

        $this->_result['items'] = $result;
        $this->_result['found'] = count($this->_result['items']);
            
    }
    function login_qbaca(){
        //get variable value from client caller
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $cid = $this->input->post('cid');

        //set login to qbaca API using CURL
        
        $fields = array(
            'email'     =>  $email,
            'pass'      =>  $password
        );

        //api url
        $api_url = 'http://qbaca.com/bookContent/login';

        //Init CURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = json_decode(curl_exec($curl));

        curl_close($curl);

        $this->_result['status'] = 0;

        if(isset($result->status)&&$result->status==1){
            //successfull login
            $this->_result['status'] = 1;
            $this->session->set_userdata('qbaca_email',$email);
            $this->_result['message'] = 'Berhasil login dengan '. $this->session->userdata('qbaca_email');
            $qs = array(
                'email'     =>  urlencode($email),
                'cid'       =>  $cid
            );
            $buy_url = 'http://qbaca.com/bookContent/checkout?'. http_build_query($qs);
            $this->_result['url'] = $buy_url;
        }else{
            $this->_result['message'] = 'Login tidak berhasil';
        }
    }

}

/*
 * file location: /engine/application/controllers/ajax/book.php
 */
?>
