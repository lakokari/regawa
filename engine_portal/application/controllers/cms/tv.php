<?php

/**
 * Description of Radio
 *
 * @author master
 */
class Tv extends U_CMS_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model(array('tv/stations','tv/tv_category', 'tv/tv_streamurl', 'tv/tv_schedules'));
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
    
    public function streams_edit($id=NULL){
        // Set form
        $rules = $this->tv_streamurl->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->tv_streamurl->array_from_post(array('streamtype','tvcode','url_streaming'));
            $data_post['source'] = 1;
            
            if ($this->tv_streamurl->save($data_post, $id) == TRUE) {
                redirect('cms/tv/streams');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tv');
            }
        
        }
        
        $this->data['page_title'] = 'Streams Edit';
        if ($id)
            $data = $this->tv_streamurl->get($id, TRUE);
        else
            $data = $this->tv_streamurl->get_new();

        $this->data['streams'] = $data;

        //options streams
        $this->data['options'] = array('live'=>'Live', 'tvod'=>'TV On Demand');

        //options tvcode
        $res_group = $this->stations->get();
        
        foreach ($res_group as $item){
            $grouptvcode = $item->tv_code."-".$item->tv_name;
            $this->data['grouptvcode'][$item->tv_code] = $item->tv_name;
        }

        //Load view
        $this->data['active_menu'] = 'tv';
        $this->data['subview'] = 'cms/channels/tv/streams/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function streams_delete($id=NULL){
        if ($id)
            $this->tv_streamurl->delete($id);
            
        redirect('cms/tv/streams');
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
    
    function vod_edit($autoId=NULL){
        //load model music category
        $this->load->model('tv/tv_vod');
        
        // Set form
        $rules = $this->tv_vod->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $post_fields = array('id',
                'vod_name','vod_description','vod_actor','vod_director','vod_language','vod_year','vod_stream'
            );
            $data_post = $this->tv_vod->array_from_post($post_fields);
            $data_post['source'] = '1';
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/tv';
                        
            if ($this->tv_vod->save($data_post, $autoId) == TRUE) {
                redirect($retUrl);
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $autoId ? 'tv vod - Edit':'tv vod - New';
        
        //load data to edit
        if ($autoId)
            $data = $this->tv_vod->get($autoId, TRUE);
        else
            $data = $this->tv_vod->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/tv/vod');        
        
                
        $this->data['subview'] = 'cms/channels/tv/vod/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function vod_delete($autoId=NULL){
        if ($autoId){
            //load model music category
            $this->load->model('tv/tv_vod');
            $this->tv_vod->delete($autoId);
        }
        
        redirect('cms/tv/vod');
    }

    public function vod_upload($autoId=NULL){
        //load model music category
        $this->load->model('tv/tv_vod');
        
        if (!$autoId){
            redirect('cms/tv/vod');
        }
        
        
        // Set form
        $rules = $this->tv_vod->upload_rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            //create variable post to save into database
            $data_post = array();
            
            $id_to_filename = str_pad($autoId, 5, '0', STR_PAD_LEFT);
            
            $upload_err = '';
            
            //try to upload thumbnail
            if(!empty($_FILES['vod_image']['name']))
            {
                $upload_config_thumb = $this->tv_vod->upload_config_thumbnail;
                $upload_config_thumb['upload_path'] = SITE_PATH.$upload_config_thumb['upload_path'];
                $upload_config_thumb['file_name'] = 'TV_VOD_'.time().$id_to_filename.'.jpg';
                $upload_thumb = $this->tv_vod->my_upload('vod_image',$upload_config_thumb,$upload_err,TRUE);

                if ($upload_thumb){
                    $data_post['vod_small_image1'] = $upload_thumb['file_name'];
                    $data_post['vod_small_image2'] = $upload_thumb['file_name'];
                    $data_post['vod_big_image1'] = $upload_thumb['file_name'];
                    $data_post['vod_big_image2'] = $upload_thumb['file_name'];

                        if ($upload_thumb['image_width']!=$this->tv_vod->thumb_width||$upload_thumb['image_height']!=$this->tv_vod->thumb_height){
                        $config_thumb = $this->tv_vod->config_thumb_resize;
                        $config_thumb['source_image'] = $upload_thumb['full_path'];
                        $this->tv_vod->image_manipulation($config_thumb);
                    }
                }
            }else{
                    $this->session->set_flashdata('error', $upload_err);
                }
            
            //save into database
            if (count($data_post)){
                $data_post['source'] = 1;
                if ($this->tv_vod->save($data_post, $autoId)){
                    $this->session->set_flashdata('error','Upload done and save into database succefully!');
                }else{
                    $this->session->set_flashdata('error','Failed to save upload file into database!');
                }
                
            }
            
            redirect('cms/tv/vod');
        }
        $this->data['retUrl'] = site_url('cms/tv/vod');
        $this->data['page_title'] = 'Upload Image';
        $this->data['item'] = $this->tv_vod->get($autoId, TRUE);
        $this->data['subview'] = 'cms/channels/tv/vod/upload';
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
    
    public function schedules_edit($id=NULL){
        
        // Set form
        $rules = $this->tv_schedules->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->tv_schedules->array_from_post(array('tvcode','schedule_genid','date','jam','acara','start_time','end_time','file_status','tvod_stream'));
            
            if ($this->tv_schedules->save($data_post, $id) == TRUE) {
                redirect('cms/tv/schedules');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data tv');
            }
        
        }
        
        $this->data['page_title'] = 'Schedule Edit';
        if ($id)
            $data = $this->tv_schedules->get($id, TRUE);
        else
            $data = $this->tv_schedules->get_new();

        $this->data['schedule'] = $data;

        //options tvcode
        $res_group = $this->stations->get();
        
        foreach ($res_group as $item){
            $grouptvcode = $item->tv_code."-".$item->tv_name;
            $this->data['grouptvcode'][$item->tv_code] = $item->tv_name;
        }

        //options file_status
        $filestatus = array(
            'exist'=>'Exist',
            'no exist'=>'No Exist'
        );
        $this->data['groupfilestatus'] = $filestatus;

        //options category
        $where = array('showed_YN'=>'y');
        $res_cat = $this->tv_category->get_select_where('*',$where,FALSE);
        
        foreach ($res_cat as $item){
            $groupcategory = $item->category_id."-".$item->category_name;
            $this->data['groupcategory'][$item->category_id] = $item->category_name;
        }

        //Load view
        $this->data['active_menu'] = 'tv';
        $this->data['subview'] = 'cms/channels/tv/schedules/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function schedules_delete($id=NULL){
        if ($id)
            $this->tv_schedules->delete($id);
            
        redirect('cms/tv/schedules');
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
