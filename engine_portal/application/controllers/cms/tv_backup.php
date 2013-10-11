<?php

/**
 * Description of Radio
 *
 * @author master
 */
class Tv extends U_CMS_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(array('tv/stations','tv/tv_category'));
        $this->data['active_menu'] = 'tv';
    }
    
    /**
     * Station
     */
    public function index(){
        //load model music category
        //$this->load->model('tv/stations');
        
        $this->data['page_title'] = 'TV Stations';
                
        $this->data['subview'] = 'cms/channels/tv/stations/list';
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
    
    public function station_delete($id=NULL){
        if ($id)
            $this->stations->delete($id);
            
        redirect('cms/tv');
    }
    
    /**
     * StreamURL
     */
    public function streams($streamtype='tvod'){
        //load model music category
        //$this->load->model('tv/stations');
        
        $this->data['page_title'] = 'TV Streams';
        
        //set combo data for stream types
        $this->data['options'] = array('live'=>'Live', 'tvod'=>'TV On Demand');
        $this->data['streamtype'] = $streamtype;
        
        $this->data['subview'] = 'cms/channels/tv/streams/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    /**
     * TVOD
     */
    public function vod(){
        //load model music category
        //$this->load->model('tv/stations');
        
        $this->data['page_title'] = 'TV On Demand';
        
        $this->data['subview'] = 'cms/channels/tv/vod/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    /**
     * TV Schedules
     */
    public function schedules($tvcode='antv'){
        //load model music category
        $this->load->model('tv/stations');
        
        $this->data['page_title'] = 'TV Schedules';
        
        //create dropdown list
        $stations = $this->stations->get_select_where('tv_name,tv_code');
        $options= array();
        foreach( $stations as $station ){
            $options[$station->tv_code] = $station->tv_name;
        }
        
        $this->data['options'] = $options;
        $this->data['tv_code'] = $tvcode;
        
        $this->data['subview'] = 'cms/channels/tv/schedules/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    /**
     * Category
     */
    public function category(){
        
        $this->data['page_title'] = 'TV Category';
                
        $this->data['subview'] = 'cms/channels/tv/category/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category_edit($id=NULL){
        
        // Set form
        $rules = $this->tv_category->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->tv_category->array_from_post(array('category_name','showed_YN'));
            
            if ($this->tv_category->save($data_post, $id) == TRUE) {
                redirect('cms/tv/category');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tv');
            }
		
        }
        
        $this->data['page_title'] = 'TV Category Edit';
        if ($id){
            $this->data['channel'] = $this->tv_category->get($id);
	}else{
            $this->data['channel'] = $this->tv_category->get_new();
	}
        
        //Load view
        $this->data['active_menu'] = 'tv';
        $this->data['subview'] = 'cms/channels/tv/category/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function category_delete($id=NULL){
        if ($id)
            $this->tv_category->delete($id);
            
        redirect('cms/tv/category');
    }
}

?>
