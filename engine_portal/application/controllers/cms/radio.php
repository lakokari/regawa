<?php

/**
 * Description of Radio
 *
 * @author master
 */
class Radio extends U_CMS_Controller {
    protected $channel_name = 'radio';

    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = 'radio';
    }
    /*
    public function index(){
        //$this->items();
    }
    */
    public function index(){
        //load model music category
        $this->load->model('radio/category');
        
        $this->data['page_title'] = 'Radio Category';
        
                
        $this->data['subview'] = 'cms/channels/radio/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function genres()
    {
        $this->data['page_title'] = 'Radio Genres';
        
        //load model category
        $this->load->model('radio/genres');
        
        $this->data['genres'] = $this->genres->get();
        
        //create dropdown category
        $options = array(
            '1'    =>  'Usee TV',
            '2'=>  'Suara Radio'
        );
                
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/radio/genres/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items()
    {
        $this->data['page_title'] = 'Radio Items';
        
        //load model category
        $this->load->model('radio/category');
        
        $this->data['category'] = $this->category->get();
        //create dropdown category
        $options = array(
            'useetv'    =>  'Usee TV',
            'suararadio'=>  'Suara Radio'
        );
                
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/radio/items/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category_add($category_id=NULL)
    {
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->category->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            //$data_post = $this->category->array_from_post(array('radio_name','radio_site','radio_city','radio_province'));
            $data_post = $this->category->array_from_post(array('category_name'));
            
            /*
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            */
            if ($this->category->save($data_post, $category_id) == TRUE) {
                redirect('cms/radio');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($category_id){
            $this->data['catradio'] = $this->category->get($category_id);
        }
        else{
            $this->data['catradio'] = $this->category->get_new();
        }
        /*
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        */
        //Load view
        $this->data['page_title'] = 'Add Category Radio';
        $this->data['active_menu'] = 'radio';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function category_edit($category_id=NULL)
    {
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->category->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            //$data_post = $this->category->array_from_post(array('radio_name','radio_site','radio_city','radio_province'));
            $data_post = $this->category->array_from_post(array('category_name'));
            
            /*
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            */
            if ($this->category->save($data_post, $category_id) == TRUE) {
                redirect('cms/radio');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($category_id){
            $this->data['catradio'] = $this->category->get($category_id);
        }
        else{
            $this->data['catradio'] = $this->category->get_new();
        }
        /*
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        */
        //Load view
        $this->data['page_title'] = 'Edit Category Radio';
        $this->data['active_menu'] = 'radio';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function category_delete($category_id=NULL){
        $this->load->model($this->channel_name.'/category');
        if ($category_id)
            $this->category->delete($category_id);
        redirect('cms/'.$this->channel_name);
    }

    public function genre_add($id=NULL)
    {
        $this->load->model($this->channel_name.'/genres');
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->genres->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            //$data_post = $this->category->array_from_post(array('radio_name','radio_site','radio_city','radio_province'));
            $data_post = $this->genres->array_from_post(array('category_id','genre_name'));
            
            /*
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            */
            if ($this->genres->save($data_post, $id) == TRUE) {
                redirect('cms/radio/genres');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        

        /*
        $options = array(
            '1'    =>  'Usee TV',
            '2'    =>  'Suara Radio'
        );
                
        $this->data['options'] = $options;
        */
        if ($id){
            $this->data['genradio'] = $this->genres->get($id);
        }
        else{
            $this->data['genradio'] = $this->genres->get_new();
        }
        
        $res_option = $this->category->get();
        
        foreach ($res_option as $opt){
            $catgroup = $opt->category_id."-".$opt->category_name;
            $this->data['groupcat'][$opt->category_id] = $opt->category_name;
        }

        /*
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        */
        //Load view
        $this->data['page_title'] = 'Add Genre Radio';
        $this->data['active_menu'] = 'radio';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/genres/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function genre_edit($id=NULL)
    {
        $this->load->model($this->channel_name.'/genres');
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->genres->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            //$data_post = $this->category->array_from_post(array('radio_name','radio_site','radio_city','radio_province'));
            $data_post = $this->genres->array_from_post(array('category_id','genre_name'));
            
            /*
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            */
            if ($this->genres->save($data_post, $id) == TRUE) {
                redirect('cms/radio/genres');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['genradio'] = $this->genres->get($id);
        }
        else{
            $this->data['genradio'] = $this->genres->get_new();
        }

        $res_option = $this->category->get();
        
        foreach ($res_option as $opt){
            $catgroup = $opt->category_id."-".$opt->category_name;
            $this->data['groupcat'][$opt->category_id] = $opt->category_name;
        }
        /*
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        */
        //Load view
        $this->data['page_title'] = 'Edit Genre Radio';
        $this->data['active_menu'] = 'radio';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/genres/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function genre_delete($id=NULL){
        $this->load->model($this->channel_name.'/genres');
        if ($id)
            $this->genres->delete($id);
        redirect('cms/'.$this->channel_name.'/genres');
    }

    public function items_add($id=NULL)
    {
        $this->load->model($this->channel_name.'/items');
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->items->array_from_post(array('radio_name','radio_site','radio_city','radio_province'));
            
            /*
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            */
            if ($this->items->save($data_post, $id) == TRUE) {
                redirect('cms/radio/items');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['radio'] = $this->items->get($id);
        }
        else{
            $this->data['radio'] = $this->items->get_new();
        }
        /*
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        */
        //Load view
        $this->data['page_title'] = 'Add Book';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_edit($id=NULL)
    {
        $this->load->model($this->channel_name.'/items');
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->items->array_from_post(array('radio_name','radio_site','radio_city','radio_province'));
            
            /*
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            */
            if ($this->items->save($data_post, $id) == TRUE) {
                redirect('cms/radio/items');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['radio'] = $this->items->get($id);
        }
        else{
            $this->data['radio'] = $this->items->get_new();
        }
        /*
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        */
        //Load view
        $this->data['page_title'] = 'Edit Items Radio';
        $this->data['active_menu'] = 'radio';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_delete($id=NULL){
        $this->load->model($this->channel_name.'/items');
        if ($id)
            $this->items->delete($id);
        redirect('cms/'.$this->channel_name.'/items');
    }
}

?>
