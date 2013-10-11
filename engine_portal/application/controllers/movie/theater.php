<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */
class Theater extends U_Controller {
    
    protected $_channel_name = 'movie';
	public $user_id=1;
	public $email='test123@test.com';
    
    function __construct() {
        parent::__construct();      
        $this->load->library('movie');
		$this->load->model($this->_channel_name.'/subcategory');
        $this->data['subcategory'] = $this->subcategory->get();
        
        $this->load->model($this->_channel_name.'/category');       
        $this->data['categories'] = $this->category->get();
    }
    
    public function index(){
        
		$this->data['channel_name'] = $this->_channel_name;

		$this->load->model(array('movie/items','movie/city'));
		$this->data['coming_soon'] = $this->items->get_by(array('coming_soonYN'=>'y'));
		$this->data['new_release'] = $this->items->get_by(array('new_releaseYN'=>'y'));
		$this->data['top_view'] = $this->items->topview(100);
		$this->data['city'] = $this->city->get();

        $this->data['subview'] = 'channel/'.$this->_channel_name.'/theater';
        $this->load->view('_layout_main', $this->data);
    }
	function moviebycity(){
		$city=$this->input->post('city');
		$sql="select distinct item_id from uz_movie_schedule where city_id='$city' and schedule_date = '".date('y-m-d')."'";
		$sql="select id,item_name from uz_movie_items where id in ($sql)";
		$result=$this->db->query($sql);
		$result=$result->result();
		$data['items']=$result;
		$data['found']=count($result);
		echo json_encode($data);
	}
	function theaterbycity(){
		$city=$this->input->post('city');
		$sql="select distinct theater_id from uz_movie_schedule where city_id='$city' and schedule_date = '".date('y-m-d')."'";
		$sql="select id,name from uz_movie_theater where id in ($sql)";
		$result=$this->db->query($sql);
		$result=$result->result();
		$data['items']=$result;
		$data['found']=count($result);
		echo json_encode($data);
	}
	function theaterlist(){
		$city=$this->input->post('city');
		$id=$this->input->post('id');
		$sql="select a.theater_id, b.name, GROUP_CONCAT( TIME_FORMAT( a.schedule_time, '%H:%i' ) ) as time 
				from uz_movie_schedule a
				inner join uz_movie_theater b on a.theater_id=b.id
				where a.city_id='$city' and a.schedule_date = '".date('y-m-d')."' and a.item_id='$id'
				group by a.theater_id, b.name";
		$result=$this->db->query($sql);
		$result=$result->result();
		$data['items']=$result;
		$data['found']=count($result);
		echo json_encode($data);
	}
	function movielist(){
		$city=$this->input->post('city');
		$id=$this->input->post('id');
		$sql="select b.item_thumbnail, a.item_id, b.item_name, GROUP_CONCAT( TIME_FORMAT( a.schedule_time, '%H:%i' ) ) as time 
				from uz_movie_schedule a
				inner join uz_movie_items b on a.item_id=b.id
				where a.city_id='$city' and a.schedule_date = '".date('y-m-d')."' and a.theater_id='$id'
				group by a.item_id, b.item_name, b.item_thumbnail";
		$result=$this->db->query($sql);
		$result=$result->result();
		$data['items']=$result;
		$data['found']=count($result);
		echo json_encode($data);
	}
}

?>
