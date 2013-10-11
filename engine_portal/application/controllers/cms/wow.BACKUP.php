<?php

/**
 * Description of Wow
 *
 * @author master
 */
class Wow extends U_CMS_Controller {
    
    protected $channel_name = 'wow';
    
    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = 'wow';
    }
    
    public function index(){
        //load model music category
        $this->load->model($this->channel_name.'/category');
        
        $this->data['page_title'] = 'Wow Category';
        
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category(){
        $this->index();
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
            $data_post = $this->category->array_from_post(array('category_name','category_title'));        
            $data_post['category_name'] = url_title($data_post['category_name'], '', TRUE);
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/wow';
            
            if ($this->category->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
		
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Wow Category - Edit':'Wow Category - New';
        
        //load data to edit
        if ($id)
            $data = $this->category->get($id, TRUE);
        else
            $data = $this->category->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/wow');
        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function category_delete($category_id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/category');
        
        if ($category_id){
            $message = '';
            if (!$this->category->delete_category($category_id, $message)){
                $this->session->set_flashdata('error',$message);
            }
        }
            
        redirect('cms/'.$this->channel_name);
    }
    
    public function items()
    {
        $this->data['page_title'] = 'Wow Items';
        
        //load model category
        $this->load->model($this->channel_name.'/category');
        
        $this->data['category'] = $this->category->get();
        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item){
            //create dropwn options
            $options [$item->category_id] = $item->category_title;
        }
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/list';
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
            $data_post = $this->items->array_from_post(array('category_id','item_name','item_description','approved')); 
            $data_post['created_by'] = $this->session->userdata('userid');
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/items';
            
            if ($this->items->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
		
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Wow Item - Edit':'Wow Item - New';
        
        //load data to edit
        if ($id)
            $data = $this->items->get($id, TRUE);
        else
            $data = $this->items->get_new(
                    array(
                        'category_id'       =>  0,
                        'item_name'         =>  '',
                        'item_url'          =>  '',
                        'item_description'  =>  '',
                        'item_thumbnail'    =>  '',
                        'approved'          =>  0
                    )
            );
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/items');
        
        //get category for dropdown
        $this->load->model($this->channel_name.'/category');
        $result = $this->category->get();
        $categories = array();
        foreach ($result as $item){
            $categories [$item->category_id] = $item->category_title;
        }
        $this->data['categories'] = $categories;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items_upload($id=NULL){
        if (!$id){
            redirect('cms/wow/items');
        }
        
        
        //load wow item model
        $this->load->model($this->channel_name.'/items');
        
        // Set form
        $rules = $this->items->rules_upload;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            
            $upload_message_video = '';
            //try to upload video
            $upload_config_file = $this->items->upload_video;
            $upload_config_file['upload_path'] = SITE_PATH.$upload_config_file['upload_path'];
            $upload_file = $this->items->my_upload('item_url',$upload_config_file, $upload_message_video);
            if ($upload_file){
                $data_post['item_url'] = $upload_file['file_name'];
            }else{
                $this->session->set_flashdata('error', $upload_message_video);
            }
            
            //try to upload thumbnail
            $upload_message_thumb = '';
            $upload_config_thumb = $this->items->upload_config_thumbnail;
            $upload_config_thumb['upload_path'] = SITE_PATH.$upload_config_thumb['upload_path'];
            $upload_config_thumb['file_name'] = 'WOW_THUMB_'.time().'.jpg';
            $upload_thumb = $this->items->my_upload('item_thumbnail',$upload_config_thumb, $upload_message_thumb);
            if ($upload_thumb){
                $data_post['item_thumbnail'] = $upload_thumb['file_name'];
                //need resize ?
                if ($upload_thumb['image_width']!=$this->items->thumb_width||$upload_thumb['image_height']!=$this->items->thumb_height){
                    $config_thumb = $this->items->config_thumb_resize;
                    $config_thumb['source_image'] = $upload_thumb['full_path'];
                    $this->items->image_manipulation($config_thumb);
                }
            }
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/wow/items';
            
            if(count($data_post)){
                if ($this->items->save($data_post, $id) == TRUE) {
                    redirect($retUrl);
                    exit;
                } else{
                    $this->session->set_flashdata('error','Failed to save new update');
                }
            }
            
            redirect($retUrl);
            exit;
        }
        
        $this->data['page_title'] = 'Upload Wow Video and Image';
        $this->data['data'] = $this->items->get($id, TRUE);
        
        $this->data['retUrl'] = site_url('cms/wow/items');
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/upload';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/items');
            $this->items->delete($id);
        }
        
        redirect('cms/wow/items');
    }
    
    public function unique_category_name(){
        //$this->load->model($this->channel_name.'/category');
        
        //do not validate if exist
        //Unless it is the current record
        $category_id = $this->uri->segment(4);
        $new_category_name = $this->input->post('category_name');
        
        $this->db->where('category_name', url_title($new_category_name,'',TRUE));
        !$category_id || $this->db->where('category_id !=', $category_id);
        
        $found = $this->category->get();
        if (count($found)){
            $this->form_validation->set_message('unique_category_name','%s already exists!');
            
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function like()
    {
        $this->data['page_title'] = 'Wow Likes';
        
        //load model category
        $this->load->model($this->channel_name.'/items');
        
        $this->data['items'] = $this->items->get();
        //create dropdown category
        $options = array();
        foreach($this->data['items'] as $item){
            //create dropwn options
            $options [$item->id] = $item->item_name;
        }
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/like/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function like_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/like_list');
            $this->like_list->delete($id);
        }
        
        redirect('cms/wow/like');
    }
    
}

?>
