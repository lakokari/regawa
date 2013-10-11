<?php

/**
 * Description of book
 *
 * @author master
 */
class Book extends U_CMS_Controller {
    protected $channel_name = 'book';

    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = 'book';
    }
    
    public function index(){
        //load model music category
        $this->load->model('book/category');
        
        $this->data['page_title'] = 'Book Category';
        
                
        $this->data['subview'] = 'cms/channels/book/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items()
    {
        $this->data['page_title'] = 'Book Items';
        
        //load model category
        $this->load->model('book/category');
        
        $this->data['category'] = $this->category->get();
        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item){
            //create dropwn options
            $options [$item->category_id] = $item->category_name;
        }
        
        //create feature dropdown
        
        
        $this->data['options'] = $options;
        
        $this->data['featured_categories'] = array('bestseller'=>'Bestseller','new'=>'New','free'=>'Free','school'=>'School');
        
        $this->data['subview'] = 'cms/channels/book/items/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function feature()
    {
        $this->data['page_title'] = 'Feature List';
        
        $this->data['subview'] = 'cms/channels/book/featured/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function topdownload(){
        $this->data['page_title'] = 'Top Download List';
        
        $this->data['subview'] = 'cms/channels/book/topdownload/list';
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
            $data_post = $this->category->array_from_post(array('category_name'));
            
            if ($this->category->save($data_post, $category_id) == TRUE) {
                redirect('cms/book');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($category_id){
            $this->data['bookcat'] = $this->category->get($category_id);
        }
        else{
            $this->data['bookcat'] = $this->category->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Add Category Book';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/edit';
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
            $data_post = $this->category->array_from_post(array('category_name'));
            
            if ($this->category->save($data_post, $category_id) == TRUE) {
                redirect('cms/book');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($category_id){
            $this->data['bookcat'] = $this->category->get($category_id);
        }
        else{
            $this->data['bookcat'] = $this->category->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Edit Category Book';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function category_delete($category_id=NULL){
        $this->load->model($this->channel_name.'/category');
        if ($category_id)
            $this->category->delete($category_id);
        redirect('cms/'.$this->channel_name);
    }

    public function items_add($auto_id=NULL)
    {

        $this->load->model($this->channel_name.'/items');
        $this->load->model($this->channel_name.'/category');
        // Set form

        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->items->array_from_post(array('name','author','sub_publisher_name','isbn','price','description','content_id_token'));
            $pub_date = $this->input->post('publish_date');
            $pub_time = date('H:i:s');
            $data_post['publish_date'] = $pub_date." ".$pub_time;
            $data_post['created_at'] = date('Y-m-d H:i:s');
            //echo "date: ".$publish_date;
            //exit();
            
            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            if ($this->items->save($data_post, $auto_id) == TRUE) {
                redirect('cms/book/items');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($auto_id){
            $this->data['bookitem'] = $this->items->get($auto_id);
        }
        else{
            $this->data['bookitem'] = $this->items->get_new();
        }
        
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        
        //Load view
        $this->data['page_title'] = 'Add Book';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_edit($auto_id=NULL)
    {
        $this->load->model($this->channel_name.'/items');
        $this->load->model($this->channel_name.'/category');
        // Set form
        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->items->array_from_post(array('name','author','sub_publisher_name','isbn','price','description','content_id_token'));
            $pub_date = $this->input->post('publish_date');
            $pub_time = date('H:i:s');
            $data_post['publish_date'] = $pub_date." ".$pub_time;
            $data_post['created_at'] = date('Y-m-d H:i:s');

            //get category name
            $catid = $this->input->post('category_id');
            $where = array('category_id'=>$catid);
            $catarr = $this->category->get_by($where);

            $data_post['category_id'] = $catarr[0]->category_id;
            $data_post['category_name'] = $catarr[0]->category_name;
            if ($this->items->save($data_post, $auto_id) == TRUE) {
                redirect('cms/book/items');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($auto_id){
            $this->data['bookitem'] = $this->items->get($auto_id);
        }
        else{
            $this->data['bookitem'] = $this->items->get_new();
        }
        
        $res_group = $this->category->get();
        
        foreach ($res_group as $item){
            $catgroup = $item->category_id."-".$item->category_name;
            $this->data['groupcat'][$item->category_id] = $item->category_name;
        }
        //Load view
        $this->data['page_title'] = 'Edit Book';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_delete($auto_id=NULL){
        $this->load->model($this->channel_name.'/items');
        if ($auto_id)
            $this->items->delete($auto_id);
        redirect('cms/'.$this->channel_name.'/items');
    }

    public function featured_add($id=NULL)
    {
        $this->load->model($this->channel_name.'/featured');

        // Set form
        $rules = $this->featured->rules;
        $this->form_validation->set_rules($rules);

        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->featured->array_from_post(array('name','author','amount_charged'));
            
            if ($this->featured->save($data_post, $id) == TRUE) {
                redirect('cms/book/feature');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['featured'] = $this->featured->get($id);
        }
        else{
            $this->data['featured'] = $this->featured->get_new();
        }

        //Load view
        $this->data['page_title'] = 'Add Feature';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/featured/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function featured_edit($id=NULL)
    {
        $this->load->model($this->channel_name.'/featured');

        // Set form
        $rules = $this->featured->rules;
        $this->form_validation->set_rules($rules);

        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->featured->array_from_post(array('name','author','amount_charged'));
            
            if ($this->featured->save($data_post, $id) == TRUE) {
                redirect('cms/book/feature');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['featured'] = $this->featured->get($id);
        }
        else{
            $this->data['featured'] = $this->featured->get_new();
        }

        //Load view
        $this->data['page_title'] = 'Edit Feature';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/featured/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function featured_delete($id=NULL){
        $this->load->model($this->channel_name.'/featured');
        if ($id)
            $this->featured->delete($id);
        redirect('cms/'.$this->channel_name.'/feature');
    }

    public function topdownload_add($id=NULL)
    {
        $this->load->model($this->channel_name.'/topdownload');
        
        // Set form
        $rules = $this->topdownload->rules;
        $this->form_validation->set_rules($rules);

        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->topdownload->array_from_post(array('name','author','amount_charged'));
            
            if ($this->topdownload->save($data_post, $id) == TRUE) {
                redirect('cms/book/topdownload');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['top'] = $this->topdownload->get($id);
        }
        else{
            $this->data['top'] = $this->topdownload->get_new();
        }

        //Load view
        $this->data['page_title'] = 'Add Top Download';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/topdownload/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function topdownload_edit($id=NULL)
    {
        $this->load->model($this->channel_name.'/topdownload');

        // Set form
        $rules = $this->topdownload->rules;
        $this->form_validation->set_rules($rules);

        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->topdownload->array_from_post(array('name','author','amount_charged'));
            
            if ($this->topdownload->save($data_post, $id) == TRUE) {
                redirect('cms/book/topdownload');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($id){
            $this->data['top'] = $this->topdownload->get($id);
        }
        else{
            $this->data['top'] = $this->topdownload->get_new();
        }

        //Load view
        $this->data['page_title'] = 'Edit Top Download';
        $this->data['active_menu'] = 'book';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/topdownload/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function topdownload_delete($id=NULL){
        $this->load->model($this->channel_name.'/topdownload');
        if ($id)
            $this->topdownload->delete($id);
        redirect('cms/'.$this->channel_name.'/topdownload');
    }
}

?>
