<?php

/**
 * Description of TV Tovi
 *
 * @author master
 */
class Tovi extends U_CMS_Controller {
    protected $_channel_name = 'tv';
    
    function __construct() {
        parent::__construct();
        $this->data['active_menu'] = 'tv';
    }
    
    /**
     * Parent category
     */
    public function index(){
        $this->items();
    }
    
    public function parent(){
        $this->data['page_title'] = 'TOVI Parent Category';
                
        $this->data['subview'] = 'cms/channels/tv/tovi/parentcategory/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function parent_edit($id=NULL){
        $this->load->model('tv/tovi_parent_category');
        // Set form
        $rules = $this->tovi_parent_category->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->tovi_parent_category->array_from_post(array('name','description'));
            
            if ($this->tovi_parent_category->save($data_post, $id) == TRUE) {
                redirect('cms/tovi/parent');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tv');
            }
        
        }
        
        $this->data['page_title'] = 'Parent Category Edit';
        if ($id)
            $data = $this->tovi_parent_category->get($id, TRUE);
        else
            $data = $this->tovi_parent_category->get_new();

        $this->data['toviparent'] = $data;

        //Load view
        $this->data['active_menu'] = 'tv';
        $this->data['subview'] = 'cms/channels/tv/tovi/parentcategory/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function parent_delete($id=NULL){
        $this->load->model('tv/tovi_parent_category');
        if ($id)
            $this->tovi_parent_category->delete($id);
            
        redirect('cms/tovi/parent');
    }
    
    public function category(){
        $this->data['page_title'] = 'TOVI Category';
                
        $this->data['subview'] = 'cms/channels/tv/tovi/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category_edit($id=NULL){
        $this->load->model('tv/tovi_category');
        // Set form
        $rules = $this->tovi_category->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->tovi_category->array_from_post(array('name','description'));
            
            if ($this->tovi_category->save($data_post, $id) == TRUE) {
                redirect('cms/tovi/category');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tovi');
            }
        
        }
        
        $this->data['page_title'] = 'Tovi Category Edit';
        if ($id){
            $this->data['channel'] = $this->tovi_category->get($id);
    }else{
            $this->data['channel'] = $this->tovi_category->get_new();
    }
        
        //Load view
        $this->data['active_menu'] = 'tv';
        $this->data['subview'] = 'cms/channels/tv/tovi/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category_delete($id=NULL){
        $this->load->model('tv/tovi_category');
        if ($id)
            $this->tovi_category->delete($id);
            
        redirect('cms/tovi/category');
    }
    
    public function items(){
        $this->data['page_title'] = 'TOVI Items';
                
        $this->data['subview'] = 'cms/channels/tv/tovi/items/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    function items_edit($autoId=NULL){
        //load model music category
        $this->load->model('tv/tovi_items');
        
        // Set form
        $rules = $this->tovi_items->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $post_fields = array('id','code',
                'name','description','actor','director','language','package_code','year','content_type','length','vcid','can_download',
                'can_onlineplay'
            );
            $data_post = $this->tovi_items->array_from_post($post_fields);
            $data_post['source'] = '1';
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/tv';
                        
            if ($this->tovi_items->save($data_post, $autoId) == TRUE) {
                redirect($retUrl);
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $autoId ? 'tv items - Edit':'tv items - New';
        
        //load data to edit
        if ($autoId)
            $data = $this->tovi_items->get($autoId, TRUE);
        else
            $data = $this->tovi_items->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/tovi/items');        
        
                
        $this->data['subview'] = 'cms/channels/tv/tovi/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function items_delete($autoId=NULL){
        if ($autoId){
            $this->load->model('tv/tovi_items');
            $this->tovi_items->delete($autoId);
        }
        
        redirect('cms/tovi/items');
    }
    
    public function tovi_upload($autoId=NULL){
        //load model music category
        $this->load->model('tv/tovi_items');
        
        if (!$autoId){
            redirect('cms/tovi/items');
        }
        
        
        // Set form
        $rules = $this->tovi_items->upload_rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            //create variable post to save into database
            $data_post = array();
            
            $id_to_filename = str_pad($autoId, 5, '0', STR_PAD_LEFT);
            
            $upload_err = '';
            
            //try to upload thumbnail
            if(!empty($_FILES['tovi_image']['name']))
            {
                $upload_config_thumb = $this->tovi_items->upload_config_thumbnail;
                $upload_config_thumb['upload_path'] = SITE_PATH.$upload_config_thumb['upload_path'];
                $upload_config_thumb['file_name'] = 'TV_TOVI_'.time().$id_to_filename.'.jpg';
                $upload_thumb = $this->tovi_items->my_upload('tovi_image',$upload_config_thumb,$upload_err,TRUE);

                if ($upload_thumb){
                    $data_post['small_image1'] = $upload_thumb['file_name'];
                    $data_post['small_image2'] = $upload_thumb['file_name'];
                    $data_post['big_image1'] = $upload_thumb['file_name'];
                    $data_post['big_image2'] = $upload_thumb['file_name'];

                        if ($upload_thumb['image_width']!=$this->tovi_items->thumb_width||$upload_thumb['image_height']!=$this->tovi_items->thumb_height){
                        $config_thumb = $this->tovi_items->config_thumb_resize;
                        $config_thumb['source_image'] = $upload_thumb['full_path'];
                        $this->tovi_items->image_manipulation($config_thumb);
                    }
                }
            }else{
                    $this->session->set_flashdata('error', $upload_err);
                }
            
            //save into database
            if (count($data_post)){
                if ($this->tovi_items->save($data_post, $autoId)){
                    $this->session->set_flashdata('error','Upload done and save into database succefully!');
                }else{
                    $this->session->set_flashdata('error','Failed to save upload file into database!');
                }
                
            }
            
            redirect('cms/tovi/items');
        }
        $this->data['retUrl'] = site_url('cms/tovi/items');
        $this->data['page_title'] = 'Upload Image';
        $this->data['item'] = $this->tovi_items->get($autoId, TRUE);
        $this->data['subview'] = 'cms/channels/tv/tovi/items/upload';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function station_edit($id=NULL){
        
        // Set form
        $rules = $this->stations->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->stations->array_from_post(array('id_category','tv_name','tv_code','tv_description','small_logo1','small_logo2','big_logo1','big_logo2','live_stream'));
            
            if ($this->stations->save($data_post, $id) == TRUE) {
                redirect('cms/tv');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tv');
            }
		
        }
        
        $this->data['page_title'] = 'Station Edit';
        if ($id){
            $this->data['channel'] = $this->stations->get($id);
			$items=$this->tv_category->get();
			for($i=0;$i<count($items);$i++){
				$this->data['items'][$items[$i]->category_id]=$items[$i]->category_name;
			}
		}else{
            $this->data['channel'] = $this->stations->get_new();
			$items=$this->tv_category->get();
			for($i=0;$i<count($items);$i++){
				$this->data['items'][$items[$i]->category_id]=$items[$i]->category_name;
			}
		}
        
        //Load view
        $this->data['active_menu'] = 'tv';
        $this->data['subview'] = 'cms/channels/tv/stations/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
}

?>
