<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */
class Channel extends U_Controller {
    
    protected $_channel_name = 'movie';
	public $user_id;
	public $username;
	public $email;
    
    function __construct() {
        parent::__construct();
        $this->user_id = $this->session->userdata('userid');
        $this->username = $this->session->userdata('username');
        $this->email = $this->session->userdata('email');
        $this->load->library('movie');
        $this->load->model($this->_channel_name.'/subcategory');
                
           
        $movie_category = array(
            array(
                'name'  =>  'newrelease',
                'title' =>  'New Release'
            ),
            array(
                'name'  =>  'top_view',
                'title' =>  'Top View'
            ),
            array(
                'name'  =>  'top_paid',
                'title' =>  'Top Paid'
            )
        );
        $this->data['subcategory'] = $movie_category;
    }
    
    public function index(){
        
        $this->data['channel_name'] = $this->_channel_name;

        $this->load->model('movie/items');

        //Load new release
        $new_release_result = $this->items->get_offset('*', array('new_releaseYN'=>'y'), 0, 3);
        $new_release = array();
        foreach($new_release_result as $item){
            $item->item_thumbnail = config_item('api_sync').'movie/'.$item->item_thumbnail;
            $item->item_thumbnail_big = config_item('api_sync').'movie/'.$item->item_thumbnail_big;
            $new_release [] = $item;
        }
        $this->data['new_release'] = $new_release;

	//Load top paid
        $top_paid_result = $this->items->get_offset('*', array('top_paidYN'=>'y'), 0, 6);
        $top_paid = array();
        foreach($top_paid_result as $item){
			
            $item->item_thumbnail = config_item('api_sync').'movie/'.$item->item_thumbnail;
            $item->item_thumbnail_big = config_item('api_sync').'movie/'.$item->item_thumbnail_big;
			
            $top_paid [] = $item;
        }
        $this->data['top_paid'] = $top_paid;

        
        //Load top view
        $top_view_result = $this->items->get_offset('*', array('top_viewYN'=>'y'), 0, 6);
        $top_view = array();
        foreach($top_view_result as $item){
            $item->item_thumbnail = config_item('api_sync').'movie/'.$item->item_thumbnail;
            $item->item_thumbnail_big = config_item('api_sync').'movie/'.$item->item_thumbnail_big;
            
            $top_view [] = $item;
        }
        $this->data['top_view'] = $top_view;

        $this->data['subview'] = 'channel/'.$this->_channel_name.'/index';
        $this->load->view('_layout_main', $this->data);
    }
    
    function movie(){
		$id=$this->input->post('id');
		$limit=$this->input->post('limit');
		$this->load->model('movie/items');
		$result=array();
		switch($id){
			case 1 : $result = $this->items->get_by(array('coming_soonYN'=>'y'));
			break;
			case 2 : $result = $this->items->get_by(array('new_releaseYN'=>'y'));
			break;
			case 3 : $result = $this->items->get_wherein_offset('*',null,0,$limit);
			break;
			case 4 : $result = $this->items->topview($limit);
			break;
			case 5 : $result = $this->items->toppaid($limit);
			break;
		}
		$result=array('found'=>count($result),
					'items' => $result);
		echo json_encode($result);
	}
	function moviebycategory(){
		$this->load->model('movie/items');
		$this->load->model('movie/category');
		$id=$this->input->post('id');
		$cate=$this->category->get_by(array('category_id'=>$id),true);
		$cate=$cate->category_name;
		$result = $this->items->get_like(array('field'=>'categories','value'=>$cate));
		$result=array('found'=>count($result),
					'items' => $result,
					'cate'=>ucwords($cate));
		echo json_encode($result);
	}
	
