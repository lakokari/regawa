<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */

if (!defined('TYPE_VIDEO')){
    define ('TYPE_VIDEO', 'video');
}
if (!defined('TYPE_IMAGE')){
    define ('TYPE_IMAGE', 'image');
}

class Gallery extends U_Controller {
    
    protected $_channel_name = 'wow';

    function __construct() {
        parent::__construct();      
        
        $this->load->helper('cms');
        
        //load wow type
        $this->load->model($this->_channel_name.'/wow_event_m');
        $this->load->model($this->_channel_name.'/news');
        $this->load->model($this->_channel_name.'/content_static');
        $this->load->model($this->_channel_name.'/gallery_category');
        
        $this->data['is_loggedin'] = $this->user_m->is_loggedin()?'yes':'no';
	
        //load wow categories
        $this->data['wow_news'] = $this->db->query("select * from uz_channel_news where channel_name = 'wow' and type = 1 and is_active=1 ORDER BY news_datetime DESC LIMIT 0 , 2");
    }
    
    
    public function index($event_id=2, $page=1){
        $this->load->model($this->_channel_name.'/like_list');
	$this->load->model($this->_channel_name.'/jury');
        $this->load->model($this->_channel_name.'/gallery_items');   
        
        //creating filter standard class
        $filter = new stdClass(); //this variable hold all filtering values;
        //create paging stdclass variable
        $paging = new stdClass();
        
        //ensure event id is valid
		//tambahan
        if (!$event_id || $event_id < 1 || $event_id > 3){
            $event_id = 2;
        }
		/*
        if (!$event_id || $event_id < 2 || $event_id > 3){
            $event_id = 2;
        }
		*/
        $filter->event_id = $event_id;
        
        $this->data['get_event_id'] = $event_id;
        //get event_name
        $event_selected = $this->wow_event_m->get_select_where('*', array('id' => $filter->event_id), TRUE);
        $this->data['event_selected'] = $event_selected;
        $filter->event_name = $event_selected->name;
        
        //get all galery category for selected event
		//tambahan
		if($filter->event_id == 1) {
			$gallery_categories = $this->gallery_category->get_select_where('*', array('event_id !='=>1, 'event_id !='=>0, 'is_active'=>1));
		} else {
			$gallery_categories = $this->gallery_category->get_select_where('*', array('event_id' => $filter->event_id, 'is_active'=>1));
		}
        //$gallery_categories = $this->gallery_category->get_select_where('*', array('event_id' => $filter->event_id, 'is_active'=>1));
        $this->data['gallery_categories'] = $gallery_categories;
                
	
        //$this->data['criteria'] = $criteria;
        
        /********** sorting ***********************/
        $criteria = $this->input->get('criteria', TRUE);
        if (!$criteria || $criteria=='all'){
            $criteria_query = '';
	}else{
            $criteria_query = "  AND (title LIKE '%".urldecode($criteria)."%' OR bodyText LIKE '%".urldecode($criteria)."%' )";
        }
        $filter->criteria = $criteria;
        
        $allowed_order_type = array('asc','desc');
        $date_order = $this->input->get('date', TRUE);
        if (!$date_order || !in_array($date_order, $allowed_order_type)) 
            $date_order = 'desc';
        
        $filter->date_order = $date_order;
        //$this->data['ordertype'] = $order_type;
        
        //get kind
        $allowed_kind = array(TYPE_IMAGE, TYPE_VIDEO);
        $kind = $this->input->get('kind', TRUE); 
        if (!$kind || !in_array($kind, $allowed_kind)) 
            $kind = TYPE_VIDEO; //default is video
        $filter->kind = $kind;
        //$this->data['kind'] = $kind;
        
        //get event gallery selected
        $gallery_category_id = $this->input->get('category', TRUE); if (!$gallery_category_id) $gallery_category_id = NULL;
        $filter->gallery_category_id = $gallery_category_id;
        $filter->gallery_category_name = '';//default is empty
        foreach($gallery_categories as $gal_category){
            if ($gal_category->id == $filter->gallery_category_id){
                $filter->gallery_category_name = $gal_category->category_name;
                break;
            }
        }
                
        //We only use model to get table name
        $table_gallery_item = $this->db->dbprefix($this->gallery_items->get_tablename());
        
        //set up paging
		//tambahan
		if($filter->event_id == 1){
			$sql = 'SELECT COUNT(*) as total_records FROM ' . $table_gallery_item .' WHERE event_id !=0 AND event_id != 1';
		} else {
			$sql = 'SELECT COUNT(*) as total_records FROM ' . $table_gallery_item .' WHERE event_id='. $event_id ;
		}
        //$sql = 'SELECT COUNT(*) as total_records FROM ' . $table_gallery_item .' WHERE event_id='. $event_id ;
        
        //filter kind
        if ($filter->kind == TYPE_VIDEO)
            $sql.=' AND transcoded=1';        
        $sql.= ' AND item_type=\''.$filter->kind.'\'';
        
        //filter gallery category
        if ($filter->gallery_category_id)
            $sql.= ' AND gallery_category_id='. $filter->gallery_category_id;
                
        if (!$page) 
            $page = 1;
        
        $paging->page = $page;
        
        /****************** set base url and base query params ****/
        //setting base url 
        $base_page_url = site_url('wow/gallery/index/'. $event_id); 
        //building full query param
        $query_param = array();
        $query_param ['date'] = $filter->date_order;
        //set the kind
        $query_param ['kind'] = $filter->kind;
        //set the gallery category if defined
        if ($filter->gallery_category_id)
            $query_param ['category'] = $filter->gallery_category_id;
        //set the searching criteria
        if ($filter->criteria && $filter->criteria!='all')
            $query_param ['criteria'] = $filter->criteria;
        /******************************** end of building query param *********/
        
        //filter searching
        if ($filter->criteria && $filter->criteria!='all'){
            $sql.= $criteria_query ;
        }
        

        $query = $this->db->query($sql)->row();
        
        $paging->totalRecords = $query->total_records;
        
        
        
        //Now get requested data 
        $paging->limitPerPage = 10;
        $paging->offset = $paging->page - 1;
        
        if ($paging->totalRecords>0){
            //set up paging
            $paging->totalPages = ceil($paging->totalRecords / $paging->limitPerPage);        
            $paging->start = $paging->offset * $paging->limitPerPage;
            
            $this->data['can_like_dislike'] = $this->user_m->is_loggedin();
            if($filter->event_id == 1){
                $sql = 'SELECT * FROM '. $table_gallery_item . ' WHERE 1';
            } else {
                $sql = 'SELECT * FROM ' . $table_gallery_item .' WHERE event_id='. $event_id ;
            }   
            //filter kind
            if ($filter->kind == TYPE_VIDEO)
                $sql.=' AND transcoded=1';
            $sql.= ' AND item_type=\''.$filter->kind.'\'';
            
            //filter gallery category
            if ($filter->gallery_category_id)
                $sql.= ' AND gallery_category_id='. $filter->gallery_category_id;
        
            //filter searching
            if ($filter->criteria && $filter->criteria!='all')
                $sql.= $criteria_query;
            
            //set order and limit
            $sql .= ' ORDER BY date_time ' . $filter->date_order;
            $sql .= ' LIMIT '. $paging->start .','. $paging->limitPerPage;
            $items_result = $this->db->query($sql)->result();
            //exit(var_dump($items_result));
            $paging->size = count($items_result);
            
            //get table like_list name
            $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
            
            //iterate items to make paging
            $items = array();
            
            foreach($items_result as $item){
                
                //$wow_base_url = config_item('userfiles') .'wow/';
                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()){
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like            
                    $query = 'SELECT COUNT(*) total_like FROM '.$table_likelist.' WHERE user_id='.$userid.' AND item_id='.$item->id;
                    $user_liked = $this->db->query($query)->row()->total_like;
                    if ($user_liked == 0){
                        $user_can_like = TRUE;
                    }
                }
                $item->user_can_like = $user_can_like;
                
                $items [] = $item;
            }
            
            
            
            $this->data['items'] = $items;
                        
            //setting pagination
            $jsClick = $base_page_url .'/$' . '?' . http_build_query($query_param);
            
            
            //create pagination
            $this->data['pagination'] = smart_paging_js($paging->totalPages, $page, $jsClick, 7, '$');
            
        }else{
            $this->data['items'] = array();
            $this->data['pagination'] = '';
        }
		
