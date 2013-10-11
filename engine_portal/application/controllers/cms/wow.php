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
    
	//wow category
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
            $data_post = $this->category->array_from_post(array('category_name','category_title','synopsis_category','content_preview'));
            $data_post['category_name'] = url_title($data_post['category_name'], '', TRUE);
            
            //try to upload icon
            $upload_message_ico = '';
            $upload_config_ico = $this->category->upload_config_icon;
            $upload_config_ico['upload_path'] = SITE_PATH.$upload_config_ico['upload_path'];
            $upload_config_ico['file_name'] = 'WOW_ICON_CAT_'.time().'.jpg';
            $upload_ico = $this->category->my_upload('icon',$upload_config_ico, $upload_message_ico);
            if ($upload_ico){
                $data_post['icon_preview'] = $upload_ico['file_name'];
            }

            //try to upload image
            $upload_message_img = '';
            $upload_config_img = $this->category->upload_config_image;
            $upload_config_img['upload_path'] = SITE_PATH.$upload_config_img['upload_path'];
            //$upload_config_thumb['upload_path'] = config_item('userfiles').'wow/banner/';
            $upload_config_img['file_name'] = 'WOW_IMAGE_CAT_'.time().'.jpg';
            $upload_img = $this->category->my_upload('image',$upload_config_img, $upload_message_img);
            if ($upload_img){
                $data_post['image_preview'] = $upload_img['file_name'];
            }

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
    
	//wow items
    public function items() {
        $this->data['page_title'] = 'Wow Items';

        //load model event
        $this->load->model($this->channel_name.'/wow_event_m');
        
        //create dropdown event
        $this->data['event'] = $this->wow_event_m->get();
        
        $options = array();
        foreach($this->data['event'] as $item):
            //create dropdown options
            $options [$item->id] = $item->name;
        endforeach;
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
            $data_post = $this->items->array_from_post(array('event_id','item_name','item_description','approved')); 
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
                        'event_id'          =>  1,
                        'item_name'         =>  '',
                        'item_type'         => 'movie',
                        'item_url'          =>  '',
                        'item_description'  =>  '',
                        'item_thumbnail'    =>  '',
                        'approved'          =>  0
                    )
            );
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/items');

        //create dropdown list event
        $this->load->model($this->channel_name.'/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach($result as $item):
            $list_event [$item->id] = $item->name;
        endforeach;
        $this->data['list_event'] = $list_event;
                
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
    
	//wow like
    public function like() {
        $this->data['page_title'] = 'Wow Likes';
        
        //load model category
        $this->load->model($this->channel_name.'/category');

        $this->data['category'] = $this->category->get();

        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/like/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function like_delete($item_id=NULL,$id=NULL){
        if ((!$item_id) || (!$id)){
            redirect('cms/wow/like');
        }

        //get item_like_count by id
        $this->load->model($this->channel_name.'/items');
        $like_count = $this->items->get($item_id,true)->item_like_count;
        $like_now = $like_count - 1;

        //update item_like_count
        $this->db->query("UPDATE uz_wow_items SET item_like_count=$like_now WHERE id = $item_id;");

        //load model wow like list
        $this->load->model($this->channel_name.'/like_list');
        $this->like_list->delete($id);
        
        redirect('cms/wow/like_detail/'.$item_id);
    }

    public function like_detail($item_id=NULL){
        if(!$item_id){
            redirect('cms/wow/like');
        }
        //load model item
        $this->load->model($this->channel_name.'/items');
        //get item_name by item_id
        $item_name = $this->items->get($item_id, TRUE)->item_name;

        $this->data['page_title'] = 'Wow Like List';
        $this->data['item_name'] = $item_name;
        $this->data['item_id'] = $item_id;

        //load model like_list
        $this->load->model($this->channel_name.'/like_list');

        //get like list by item_id
        $where = array('item_id'=>$item_id);
        $this->data['like_list'] = $this->like_list->get_select_where('*', $where);

        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/like/like_detail';
        $this->load->view('cms/_layout_main', $this->data);
    }
	
	//wow static_content
    public function static_content(){
        $this->data['page_title'] = 'Wow Static Content';
        
        //load model content static
        $this->load->model($this->channel_name.'/content_static');
        
        $this->data['items'] = $this->content_static->get();

        //create dropdown event
        $this->load->model($this->channel_name.'/wow_event_m');
        $today = date('Y-m-d H:i:s');
        $where = array('start_date <= '=>$today, 'stop_date >= '=>$today, 'status'=>1);
        $list_event = $this->wow_event_m->get_select_where('*', $where);
        $options = array();
        foreach($list_event as $event):
            //create dropdown options
            $options[$event->id] = $event->name;
        endforeach;
        $this->data['options'] = $options;

        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/static/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    function static_edit($id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/content_static');
        
        $date = date('Y-m-d H:i:s');

        // Set form
        $rules = $this->content_static->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            $event_id = $this->input->post('event_id');
            // We can continue proccess the form
            $data_post = $this->content_static->array_from_post(array('title','synopsis','content')); 
            $data_post['event_id'] = $event_id;
            $data_post['datetime'] = $date;
            if (!$id){
                //get max value of display_order
                $max_display_order = $this->db->query("SELECT MAX(display_order) AS display_order FROM uz_wow_static WHERE event_id = '$event_id';")->result();
                
                //set display_order for new item
                $data_post['display_order'] = $max_display_order[0]->display_order + 1;
            }

            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/static_content';
            
            if ($this->content_static->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        }

        //set page title
        $this->data['page_title'] = $id ? 'Wow Static Content - Edit':'Wow Static Content - New';
        
        //load data to edit
        if ($id)
            $data = $this->content_static->get($id, TRUE);
        else
            $data = $this->content_static->get_new(
                    array(
                        'title'         =>  '',
                        'synopsis'      =>  '',
                        'content'       =>  '',
                        'event_id'      =>  1
                    )
            );
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/static_content');
        
        //get event for dropdown
        $this->load->model($this->channel_name.'/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach ($result as $item){
            $list_event [$item->id] = $item->name;
        }
        $this->data['list_event'] = $list_event;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/static/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function static_delete($id=NULL){
        if ($id){
            //load model content static wow
            $this->load->model($this->channel_name.'/content_static');
            $this->content_static->delete($id);
        }
        
        redirect('cms/wow/static_content');
    }
    
	//wow event
    public function event() {
        $this->data['page_title'] = 'Wow Event';
        
        //load model category
        $this->load->model($this->channel_name.'/category');

        $this->data['category'] = $this->category->get();

        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/event/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    function event_edit($category_id=NULL,$event_id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/wow_event_m');
        
        // Set form
        $rules = $this->wow_event_m->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
			$this->load->helper('date');
			$retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/event';
            // We can continue proccess the form
            $data_post = $this->wow_event_m->array_from_post(array('name','category_id','allowed_movie_type','max_movie_size'));
			$startdate = $this->input->post('start_date').' 00:00:00';
			$stopdate = $this->input->post('stop_date').' 23:59:59';
			$start = human_to_unix($startdate);
			$stop = human_to_unix($stopdate);
			$td = $stop - $start;
			
			//if positive value = true
			if($td < 0){
				$this->session->set_flashdata('error','Pemilihan Tanggal salah.');
				redirect('cms/wow/event_edit');
			}
			$data_post['start_date'] = $startdate;
			$data_post['stop_date'] = $stopdate;
			$slug = $this->input->post('slug');
			$data_post['slug'] = $slug;
				
			//try to upload small
			$upload_message_small = '';
			$upload_config_small = $this->wow_event_m->upload_config_imgsmall;
			$upload_config_small['upload_path'] = SITE_PATH.$upload_config_small['upload_path'];
			$upload_config_small['file_name'] = $slug.'_small.jpg';
			$upload_small = $this->wow_event_m->my_upload('image_small',$upload_config_small, $upload_message_small);
			if ($upload_small){
				$data_post['image_small'] = $upload_small['file_name'];
			}

			//try to upload big
			$upload_message_big = '';
			$upload_config_big = $this->wow_event_m->upload_config_imgbig;
			$upload_config_big['upload_path'] = SITE_PATH.$upload_config_big['upload_path'];
			$upload_config_big['file_name'] = $slug.'_big.jpg';
			$upload_big = $this->wow_event_m->my_upload('image_big',$upload_config_big, $upload_message_big);
			if ($upload_big){
				$data_post['image_big'] = $upload_big['file_name'];
			}
				
			if ($this->wow_event_m->save($data_post, $event_id) == TRUE) {
				redirect($retUrl);
				exit;
			} else{
				$this->session->set_flashdata('error','Failed to save new update');
			}
        }
        
        //set page title
        $this->data['page_title'] = $event_id ? 'Wow Item - Edit':'Wow Item - New';
        
        //load data to edit
        if ($event_id)
            $data = $this->wow_event_m->get($event_id, TRUE);
        else
            $data = $this->wow_event_m->get_new(
                    array(
                        'name'                  =>  '',
                        'slug'                  =>  '',
                        'start_date'            =>  '',
                        'stop_date'             =>  '',
                        'allowed_movie_type'    =>  '',
                        'max_movie_size'        =>  0,
                        'category_id'           =>  1,
                        'image_small'           =>  '',
                        'image_big'             =>  ''
                    )
            );
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/event');

        //create dropdown list event
        $this->load->model($this->channel_name.'/category');
        $result = $this->category->get();
        $options = array();
        foreach($result as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/event/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function event_delete($id=NULL){
        if($id){
            //load model wow_event_m
            $this->load->model($this->channel_name.'/wow_event_m');
            $this->wow_event_m->delete($id);
        }
        redirect('cms/wow/event');
    }
	
	//wow event_field
    public function event_field(){
        $this->data['page_title'] = 'Wow Event Field';
        
        //load model category
        $this->load->model($this->channel_name.'/category');

        $this->data['category'] = $this->category->get();

        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/event_field/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    function event_field_edit($id=NULL){
        //load model wow event_field
        $this->load->model($this->channel_name.'/event_field');
        
        //$date = date('Y-m-d H:i:s');

        // Set form
        $rules = $this->event_field->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            $event_id = $this->input->post('event_id');
            // We can continue proccess the form
            $data_post = $this->event_field->array_from_post(array('event_field','event_id')); 

            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/event_field';
            
            if ($this->event_field->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        }

        //set page title
        $this->data['page_title'] = $id ? 'Wow Event Field - Edit':'Wow Event Field - New';
        
        //load data to edit
        if ($id)
            $data = $this->event_field->get($id, TRUE);
        else
            $data = $this->event_field->get_new(
                    array(
                        'event_field'   =>  '',
                        'event_id'      =>  1
                    )
            );
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/event_field');
        
        //get event for dropdown
        $this->load->model($this->channel_name.'/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach ($result as $item){
            $list_event [$item->id] = $item->name;
        }
        $this->data['list_event'] = $list_event;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/event_field/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function event_field_delete($id=NULL){
        if ($id){
            //load model event field & event_fieldvalue
            $this->load->model($this->channel_name.'/event_field');
            $this->load->model($this->channel_name.'/items_field');

            //check jika ada data pada uz_wow_item_fieldvalue dengan id_event_field ($id)
            $where = array('id_event_field'=>$id);
            $check = $this->items_field->get_count($where);

            if($check > 0){
                $this->session->set_flashdata('error','Masih Terdapat Items Field Value Pada Event Field ini.');
                redirect('cms/wow/event_field');
            } else {
                $this->event_field->delete($id);
            }
        }
        
        redirect('cms/wow/event_field');
    }


    //wow banner
    public function banner(){
        $this->data['page_title'] = 'Wow Banner';
        
        //load model category
        $this->load->model($this->channel_name.'/category');

        $this->data['category'] = $this->category->get();

        //create dropdown category
        $options = array();
        $options[0] = "Front End";
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/banner/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
	
	public function banner_edit($event_id=NULL,$id=NULL){
        //load model wow banner
        $this->load->model($this->channel_name.'/banner');

        // Set form
        $rules = $this->banner->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->channel_m->array_from_post(array('event_id','hyperlink','title','image_alt','banner_text'));
            //check start_date & stop_date
            $this->load->helper('date');
            $startdate = $this->input->post('start_date').' '.date('H:i:s');
            $stopdate = $this->input->post('stop_date').' '.date('H:i:s');
            $start = human_to_unix($startdate);
            $stop = human_to_unix($stopdate);
            $td = $stop - $start;
            
            //if positive value = true
            if($td < 0){
                $this->session->set_flashdata('error','Pemilihan Tanggal salah.');
                if($id){
                    redirect('cms/wow/banner_edit/'.$event_id.'/'.$id);
                } else {
                    redirect('cms/wow/banner_edit');    
                }
            }
            $data_post['start_date'] = $this->input->post('start_date');
            $data_post['stop_date'] = $this->input->post('stop_date');

            //try to proccess upload if exists
            //try to upload thumbnail
            $upload_message_thumb = '';
            $upload_config_thumb = $this->banner->upload_config_thumbnail;
            $upload_config_thumb['upload_path'] = SITE_PATH.$upload_config_thumb['upload_path'];
            //$upload_config_thumb['upload_path'] = config_item('userfiles').'wow/banner/';
            $upload_config_thumb['file_name'] = 'WOW_BANNER_'.time().'.jpg';
            $upload_thumb = $this->banner->my_upload('banner',$upload_config_thumb, $upload_message_thumb);
            if ($upload_thumb){
                $data_post['image'] = $upload_thumb['file_name'];
            }

            if ($this->banner->save($data_post, $id) == TRUE) {
                redirect('cms/wow/banner');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        }

        //set page title
        $this->data['page_title'] = $id ? 'Wow Banner - Edit':'Wow Banner - New';
        
        //load data to edit
        if ($id)
            $data = $this->banner->get($id, TRUE);
        else
            $data = $this->banner->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/banner');
        
        //get event for dropdown
        $this->load->model($this->channel_name.'/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach ($result as $item){
            $list_event [$item->id] = $item->name;
        }
        $this->data['list_event'] = $list_event;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/banner/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function banner_delete($id=NULL){
        if($id) {
            $this->load->model('wow/banner');
            $this->banner->delete($id);
        }
        redirect('cms/wow/banner');
    }

    //event_filedvalue
    public function item_field_value(){
        $this->data['page_title'] = 'Wow Item Field Value';
        
        //load model category
        $this->load->model($this->channel_name.'/category');

        $this->data['category'] = $this->category->get();

        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/field_value/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function item_field_value_edit($event_id=NULL,$item_id=NULL){
        if((!$event_id) && (!$item_id)) {
            redirect('cms/wow/item_field_value');
        }

        //load model wow event_field
        $this->load->model($this->channel_name.'/event_field');
        //get event_field by event_id
        $where = array('event_id'=>$event_id);
        $fields = $this->event_field->get_select_where('*', $where);

        //load model wow items_field
        $this->load->model($this->channel_name.'/items_field');

        // Set form
        $rules = $this->items_field->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            $fieldvalue = $this->input->post('fieldvalue');

            $loop = 0;
            $status = 0;
            foreach($fields as $field){
                $data_post = array();
                $data_post['id_event_field'] = $field->id_event_field;
                $data_post['fieldvalue'] = $fieldvalue[$loop];
                $data_post['id_items'] = $item_id;

                //get id_fieldvalue (id_fv) by item_id
                $where = array('id_items'=>$item_id,'id_event_field'=>$field->id_event_field);
                $id_fv = $this->items_field->get_select_where('id_fieldvalue', $where, TRUE);
                
                if($id_fv){
                    $id = $id_fv->id_fieldvalue;
                } else {
                    $id = NULL;
                }
                $loop++;
                if ($this->items_field->save($data_post, $id) == TRUE){
                    $status++;
                } else {
                    $this->session->set_flashdata('error','Failed to save new update');
                }
            }
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/event_field';

            if ($loop == $status){
                redirect($retUrl);
                exit;
            }
        }
        //set page title
        $this->data['page_title'] = $item_id ? 'Wow Item Field - Edit':'Wow Item Field - New';
        
        //load data to edit
        if (($event_id)&&($item_id)){
            $loop = 0;
            foreach ($fields as $field){
                $where = array('id_event_field'=>$field->id_event_field, 'id_items'=>$item_id);
                $get = $this->items_field->get_select_where('*',$where, TRUE);
                if($get){                    
                    $data[$loop] = $get->fieldvalue;
                } else {
                    $data[$loop] = '';
                }
                $loop++;
            }
        }else{
            $data = $this->items_field->get_new();
        }

        //get item_name by item_id
        $this->load->model($this->channel_name.'/items');
        $this->data['item_name'] = $this->items->get($item_id, TRUE)->item_name;
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/item_field_value');

        $this->data['fields'] = $fields;
        
        //get event for dropdown
        $this->load->model($this->channel_name.'/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach ($result as $item){
            $list_event [$item->id] = $item->name;
        }
        $this->data['list_event'] = $list_event;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/field_value/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function item_field_value_delete($event_id=NULL,$item_id=NULL){
        if (($event_id)&&($item_id)){
            $this->load->model($this->channel_name.'/event_field');
            $this->load->model($this->channel_name.'/items_field');

            //cek data
            $where = array('id_items'=>$item_id);
            $count_data = $this->items_field->get_count($where);

            //load fields by event_id
            $where = array('event_id'=>$event_id);
            $fields = $this->event_field->get_select_where('*', $where);

            foreach($fields as $field){
                //get id_fieldvalue
                $where = array('id_event_field'=>$field->id_event_field,'id_items'=>$item_id);
                $id_fv = $this->items_field->get_select_where('*', $where, TRUE)->id_fieldvalue;
                $this->items_field->delete($id_fv);
            }
            //load model wow items_field
        }
        
        redirect('cms/wow/item_field_value');
    }
	
	//wow genre
	public function genre(){
        $this->data['page_title'] = 'Wow Genre';
        
        //load model category
        $this->load->model($this->channel_name.'/category');

        $this->data['category'] = $this->category->get();

        //create dropdown category
        $options = array();
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/genre/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
	
	public function genre_edit($id=NULL){
        //load model wow event_field
        $this->load->model($this->channel_name.'/genre');
		
        // Set form
        $rules = $this->genre->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $data_post = $this->genre->array_from_post(array('name','id_category')); 

            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/genre';
            
            if ($this->genre->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        }

        //set page title
        $this->data['page_title'] = $id ? 'Wow Event Field - Edit':'Wow Event Field - New';
        
        //load data to edit
        if ($id)
            $data = $this->genre->get($id, TRUE);
        else
            $data = $this->genre->get_new(
                    array(
                        'name'			=>  '',
                        'id_category'	=>  1
                    )
            );
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/genre');
        
        //create dropdown category
		$this->load->model($this->channel_name.'/category');
		$this->data['category'] = $this->category->get();
        $options = array();
        foreach($this->data['category'] as $item):
            $options [$item->category_id] = $item->category_title;
        endforeach;
        $this->data['options'] = $options;
                
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/genre/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
	
	public function genre_delete($id=NULL){
        if($id) {
            $this->load->model($this->channel_name.'/genre');
            $this->genre->delete($id);
        }
        redirect('cms/wow/genre');
    }

    public function profile_jury() {
        $this->data['page_title'] = 'Profile Jury';
        
        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/profile_jury/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function jury_delete($id=NULL){
        if($id) {
            $this->load->model($this->channel_name.'/user_m');
            $this->user_m->delete($id);
        }
        redirect('cms/wow/profile_jury');
    }

    public function jury_edit($user_id=NULL){
        //load model music category
        $this->load->model($this->channel_name.'/jury');
        
        // Set form
        $rules = $this->jury->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->jury->array_from_post(array('sure_name','occupation','facebook_id','tweeter_id','avatar',
                                                                'age','creation','motto','description','create_date'));

            //try to upload image
            $upload_message_thumb = '';
            $upload_config_thumb = $this->jury->upload_config_thumbnail;
            $upload_config_thumb['upload_path'] = SITE_PATH.$upload_config_thumb['upload_path'];
            $upload_config_thumb['file_name'] = 'AVATAR_'.time().'.jpg';
            $upload_thumb = $this->jury->my_upload('avatar',$upload_config_thumb, $upload_message_thumb);
            if ($upload_thumb){
                $data_post['avatar'] = $upload_thumb['file_name'];
            }


            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/wow';
            
            if ($this->jury->save($data_post, $user_id) == TRUE) {
                redirect($retUrl);
                exit;
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        //set page title
        $this->data['page_title'] = $user_id ? 'Profile Jury - Edit':'Profile Jury - New';
        
        //load data to edit
        if ($user_id)
            $data = $this->jury->get($user_id, TRUE);
        else
            $data = $this->jury->get_new();
        
        //set data in form
        $this->data['retUrl'] = site_url('cms/wow/profile_jury');
        $this->data['data'] = $data;

        $this->data['subview'] = 'cms/channels/'.$this->channel_name.'/profile_jury/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    //news pindahan dari eventorg.php
    public function news(){
        //load model event
        $this->load->model($this->channel_name.'/wow_event_m');

        $this->data['event'] = $this->wow_event_m->get();

        //create dropdown event
        $options = array();
        foreach($this->data['event'] as $item):
            $options [$item->id] = $item->name;
        endforeach;
        $this->data['options'] = $options;

        //create dropdown type news (static)
        //list type - statis
        $list_type = array(1=>'News',2=>'RoadShow',3=>'Appetisers');
        $this->data['list_type'] = $list_type;

        $this->data['page_title'] = 'Wow News';
        $this->data['subview'] = 'cms/channels/wow/news/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function news_edit($id=NULL){
        //load model wow news_m
        $this->load->model('news_m');

        // Set form
        $rules = $this->news_m->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $data_post = $this->news_m->array_from_post(array('item_id','news_title','news_text','type','is_active')); 
            $data_post['news_datetime'] = $this->input->post('news_datetime').' '.date('H:i:s');
            $data_post['news_by'] = $this->session->userdata('userid');
            $data_post['channel_name'] = 'wow';

            //try to upload video
            $upload_message_video = '';
            $upload_config_file = $this->news_m->upload_video;
            $upload_config_file['upload_path'] = SITE_PATH.$upload_config_file['upload_path'];
            $upload_config_news['file_name'] = 'WOW_NEWS_'.time().'.jpg';
            $upload_file = $this->news_m->my_upload('video',$upload_config_file, $upload_message_video);
            if ($upload_file){
                $data_post['video_path'] = $upload_file['file_name'];
            }

            //try to upload news
            $upload_message_news = '';
            $upload_config_news = $this->news_m->upload_config_news_wow;
            $upload_config_news['upload_path'] = SITE_PATH.$upload_config_news['upload_path'];
            //$upload_config_thumb['upload_path'] = config_item('userfiles').'wow/banner/';
            $upload_config_news['file_name'] = 'WOW_NEWS_'.time().'.jpg';
            $upload_news = $this->news_m->my_upload('image',$upload_config_news, $upload_message_news);
            if ($upload_news){
                $data_post['img_path'] = $upload_news['file_name'];
            }

            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/wow/news';
            
            if ($this->news_m->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        }

        //set page title
        $this->data['page_title'] = $id ? 'Wow News - Edit':'Wow News - New';
        
        //load data to edit
        if ($id)
            $data = $this->news_m->get($id, TRUE);
        else
            $data = $this->news_m->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/wow/news');

        //get event for dropdown
        $this->load->model('wow/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach ($result as $item){
            $list_event [$item->id] = $item->name;
        }
        $this->data['list_event'] = $list_event;

        //list type - statis
        $list_type = array(1=>'News',2=>'RoadShow',3=>'Appetisers');
        $this->data['list_type'] = $list_type;

        $this->data['subview'] = 'cms/channels/wow/news/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function news_delete($id=NULL){
        if($id) {
            $this->load->model('news_m');
            $this->news_m->delete($id);
        }
        redirect('cms/wow/news');
    }
}
?>
