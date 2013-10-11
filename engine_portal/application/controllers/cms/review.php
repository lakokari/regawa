<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Features
 *
 * @author master
 */
class Review extends U_CMS_Controller {
    
    protected $channel_id = 1;
    protected $channel_name = '';
    protected $channel_title = '';
    
    protected $FM = NULL;
    
    function __construct() {
        parent::__construct();
        $this->data['active_menu'] = 'channels';
    }    
    
    protected function set_channel($channel_id){
        //load channel model //already loaded in parent class
        $this->load->model('channel_m');
        $channel = $this->channel_m->get_select_where('name, title', array('id'=>$channel_id), TRUE);
        $this->channel_id = $channel_id;
        $this->channel_name = $channel->name;
        $this->channel_title = $channel->title;
    }
    
    
    public function index($channel_id=NULL){
        $this->load->model('review_m');
        
        if (!$channel_id)
            $this->channel_id = '1';
        else
            $this->channel_id = $channel_id;
        
        $this->set_channel($this->channel_id);
        
        $this->data['channel_id'] = $this->channel_id;
        $this->data['channel_name'] = $this->channel_name;
        $this->data['page_title'] = $this->channel_title.' Review List';
        //Load view
        $this->data['subview'] = 'cms/review/index';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function add($id=NULL)
    {
        $this->load->model('review_m');
        // Set form
        $rules = $this->review_m->rules_send_review;
        $this->form_validation->set_rules($rules);

        $review_date = $this->input->post('review_datetime');
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->review_m->array_from_post(array('channel_name','item_id','reviewer_id','review_text'));
            $review_time = date('H:i:s');
            $data_post['review_datetime'] = $review_date." ".$review_time;

            if ($this->review_m->save($data_post, $id) == TRUE) {

                $redir = "cms/review/index";
                redirect($redir);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data review');
            }
        
        }
        if ($id){
            $this->data['itemreview'] = $this->review_m->get($id);
        }
        else{
            $this->data['itemreview'] = $this->review_m->get_new();
        }

        //create dropdown channel_name
        $this->load->model('channel_m');
        $res_group = $this->channel_m->get();
        
        foreach ($res_group as $item){
            $this->data['groupchannel'][$item->name] = $item->title;
        }
        $this->data['channel_name'] = $this->channel_name;
        $this->data['page_title'] = 'Add Review '.$this->channel_title;
        $this->data['subview'] = 'cms/review/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function edit($id=NULL)
    {
        $this->load->model('review_m');
        // Set form
        $rules = $this->review_m->rules_send_review;
        $this->form_validation->set_rules($rules);

        $channel_name = $this->input->post('channel_name');
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->review_m->array_from_post(array('review_text'));
            if ($this->review_m->save($data_post, $id) == TRUE) {

                $redir = "cms/review/index";
                redirect($redir);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data review');
            }
        
        }
        if ($id){
            $this->data['itemreview'] = $this->review_m->get($id);
        }
        else{
            $this->data['itemreview'] = $this->review_m->get_new();
        }
        $this->data['channel_name'] = $this->channel_name;
        $this->data['page_title'] = 'Edit Review '.$this->channel_title;
        $this->data['subview'] = 'cms/review/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function delete($id){
        $this->load->model('review_m');
        if ($id){
            $this->review_m->delete($id);
        }
        redirect('cms/review/index/');
    }
    
    
}
/*
 * file location: /application/controllers/cms/features.php
 */
