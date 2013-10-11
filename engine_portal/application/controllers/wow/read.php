<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */
//comment by maulana
class Read extends U_Controller {
    
    protected $_channel_name = 'wow';

    function __construct() {
        parent::__construct();   
        $this->data['is_loggedin'] = $this->user_m->is_loggedin()?'yes':'no';
        $this->load->model('wow/wow_event_m');
        $this->data['wizard_events'] = $this->wow_event_m->get();
           
        //load wow categories
        $this->load->model('wow/category');
        $this->data['categories'] = $this->category->get();
        $this->data['wow_news'] = $this->db->query("select * from uz_channel_news where channel_name = 'wow' and type = 1 and is_active=1 ORDER BY news_datetime DESC LIMIT 0 , 2");
        $this->data['themes'] = 'guitar';
        
    }

    public function index($id=NULL){
        if($id == NULL) {
            redirect('wow/channel');
        }

        $this->data['id_active'] = $id;
        
        $this->load->model($this->_channel_name.'/content_static');
        $this->load->model($this->_channel_name.'/wow_event_m');
		
		$this->load->model($this->_channel_name.'/jury');
		$this->load->model($this->_channel_name.'/news');
        //$where = array("id"=>$id);
        
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event):
            $where = array('event_id'=>$event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;
        

        //load item static
        $static_item = $this->content_static->get($id, TRUE);
        $this->data['item'] = $static_item;

        $event_id = $static_item->event_id;

        //get category name by cat_id
        $event_active = $this->wow_event_m->get($event_id);
        $this->data['category_name'] = $event_active->name;
		$this->data['get_event_id'] = $event_id;
		

        //load left menu
        $where = array('event_id' => $event_id, 'is_active'=>1);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;
		
		$datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
		$this->data['list_jury'] = $datajury;
		
		$tbl_news = $this->news->get_tablename();
		$datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
		
		//$this->data['wizard_events'] = $this->wow_event_m->get();
		/*
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/read';
        $this->load->view('_layout_main', $this->data);*/
        //$this->load->view('channel/wow/level2', $this->data);
                $this->data['page'] = 'channel/' . $this->_channel_name . '/page/static';
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
    }
    
    public function category($category_id=NULL){
            if($category_id == NULL) {
                redirect('wow/channel');
            }
    
            //$this->data['id_active'] = $id;
            $this->data['id_active'] = 0;
    
            $this->load->model($this->_channel_name.'/category');
            $this->load->model($this->_channel_name.'/wow_event_m');
            $this->load->model($this->_channel_name.'/content_static');
            
            //get all event
            $today = date("Y-m-d H:i:s");
            $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
            $event_active = $this->wow_event_m->get_select_where('*', $where);
            $this->data['event_active'] = $event_active;
            
            $i = 1;
            foreach($event_active as $event):
                $where = array('event_id'=>$event->id, 'is_active'=>1);
                $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
                $i++;
            endforeach;
    
            //get category name
            $category = $this->category->get($category_id, TRUE);
            $this->data['category_title'] = $category->category_title;
    
            //set event name
            $this->data['event_name'] = "Preview";
    
            //get 1 event active by category_id
            $where = array('category_id'=>$category_id, 'status'=>1);
            $event_by_category = $this->wow_event_m->get($where, TRUE);
    
            //load left menu by event active
            $where = array('event_id'=>$event_by_category->id, 'is_active'=>1);
            $this->data['left_menu'] = $this->content_static->get_select_where('*', $where);
    
            //load item preview
            $this->data['content'] = $category->content_preview;

            //$this->load->view('channel/wow/category', $this->data);
            $this->data['themes'] = 'guitar';
            $this->data['page'] = 'channel/' . $this->_channel_name . '/page/category';
            $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
        }

		
		public function tweet(){
		
			$this->load->library('Codebird');
			
			
			$CONSUMER_KEY = '9GIhl9G2uUbfEhy5zbhS7Q';
			$CONSUMER_SECRET = 'K0FOAqFHOpOwhXNHF7DPMLthYq8jz5o3zA6IOB0Ic';
			$ACCESS_TOKEN = '635533660-x6hHKyGLNnKQaguJEeKRmSLlwIFdyUpA6IS4ag6Q';
			$ACCESS_TOKEN_SECRET = 'w4c0vg7nD7fv63jdpUK2444sT6vh10EfbvuyUFx7bqM';

			//Get authenticated
			$this->codebird->setConsumerKey($CONSUMER_KEY, $CONSUMER_SECRET);
			$cb = $this->codebird->getInstance();
			$cb->setToken($ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);


			//retrieve posts
			$q=$this->input->post('q');
			$count = $id=$this->input->post('count');
			$api = $id=$this->input->post('api');


			$params = array(
				'screen_name' => $q,
				'q' => $q,
				'count' => $count
			);

			//Make the REST call
			$data = (array) $cb->$api($params);

			echo json_encode($data);
		}
		
		public function content($content=NULL){
        
        $this->load->model($this->_channel_name.'/content_static');
        $this->load->model($this->_channel_name.'/wow_event_m');
		
		$this->load->model($this->_channel_name.'/jury');
		$this->load->model($this->_channel_name.'/news');
        
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event):
            $where = array('event_id'=>$event->id, "is_active" => 1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;
		
        $datajury = $this->jury->get_offset('*',null,0,2);	
		$this->data['list_jury'] = $datajury;
		
		$tbl_news = $this->news->get_tablename();
		$datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
		
		$this->data['content'] = $content;
        $this->data['themes'] = 'guitar';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/static_content';
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
		}

		public function news($id=NULL){
        if($id == NULL) {
            redirect('wow/channel');
        }

        $this->data['id_active'] = $id;
        
        $this->load->model($this->_channel_name.'/content_static');
        $this->load->model($this->_channel_name.'/wow_event_m');
        
        $this->load->model($this->_channel_name.'/jury');
        $this->load->model($this->_channel_name.'/news');
        //$where = array("id"=>$id);
        
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event):
            $where = array('event_id'=>$event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;
        
        //load item static
        $news_item = $this->news->get($id, TRUE);
        $this->data['item'] = $news_item;

        $event_id = $news_item->item_id;

        //get category name by cat_id
        $event_active = $this->wow_event_m->get($event_id);
        $this->data['event_name'] = $event_active->name;

        //load left menu
        $where = array('event_id' => $event_id, 'is_active'=>1);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;
        
        $datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
        $this->data['list_jury'] = $datajury;
        
        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
        
        //$this->data['wizard_events'] = $this->wow_event_m->get();
        /*
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/read';
        $this->load->view('_layout_main', $this->data);*/
        //$this->load->view('channel/wow/level2', $this->data);
        $this->data['themes'] = 'guitar';
        //$this->data['page'] = 'channel/' . $this->_channel_name . '/page/static';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/news';
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
    }
}
