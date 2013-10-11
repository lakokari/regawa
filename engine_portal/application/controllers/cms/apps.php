<?php

/**
 * Description of music
 *
 * @author master
 */
class Apps extends U_CMS_Controller {

    protected $channel_name = 'apps';

    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = 'apps';
    }
    
    public function index(){
        //load model music category
        $this->load->model('apps/category');
        
        $this->data['page_title'] = 'App Store Category';
        
                
        $this->data['subview'] = 'cms/channels/apps/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category($page=0,$limit=10){
        $this->index($page, $limit);
    }

    public function category_edit($id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/category');
        
        // Set form
        $rules = $this->category->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->category->array_from_post(array('parent_id','category_name','icon_url','category_id'));        
            $data_post['category_name'] = url_title($data_post['category_name'], '', TRUE);
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/apps';
            
            if ($this->category->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'apps Category - Edit':'apps Category - New';
        
        //load data to edit
        if ($id)
            $data = $this->category->get($id, TRUE);
        else
            $data = $this->category->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/apps');
        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function category_delete($id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/category');
        
        if ($id){
            $message = '';
            if (!$this->category->delete_category($id, $message)){
                $this->session->set_flashdata('error',$message);
            }
        }
            
        redirect('cms/'.$this->channel_name);
    }



    public function items()
    {
        $this->data['page_title'] = 'Apps Items';
        
        //load model category
        $this->load->model('apps/category');
        
        $this->data['category'] = $this->category->get();
        
        $this->data['subview'] = 'cms/channels/apps/items/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function items_edit($id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/items');
        
        // Set form
        $rules = $this->items->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $post_fields = array('parent_id','package_id','category_id',
                'category','package_name','description','developer_or_publisher','developer_or_publisher_site','telkomstore_link','icon_url',
                'version', 'price'
            );
            $data_post = $this->items->array_from_post($post_fields); 
            //$category = $data_post['category'];

            if ($this->items->save($data_post, $id) == TRUE) {
                $this->session->set_flashdata('category_id', $data_post['category_id']);
                redirect('cms/apps/items/'. $category[0]);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'apps Item - Edit':'apps Item - New';
        
        //load data to edit
        if ($id)
            $data = $this->items->get($id, TRUE);
        else
            $data = $this->items->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/apps/items');
        
        //get category for dropdown
        $this->load->model($this->channel_name.'/category');
        $result = $this->category->get();
        $category = array();
        foreach ($result as $item){
            $category [$item->category_id] = $item->category_name;
        }
        $this->data['category'] = $category;
        
        
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/items');
            $this->items->delete($id);
        }
        
        redirect('cms/apps/items');
    }

    public function featured()
    {
        $this->data['page_title'] = 'Feature List';
        
        $this->data['subview'] = 'cms/channels/apps/featured/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    function featured_edit($id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/featured');
        
        // Set form
        $rules = $this->featured->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $post_fields = array('package_id',
                'category','package_name','description','developer_or_publisher','developer_or_publisher_site','telkomstore_link','icon_url',
                'version', 'price'
            );
            $data_post = $this->featured->array_from_post($post_fields); 
            $category = $data_post['category'];
                        
            if ($this->featured->save($data_post, $id) == TRUE) {
                $this->session->set_flashdata('category_id', $data_post['category_id']);
                redirect('cms/apps/featured/'. $category[0]);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'apps Featured - Edit':'apps Item - New';
        
        //load data to edit
        if ($id)
            $data = $this->featured->get($id, TRUE);
        else
            $data = $this->featured->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/apps/featured');
        
        //get category for dropdown
        $this->load->model($this->channel_name.'/category');
        $result = $this->category->get();
        $category = array();
        foreach ($result as $item){
            $category [$item->category_name] = $item->category_name;
        }
        $this->data['category'] = $category;
        
        
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/featured/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function featured_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/featured');
            $this->featured->delete($id);
        }
        
        redirect('cms/apps/featured');
    }


}

?>