    public function detail($id){
        $this->plusview($id);
        $this->load->model(array($this->_channel_name.'/items',$this->_channel_name.'/like_list',$this->_channel_name.'/rating',$this->_channel_name.'/rating_source', 'user_m'));
        
        $this->data['islogin']=$this->user_m->is_loggedin();
        
        //encode movie url
        $item = $this->items->get_by(array('id'=>$id), TRUE);
        if ($this->is_device('MOBILE'))
            $item->item_url_mpeg = base64_encode($item->item_url_mpeg_mobile);
        else
            $item->item_url_mpeg = base64_encode($item->item_url_mpeg);
        
        $item->url_full_movie = base64_encode($item->url_full_movie);
        
		//set item image
        $item->item_thumbnail = config_item('api_sync').'movie/'.$item->item_thumbnail;
        $item->item_thumbnail_big = config_item('api_sync').'movie/'.$item->item_thumbnail_big;
		
        $this->data['item'] = $item;
                
        $this->data['likelist'] = $this->like_list->get_count(array('user_id'=>$this->user_id, 'item_id'=>$this->data['item']->id));
        $this->data['star'] = $this->rating->get_by(array('item_id'=>$this->data['item']->id));
        for($i=0;$i<count($this->data['star']);$i++){
            $alias=$this->rating_source->get_by(array('id'=>$this->data['star'][$i]->source_id),true);
            $this->data['star'][$i]->alias=$alias->alias;
        }
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/itemdetail';
        $this->load->view('_layout_main', $this->data);
    }
    
    function comment(){
    	$id=$this->input->post('id');
    	$comment=$this->input->post('comment');
    	$rating=$this->input->post('rating');
    	$data=array('channel_name'=>'movie',
    				'item_id'=>$id,
    				'comment'=>$comment,
    				'rating'=>$rating,
    				'username'=>$this->username,
    				'u_name'=>$this->username,
    				'email'=>$this->email,
    				'datetime'=>date('Y-m-d H:i:s'));
    	$this->load->model(array('comment_rating_m','user_m'));
    	header('Content-Type: application/json');
    	if($this->user_m->is_loggedin() && $this->comment_rating_m->save($data)) $data['status']=1;
    	 echo json_encode($data);
    }
    function commentview(){
		$this->load->helper('cms');
		$id=$this->input->post('item_id');
		$page=$this->input->post('page');
		$limit=$this->input->post('limit');
		$this->load->model(array('comment_rating_m'));
		$offset = $page-1;
        $start = $offset * $limit;
		$result = $this->comment_rating_m->get_offset('*', array('channel_name'=>'movie','item_id'=>$id), $start, $limit);
		$totalSize = $this->comment_rating_m->get_count(array('channel_name'=>'movie','item_id'=>$id));
		$data['items'] = $result; 
		$data['found'] = count($result);
		$totalPages = ceil($totalSize/$limit);
		//create js paging
		$jsClick = 'javascript:loadcomment($);';
		$data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
		echo json_encode($data);
	}
    

    function plusview($id){
		//$id=$this->input->post('id');
		$this->load->model($this->_channel_name.'/items');
		$viewcount=$this->items->get_by(array('id'=>$id), TRUE);
		$viewcount=$viewcount->view_count+1;
		$data=array('view_count'=>$viewcount);
		$this->items->save($data, $id);
	}
    function pluspaid(){
		$id=$this->input->post('id');
		$this->load->model($this->_channel_name.'/items');
		$paidcount=$this->items->get_by(array('id'=>$id), TRUE);
		$paidcount=$paidcount->view_paid_count+1;
		$data=array('view_paid_count'=>$paidcount);
		$this->items->save($data, $id);
	}
    function like(){
		$id=$this->input->post('id');
		$this->load->model(array($this->_channel_name.'/items',$this->_channel_name.'/like_list'));
		$date= date('Y-m-d h:i:s', time());
		$data=array('item_id'=>$id, 'user_id'=> $this->user_id, 'like_date'=>$date);
		if($this->like_list->save($data)){
			$count=$this->items->get_by(array('id'=>$id));
			$data=array('item_like_count'=>($count[0]->item_like_count)+1);
			$this->items->save($data,$id);
		}
	}
    function unlike(){
		$id=$this->input->post('id');
		$this->load->model(array($this->_channel_name.'/items',$this->_channel_name.'/like_list'));
		$data=array('item_id'=>$id, 'user_id'=> $this->user_id);
		if($this->like_list->delete_where($data)){
			$count=$this->items->get_by(array('id'=>$id));
			$data=array('item_like_count'=>($count[0]->item_like_count)-1);
			$this->items->save($data,$id);
		}
	}
}

?>
