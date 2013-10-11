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
    
    public function category(){
        $this->data['page_title'] = 'TOVI Category';
                
        $this->data['subview'] = 'cms/channels/tv/tovi/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items(){
        $this->data['page_title'] = 'TOVI Items';
                
        $this->data['subview'] = 'cms/channels/tv/tovi/items/list';
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
