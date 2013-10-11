<?php

/**
 * Description of Movie
 *
 * @author master
 */
class Movie extends U_CMS_Controller {
    
    protected $channel_name = 'movie';
    
    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = $this->channel_name;
    }
    
    public function index(){
        //load model music category
        $this->load->model($this->channel_name.'/category');
        
        $this->data['page_title'] = 'Movie Category';
        
                
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
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie';
            
            if ($this->category->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
		
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie Category - Edit':'Movie Category - New';
        
        //load data to edit
        if ($id)
            $data = $this->category->get($id, TRUE);
        else
            $data = $this->category->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie');
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
    
    public function items($category_id=NULL)
    {
        $this->data['page_title'] = 'Movie Items';
        
        //load model category
        $this->load->model($this->channel_name.'/category');
        $this->data['category_id'] = $category_id;
        $this->data['category'] = $this->category->get();
        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item){
            //create dropwn options
            $options [$item->category_name] = $item->category_title;
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
            $post_fields = array(
                'categories','item_name','item_description','publisher_name','published_year','synopsis','scene_writer',
                'director', 'cast_crew', 'url_full_movie', 'coming_soonYN', 'new_releaseYN', 'tag', 'view_paid_count', 'view_count'
            );
            $data_post = $this->items->array_from_post($post_fields); 
            $categories = $data_post['categories'];
            $data_post['categories'] = implode(',', $categories);
            $data_post['created_by'] = $this->session->userdata('userid');
                        
            if ($this->items->save($data_post, $id) == TRUE) {
                $this->session->set_flashdata('category_id', $data_post['category_id']);
                redirect('cms/movie/items/'. $categories[0]);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
		
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie Item - Edit':'Movie Item - New';
        
        //load data to edit
        if ($id)
            $data = $this->items->get($id, TRUE);
        else
            $data = $this->items->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/movie/items');
        
        //get category for dropdown
        $this->load->model($this->channel_name.'/category');
        $result = $this->category->get();
        $categories = array();
        foreach ($result as $item){
            $categories [$item->category_name] = $item->category_title;
        }
        $this->data['categories'] = $categories;
        
        
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function items_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/items');
            $this->items->delete($id);
        }
        
        redirect('cms/movie/items');
    }
    
    public function items_upload($id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/items');
        
        if (!$id){
            redirect('cms/movie/items');
        }
        
        //get category_name
        $categories = $this->items->get($id,TRUE,'row')->categories;
        if ($categories){
            $categories = explode(',', $categories);
            $category_name = $categories[0];
        }else{
            $category_name = 'action';
        }
        
        // Set form
        $rules = $this->items->upload_rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            //create variable post to save into database
            $data_post = array();
            
            $id_to_filename = str_pad($id, 5, '0', STR_PAD_LEFT);
            
            $upload_err = '';
            
            //try to upload video file
            $upload_video_cfg = $this->items->upload_video;
            $upload_video_cfg['upload_path'] = SITE_PATH . $upload_video_cfg['upload_path'];
            
            //try to upload video file mpeg (*.mp4)
            if(!empty($_FILES['item_url_mpeg']['name']))
            {
                $upload_mpeg = $upload_video_cfg;
                $upload_mpeg['allowed_types'] = 'mp4';
                $upload_mpeg['file_name'] = 'MOVIE_MP4_'.$id_to_filename.'.mp4';
                $upload = $this->items->my_upload('item_url_mpeg',$upload_mpeg,$upload_err,TRUE);
                if ($upload){
                    $data_post['item_url_mpeg'] = $upload['file_name'];
                }
            }
            
            
            //try to upload video file webm (*.webm)
            if(!empty($_FILES['item_url_webm']['name']))
            {
                $upload_webm = $upload_video_cfg;
                $upload_webm['allowed_types'] = 'webm';
                $upload_webm['file_name'] = 'MOVIE_WEBM_'.$id_to_filename.'.webm';
                $upload = $this->items->my_upload('item_url_webm',$upload_webm,$upload_err,TRUE);
                if ($upload){
                    $data_post['item_url_webm'] = $upload['file_name'];
                }else{
                    $this->session->set_flashdata('error', $upload_err);
                }
            }
            
            //try to upload video file ogg (*.ogg)
            if(!empty($_FILES['item_url_ogg']['name']))
            {
                $upload_ogg = $upload_video_cfg;
                $upload_ogg['allowed_types'] = 'ogv';
                $upload_ogg['file_name'] = 'MOVIE_OGG_'.$id_to_filename.'.ogv';
                $upload = $this->items->my_upload('item_url_ogg',$upload_ogg,$upload_err,TRUE);
                if ($upload){
                    $data_post['item_url_ogg'] = $upload['file_name'];
                }else{
                    $this->session->set_flashdata('error', $upload_err);
                }
            }
            
            //try to upload thumbnail
            if(!empty($_FILES['item_thumbnail']['name']))
            {
                //$upload_config_thumb = $this->items->upload_config_thumbnail;
                
                $upload_config_thumb['upload_path'] = SITE_PATH.$upload_config_thumb['upload_path'];
                $upload_config_thumb['file_name'] = 'MOVIE_THUMB_'.$id_to_filename.'.jpg';
                $upload_thumb = $this->items->my_upload('item_thumbnail',$upload_config_thumb,$upload_err,TRUE);

                if ($upload_thumb){
                    $data_post['item_thumbnail'] = $upload_thumb['file_name'];
                    //need resize ?
                    
                    if ($upload_thumb['image_width']!=$this->items->thumb_width||$upload_thumb['image_height']!=$this->items->thumb_height){
                        $config_thumb = $this->items->config_thumb_resize;
                        $config_thumb['source_image'] = $upload_thumb['full_path'];
                        $this->items->image_manipulation($config_thumb);
                    }
                }
            }
            
            //save into database
            if (count($data_post)){
                if ($this->items->save($data_post, $id)){
                    $this->session->set_flashdata('error','Upload done and save into database succefully!');
                }else{
                    $this->session->set_flashdata('error','Failed to save upload file into database!');
                }
                
            }
            
            redirect('cms/movie/items/'.$category_name);
        }
        $this->data['retUrl'] = site_url('cms/movie/items');
        $this->data['page_title'] = 'Upload Movie Videos and Cover Image';
        $this->data['item'] = $this->items->get($id, TRUE);
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/items/upload';
        $this->load->view('cms/_layout_main', $this->data);
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

//added 30/07/2013

//feature
    public function featured(){
        $this->data['page_title'] = 'Movie Featured';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/featured/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function featured_edit($id=NULL){
        //load model music featured
        $this->load->model($this->channel_name.'/subcategory');
        
        // Set form
        $rules = $this->subcategory->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->subcategory->array_from_post(array('name'));    
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie/featured';
            
            if ($this->subcategory->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie featured - Edit':'Movie featured - New';
        
        //load data to edit
        if ($id)
            $data = $this->subcategory->get($id, TRUE);
        else
            $data = $this->subcategory->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie/featured');
        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/featured/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function featured_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/subcategory');
            $this->subcategory->delete($id);
        }
        
        redirect('cms/movie/featured');
    }

//city

    public function city(){
        $this->data['page_title'] = 'Movie City';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/city/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function city_edit($id=NULL){
        //load model music featured
        $this->load->model($this->channel_name.'/city');
        
        // Set form
        $rules = $this->city->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->city->array_from_post(array('name'));    
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie/city';
            
            if ($this->city->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie city - Edit':'Movie city - New';
        
        //load data to edit
        if ($id)
            $data = $this->city->get($id, TRUE);
        else
            $data = $this->city->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie/city');
        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/city/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function city_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/city');
            $this->city->delete($id);
        }
        
        redirect('cms/movie/city');
    }

//theater
    public function theater()
    {
        $this->data['page_title'] = 'Movie theater';
        
        //load model category
        $this->load->model($this->channel_name.'/city');
        
        $this->data['city'] = $this->city->get();
        //create dropdown category
        $options = array();
        foreach($this->data['city'] as $item){
            //create dropwn options
            $options [$item->id] = $item->name;
        }
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/theater/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function theater_edit($id=NULL){
        //load model music featured
        $this->load->model($this->channel_name.'/theater');
        
        // Set form
        $rules = $this->theater->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->theater->array_from_post(array('type','city_id','name','Address','phone'));    
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie/theater';
            
            if ($this->theater->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie theater - Edit':'Movie theater - New';
        
        //load data to edit
        if ($id)
            $data = $this->theater->get($id, TRUE);
        else
            $data = $this->theater->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie/theater');
        //get city dropdown
        $this->load->model($this->channel_name.'/city');
        $result = $this->city->get();
        $city = array();
        foreach ($result as $item){
            $city [$item->id] = $item->name;
        }
        $this->data['city'] = $city;

        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/theater/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function theater_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/theater');
            $this->theater->delete($id);
        }
        
        redirect('cms/movie/theater');
    }


//schedule

    public function schedule()
    {
        $this->data['page_title'] = 'Movie schedule';
        
        //load model category
        $this->load->model($this->channel_name.'/city');
        
        $this->data['city'] = $this->city->get();

        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/schedule/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function schedule_edit($id=NULL){
        //load model music featured
        $this->load->model($this->channel_name.'/schedule');
        $this->load->model($this->channel_name.'/city');
        
        // Set form
        $rules = $this->schedule->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->schedule->array_from_post(array('theater_id','city_id','item_id','schedule_date','schedule_time'));
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie/schedule';
            
            if ($this->schedule->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie schedule - Edit':'Movie schedule - New';
        
        //load data to edit
        if ($id)
            $data = $this->schedule->get($id, TRUE);
        else
            $data = $this->schedule->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie/schedule');
        //get city dropdown
        $this->load->model($this->channel_name.'/city');
        $this->data['city'] = $this->city->get();
        $options = array();
        $option[''] = 'Pilih';
        foreach($this->data['city'] as $item){
            //create dropwn options
            $options [$item->id] = $item->name;
        }
        $this->data['options'] = $options;

        $this->load->model($this->channel_name.'/category');
        $this->data['category'] = $this->category->get();
        $options = array();
        $option[''] = 'Pilih';
        foreach($this->data['category'] as $item){
            //create dropwn options
            $options [$item->category_name] = $item->category_title;
        }
        $this->data['options1'] = $options;

        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/schedule/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function schedule_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/schedule');
            $this->schedule->delete($id);
        }
        
        redirect('cms/movie/schedule');
    }

    function schedule_get_theater(){
        $this->load->model('movie/theater');
        $city_id = $this->input->post('city_id');
        $theaters = $this->theater->get_select_where('city_id, name, id', array('city_id'=>$city_id));
        $data .= "<option value=''>Select</option>";
        foreach ($theaters as $th){
            $data .= "<option value='".$th->id."'>".$th->name."</option>\n";  
        }
        echo $data;
    }

    function schedule_get_movie(){
        $this->load->model('movie/items');
        $categories = $this->input->post('categories');
        $like = array('field'=>'categories', 'value'=>$categories,'position'=>'both');
        $ctg = $this->items->get_like($like,'categories, item_name, id', 0, 20);
        $data .= "<option value=''>Select</option>";
        foreach ($ctg as $th){
            $data .= "<option value='".$th->id."'>".$th->item_name."</option>\n";  
        }
        echo $data;
    }


//source


    public function source(){
        $this->data['page_title'] = 'Movie source';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/source/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function source_edit($id=NULL){
        //load model music source
        $this->load->model($this->channel_name.'/source');
        
        // Set form
        $rules = $this->source->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->source->array_from_post(array('name', 'alias'));    
            $data_post['name'] = url_title($data_post['name'], '', TRUE);
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie/source';
            
            if ($this->source->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie source - Edit':'Movie source - New';
        
        //load data to edit
        if ($id)
            $data = $this->source->get($id, TRUE);
        else
            $data = $this->source->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie/source');
        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/source/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function source_delete($id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/source');
            $this->source->delete($id);
        }
        
        redirect('cms/movie/source');
    }

    public function unique_source_name(){
        $this->load->model($this->channel_name.'/source');
        
        //do not validate if exist
        //Unless it is the current record
        $id = $this->uri->segment(4);
        $new_name = $this->input->post('name');
        $this->db->where('name', url_title($new_name,'',TRUE));
        !$id || $this->db->where('id !=', $id);
        
        $found = $this->source->get();
        if (count($found)){
            $this->form_validation->set_message('unique_source_name','%s already exists!');
            
            return FALSE;
        }
        
        return TRUE;
    }


//rating

    public function items_rating(){
        $this->data['page_title'] = 'Item Rating';
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/rating/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function rating_edit($item_id, $id=NULL){
        //load model music featured
        $this->load->model($this->channel_name.'/rating');
        
        // Set form
        $rules = $this->rating->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->rating->array_from_post(array('item_id','source_id','source_link','rating'));
            $data_post['source_id'] = url_title($data_post['source_id'], '', TRUE);
            $data_post['item_id'] = $this->uri->segment(4);    
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/movie/items_rating'.$this->uri->segment(4);
            
            if ($this->rating->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $id ? 'Movie rating - Edit':'Movie rating - New';
        
        //load data to edit
        if ($id)
            $data = $this->rating->get($id, TRUE);
        else
            $data = $this->rating->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/movie/items_rating/'.$this->uri->segment(4));
        //get city dropdown
        $this->load->model($this->channel_name.'/source');
        $result = $this->source->get();
        $source = array();
        foreach ($result as $item){
            $source [$item->id] = $item->name;
        }
        $this->data['source'] = $source;

        $this->data['data'] = $data;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/rating/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function rating_delete($item_id, $id=NULL){
        if ($id){
            //load model music category
            $this->load->model($this->channel_name.'/rating');
            $this->rating->delete($id);
        }
        
        redirect('cms/movie/items_rating/'.$this->uri->segment(4));
    }


    public function unique_source_id(){
        $this->load->model($this->channel_name.'/rating');
        
        //do not validate if exist
        //Unless it is the current record
        $id = $this->uri->segment(4);
        $new_source_id = $this->input->post('source_id');
        $this->db->where('source_id', url_title($new_source_id,'',TRUE));
        !$id || $this->db->where('id !=', $id);
        
        $found = $this->rating->get();
        if (count($found)){
            $this->form_validation->set_message('unique_source_id','%s already exists!');
            
            return FALSE;
        }
        
        return TRUE;
    }

    


}

?>
