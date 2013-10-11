<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author master
 */
class Home extends U_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        //set active menu
        $this->data['active_menu'] = 'home';
        
        //load cover home image
        $this->load->model('home_cover_image_m');
        $this->data['home_wall'] = $this->home_cover_image_m->get_by(array('is_showedYN'=>'y'));
        
        //load 3 thumb radio
        $this->data['sod'] = json_decode(file_get_contents("http://www.diradio.net/apis/data/lists/pop-barat")); 
            
        //load 3 thumb movie
        $this->load->model('movie/items');
        $top_view_result = $this->items->topview(6);
        $top_view = array();
        foreach($top_view_result as $item){
            if ($item->categories=='tovi'){
                $item->item_thumbnail = config_item('api_folder').'tovi'.$item->item_thumbnail;
                $item->item_thumbnail_big = config_item('api_folder').'tovi'.$item->item_thumbnail_big;
            }else{
                $item->item_thumbnail = config_item('api_folder').'vod/'.$item->categories.'/'.$item->item_thumbnail;
                $item->item_thumbnail_big = config_item('api_folder').'vod/'.$item->categories.'/'.$item->item_thumbnail_big;
            }
            $top_view [] = $item;
        }
        $this->data['top_view'] = $top_view;
        
        //load 3 thumb TV
        $this->data['tvod'] = json_decode(file_get_contents("http://www.useetv.com/services/moviestat?tipe=top_tvod")); 
        
        
        //load 3 thumb book
        $this->load->model('book/thumb_home');
        $like = array(
            'field'     =>  'featured',
            'value'     =>  'Bestseller',
            'position'  =>  'both'
        );
        $this->data['bookbs'] = $this->thumb_home->get_like($like, '*', 0, 3);
        
        //load 3 thumb apps
        $this->load->model('apps/top');
        $where = array('parent_id'=>'2');
        $this->data['appstop'] = $this->top->get_offset('*', $where, 0, 3);
        
        $this->data['subview'] = 'home/index';
        $this->load->view('_layout_home', $this->data);
    }
	
	function sysinfo(){
		echo phpinfo();
	}
}

?>
