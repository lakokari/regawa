<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */
class Upload extends U_Controller {
    
    protected $_channel_name = 'wow';

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->load->view('channel/wow/page/upload/form');
    }
    
    public function wizard($step=1){
        
        $view_to_load = 'channel/wow/upload/step-1';
        switch($step){
            case 3: $view_to_load = 'channel/wow/upload/step-3'; break;
            case 2: $view_to_load = 'channel/wow/upload/step-2'; break;
            case 1:
            default: $view_to_load = 'channel/wow/upload/step-1'; break;
        }
        
        $this->load->view($view_to_load);
    }
    
    
    function wizard_loadform($event_id=NULL){

        //get project name by event_id
        $this->load->model('wow/wow_event_m');
        $event = $this->wow_event_m->get($event_id, TRUE);
        
        $category_id = $event->category_id;

        $this->load->model('wow/category');
        $category = $this->category->get($category_id, TRUE);
        $this->data['wow_event_name'] = $category->category_title;

        //load genre
        $this->load->model($this->_channel_name.'/genre');
        $this->data['genres'] = $this->genre->get_select_where('*', array('id_category' => $category_id));

        $this->data['wow_event_id'] = $event_id;

        //load event_field by event id (wow_event)
        $this->load->model('wow/event_field');
        $this->data['fields'] = $this->event_field->get_by(array('event_id'=>$event_id));
        
        //load allowed type
        $this->data['allowed_movie_type'] = $event->allowed_movie_type;

        //max file size
        $max_size_multiply = 1024 * 1024 * 1; // MB
        $this->data['max_file_size'] = $event->max_movie_size>0?$event->max_movie_size * $max_size_multiply: $max_size_multiply ;
        
        //Load syarat dan ketentuan upload / Rules for this event
        //Load model wow_static
        $this->load->model('wow/content_static');
        $rules = $this->content_static->get_by(array('event_id'=>$event_id, 'toc'=>1), TRUE);
		if ($rules)
			$this->data['toc_id'] = $rules->id;
		else
			$this->data['toc_id'] = 0;
        
        $this->load->view('channel/wow/page/upload/wizard_form', $this->data);
    }
    
    function wizard_loadfinish($wow_event=NULL){
        $wow_array = array(
            'wow_event_id' =>  $wow_event
        );
        $this->load->view('channel/wow/page/upload/wizard_finish', $wow_array);
    }

    public function asdindex($id=NULL){
        if($id == NULL) {
            redirect('wow/channel');
        }
        
        $this->load->model($this->_channel_name.'/content_static');
        //$where = array("id"=>$id);
        
        $static_item = $this->content_static->get($id, TRUE);
        $this->data['item'] = $static_item;

        //load category dropdown
        $this->load->model($this->_channel_name.'/wow_event_m');
        $categories = $this->wow_event_m->get();
        $this->data['categories'] = $categories;
        
        $category = $this->wow_event_m->get($static_item->category_id, TRUE);
        $this->data['category'] = $category;
        $this->data['sub'] = $category->slug;
        
        //load model
        $this->load->model($this->_channel_name.'/content_static');
        $this->data['static_menu'] = $this->content_static->get_by(array('category_id'=>$category->id));
        $this->data['category_active_name'] = $category->name;

        $this->data['title_sub'] = $category->name;
        
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/read';
        $this->load->view('_layout_main', $this->data);
    }
}