	$this->data['filter'] = $filter;
        $this->data['paging'] = $paging;
        
       
        /******** set base url for button sort *********/
            
        $base_page_url .= '/'. $page;
        $base_url = new stdClass();
        //base url for date
        $date_thumb_qp = $query_param;
        if ($filter->date_order=='asc')
            $date_thumb_qp['date'] = 'desc';
        else
            $date_thumb_qp['date'] = 'asc';
        $base_url->date = $base_page_url . '?'. http_build_query($date_thumb_qp);

        //base url for kind
        $kind_thumb_qp = $query_param;
        unset($kind_thumb_qp['kind']);
        $base_url->kind = $base_page_url . '?'. http_build_query($kind_thumb_qp);

        //base url for category
        $category_thumb_qp = $query_param;
        unset($category_thumb_qp['category']);
        $base_url->category = $base_page_url . '?'. http_build_query($category_thumb_qp);

        $this->data['base_url_thumb'] = $base_url;
            
        //these lines bellow for header
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event){
            $where = array('event_id'=>$event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            $i++;
        }
        
        
        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;
		
        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3, 'is_active'=>1))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
               
        
        //$this->load->view('channel/'.$this->_channel_name.'/gallery_all', $this->data);
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/gallery/index';
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
    }
    
    public function detail($galery_type=TYPE_VIDEO, $gallery_item_id=NULL){
        if (!$gallery_item_id){
            redirect('wow/gallery');
        }
        
        if ($galery_type==TYPE_VIDEO){
            $this->_detail_video($gallery_item_id);
        }else{
            $this->gallery_album($gallery_item_id, 1);
        }
    }
    
    protected function _detail_video($gallery_item_id){
        $this->load->model($this->_channel_name.'/gallery_items');
        $this->load->model($this->_channel_name.'/gallery_item_detail');
        
        //get detail of gallery item
        $gallery_item = $this->gallery_items->get($gallery_item_id, TRUE);
        
        if (!$gallery_item)
            redirect ('wow/gallery');
        
	
        $this->data['gallery_item'] = $gallery_item;
        $this->data['event_id'] = $gallery_item->event_id;
        
        $this->load->model($this->_channel_name.'/wow_event_m');
        $event_item = $this->wow_event_m->get_by(array('id'=>$gallery_item->event_id), TRUE);
        $this->data['event_item'] = $event_item;        
        
        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
	

        $this->load->model($this->_channel_name.'/content_static');
        
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event):
            $where = array('event_id'=>$event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;
        

        $left_menu = $this->content_static->get_select_where('*', array('event_id' => $gallery_item->event_id));
        $this->data['left_menu'] = $left_menu;
        
        //Load basic layout
        //$this->load->view('channel/'.$this->_channel_name.'/gallery_detail', $this->data);
        $this->data['themes'] = 'camera';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/gallery/detail';
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
    }
    
    public function gallery_album($gallery_item_id=NULL, $page=1){
        if (!$gallery_item_id){
            redirect('wow/gallery');
        }
        
        $this->load->model($this->_channel_name.'/like_list');
        $this->load->model($this->_channel_name.'/gallery_items');
        $this->load->model($this->_channel_name.'/gallery_item_detail');
        
        //creating filter standard class
        $filter = new stdClass(); //this variable hold all filtering values;
        //create paging stdclass variable
        $paging = new stdClass();
        
        
        //get gallery cateory item selected
        $gallery_item = $this->gallery_items->get($gallery_item_id, TRUE);
        if (!$gallery_item){
            redirect('wow/gallery');
        }
        $this->data['gallery_item'] = $gallery_item;
        
        $filter->event_id = $gallery_item->event_id;
        
        //need for menu
        //get all galery category for selected event
        $gallery_categories = $this->gallery_category->get_select_where('*', array('event_id' => $filter->event_id, 'is_active'=>1));
        $this->data['gallery_categories'] = $gallery_categories;
        
        $event_selected = $this->wow_event_m->get_select_where('*', array('id' => $filter->event_id), TRUE);
        $this->data['event_selected'] = $event_selected;
        $filter->event_name = $event_selected->name;        
	
        //$this->data['criteria'] = $criteria;
        
        /********** sorting ***********************/
        $criteria = $this->input->get('criteria', TRUE);
        if (!$criteria || $criteria=='all'){
            $criteria_query = '';
	}else{
            $criteria_query = "  AND (title LIKE '%".urldecode($criteria)."%' )";
        }
        $filter->criteria = $criteria;
        
        $allowed_order_type = array('asc','desc');
        $date_order = $this->input->get('date', TRUE);
        if (!$date_order || !in_array($date_order, $allowed_order_type)) 
            $date_order = 'desc';
        
        $filter->date_order = $date_order;
                
        foreach($gallery_categories as $gal_category){
            if ($gal_category->id == $gallery_item->gallery_category_id){
                $filter->gallery_category_name = $gal_category->category_name;
                break;
            }
        }
                
        //We only use model to get table name
        $table_gallery_item_detail = $this->db->dbprefix($this->gallery_item_detail->get_tablename());
        
        if (!$page) 
            $page = 1;
        
        $paging->page = $page;
        
        $this->data['gallery_home_url'] = site_url('wow/gallery/index/'.$filter->event_id.'/1?kind='.TYPE_IMAGE);
        /****************** set base url and base query params ****/
        //setting base url 
        $base_page_url = site_url('wow/gallery/gallery_album/'. $gallery_item_id); 
        //building full query param
        $query_param = array();
        $query_param ['date'] = $filter->date_order;
        /******************************** end of building query param *********/
        
        //set up paging
        $sql = 'SELECT COUNT(*) as total_records FROM ' . $table_gallery_item_detail .' WHERE gallery_item_id='. $gallery_item_id;
        
        //filter searching
        if ($filter->criteria && $filter->criteria!='all'){
            $sql.= $criteria_query;
        }
        $query = $this->db->query($sql)->row();
        
        $paging->totalRecords = $query->total_records;
        
        
        
        //Now get requested data 
        $paging->limitPerPage = 10;
        $paging->offset = $paging->page - 1;
        
        if ($paging->totalRecords>0){
            //set up paging
            $paging->totalPages = ceil($paging->totalRecords / $paging->limitPerPage);        
            $paging->start = $paging->offset * $paging->limitPerPage;
            
            $this->data['can_like_dislike'] = $this->user_m->is_loggedin();
            
            $sql = 'SELECT * FROM '. $table_gallery_item_detail . ' WHERE gallery_item_id='. $gallery_item_id;
            
            //filter searching
            if ($filter->criteria && $filter->criteria!='all')
                $sql.= $criteria_query;
            
            //set order and limit
            $sql .= ' ORDER BY date_time ' . $filter->date_order;
            $sql .= ' LIMIT '. $paging->start .','. $paging->limitPerPage;
            $items_result = $this->db->query($sql)->result();
            //exit(var_dump($items_result));
            $paging->size = count($items_result);
            
            //get table like_list name
            $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
            
            //iterate items to make paging
            $items = array();
            
            foreach($items_result as $item){
                
                //$wow_base_url = config_item('userfiles') .'wow/';
                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()){
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like            
                    $query = 'SELECT COUNT(*) total_like FROM '.$table_likelist.' WHERE user_id='.$userid.' AND item_id='.$item->id;
                    $user_liked = $this->db->query($query)->row()->total_like;
                    if ($user_liked == 0){
                        $user_can_like = TRUE;
                    }
                }
                $item->user_can_like = $user_can_like;
                
                $items [] = $item;
            }
            
            
            
            $this->data['items'] = $items;
                        
            //setting pagination
            $jsClick = $base_page_url .'/$' . '?' . http_build_query($query_param);
            
            
            //create pagination
            $this->data['pagination'] = smart_paging_js($paging->totalPages, $page, $jsClick, 7, '$');
            
        }else{
            $this->data['items'] = array();
            $this->data['pagination'] = '';
        }
		
	$this->data['filter'] = $filter;
        $this->data['paging'] = $paging;
        
       
        /******** set base url for button sort *********/
            
        $base_page_url .= '/'. $page;
        $base_url = new stdClass();
        //base url for date
        $date_thumb_qp = $query_param;
        if ($filter->date_order=='asc')
            $date_thumb_qp['date'] = 'desc';
        else
            $date_thumb_qp['date'] = 'asc';
        $base_url->date = $base_page_url . '?'. http_build_query($date_thumb_qp);
        
        $this->data['base_url_thumb'] = $base_url;
            
        //these lines bellow for header
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event){
            $where = array('event_id'=>$event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            $i++;
        }
        		
        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3, 'is_active'=>1))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
               
        
        //$this->load->view('channel/'.$this->_channel_name.'/gallery_all', $this->data);
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/gallery/album';
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
    }

}
