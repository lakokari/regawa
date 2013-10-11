<?php

/**
 * Description of Games
 *
 * @author master
 */
class Games extends U_CMS_Controller {
    protected $channel_name = 'games';
    
    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = $this->channel_name;
    }
    
    public function index(){
        //load model music category
        $this->load->model($this->channel_name.'/category');
        
        $this->data['page_title'] = 'Games Category';
        
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items()
    {
        $this->data['page_title'] = 'Games Items';
        
        //load model category
        $this->load->model($this->channel_name.'/category');
        
        $this->data['category'] = $this->category->get();
        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item){
            //create dropwn options
            $options [$item->category_name] = $item->category_name;
        }
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/list';
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
                redirect('cms/games');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($category_id){
            $this->data['gamescat'] = $this->category->get($category_id);
        }
        else{
            $this->data['gamescat'] = $this->category->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Add Category Games';
        $this->data['active_menu'] = 'games';
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
            $data_post = $this->category->array_from_post(array('category_name'));
            
            if ($this->category->save($data_post, $category_id) == TRUE) {
                redirect('cms/games');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($category_id){
            $this->data['gamescat'] = $this->category->get($category_id);
        }
        else{
            $this->data['gamescat'] = $this->category->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Edit Category Games';
        $this->data['active_menu'] = 'games';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function category_delete($autoId=NULL){
        $this->load->model($this->channel_name.'/category');
        if ($autoId)
            $this->category->delete($autoId);
        redirect('cms/'.$this->channel_name);
    }
    
    public function apis(){
        $this->data['page_title'] = 'Games API List';
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/apis/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function apis_edit($id=NULL){
        $this->load->model($this->channel_name.'/game_apis');
        // Set form
        $rules = $this->game_apis->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->game_apis->array_from_post(array('category','api_url'));
            
            if ($this->game_apis->save($data_post, $id) == TRUE) {
                redirect('cms/games/apis');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data game API');
            }
        
        }
        
        if ($id){
            $this->data['item'] = $this->game_apis->get($id);
        }
        else{
            $this->data['item'] = $this->game_apis->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Edit Game API';
        $this->data['active_menu'] = 'games';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/apis/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function apis_delete($id=NULL){
        $this->load->model($this->channel_name.'/game_apis');
        if ($id)
            $this->game_apis->delete($id);
        redirect('cms/'.$this->channel_name.'/apis');
    }

    public function items_add($autoId=NULL)
    {
        $this->load->model($this->channel_name.'/items');
        // Set form
        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->items->array_from_post(array('title', 'description','width','height'));
            
            if ($this->items->save($data_post, $autoId) == TRUE) {
                redirect('cms/games/items');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($autoId){
            $this->data['games'] = $this->items->get($autoId);
        }
        else{
            $this->data['games'] = $this->items->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Add Games';
        $this->data['active_menu'] = 'games';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/add';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_edit($autoId=NULL)
    {
        $this->load->model($this->channel_name.'/items');
        // Set form
        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->items->array_from_post(array('title', 'description','width','height'));
            
            if ($this->items->save($data_post, $autoId) == TRUE) {
                redirect('cms/games/items');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        if ($autoId){
            $this->data['games'] = $this->items->get($autoId);
        }
        else{
            $this->data['games'] = $this->items->get_new();
        }
        //Load view
        $this->data['page_title'] = 'Edit Games';
        $this->data['active_menu'] = 'games';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
        
    }

    public function items_delete($autoId=NULL){
        $this->load->model($this->channel_name.'/items');
        if ($autoId)
            $this->items->delete($autoId);
        redirect('cms/'.$this->channel_name.'/items');
    }
}

?>
