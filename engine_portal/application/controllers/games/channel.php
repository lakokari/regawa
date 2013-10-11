<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */
class Channel extends U_Controller {
    
    protected $_channel_name = 'games';
    
    function __construct() {
        parent::__construct();        
        $this->data['channel_name'] = $this->_channel_name;
    }
    
    public function index(){     
        $this->load->model($this->_channel_name.'/category');
        $this->data['categories'] = $this->category->get_select_where('*', array('status' => '1' ));
        

        $this->load->model($this->_channel_name.'/items');
        $games = $this->items->get_offset('*', NULL, 0, 9);
        foreach($games as $item){
            $item->thumbnail_url = config_item('api_sync') . 'games/'. $item->thumbnail_url;
            $this->data['games'] []= $item;
        }
        
        
        $this->load->model($this->_channel_name.'/top');
        $top = $this->top->get_offset('*', NULL, 0, 4);
        foreach($top as $item){
            $item->thumbnail_url = config_item('api_sync') . 'games/'. $item->thumbnail_url;
            if ($item->thumbnail_big_url && is_valid_remote_file(config_item('api_sync') . 'games/'. $item->thumbnail_big_url))
                $item->thumbnail_big_url = config_item('api_sync') . 'games/'. $item->thumbnail_big_url;
            else
                $item->thumbnail_big_url = $item->thumbnail_url;
            $this->data['top'] []= $item;
        }

        $this->load->model($this->_channel_name.'/new_r');
        $where_not_in = array(
                'categories'    =>  'Orangegame'
            );
        
        $new_r = $this->new_r->get_wherenotin_offset('*', null, $where_not_in, 0, 9);
        foreach ($new_r as $item){
            $item->thumbnail_url = config_item('api_sync') . 'games/'. $item->thumbnail_url;
            $this->data['new_r'] [] = $item;
        }
        //load new album from static syncfile
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/index';
        $this->load->view('_layout_main', $this->data);
    }
}

?>
