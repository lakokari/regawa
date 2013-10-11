<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Games
 *
 * @author master
 */
class Detail extends U_Controller {
    
    protected $_channel_name = 'games';
    
    function __construct() {
        parent::__construct();
    }
    
    public function item($gameId=NULL){
        if (!$gameId) $gameId = $this->input->post('gameId');
        
        //load category games
        $this->load->model($this->_channel_name.'/category');
        $this->data['categories'] = $this->category->get();
        
        $this->load->model($this->_channel_name.'/top');
        $top = $this->top->get_offset('*', NULL, 0, 3);
        foreach($top as $item){
            $item->thumbnail_url = config_item('api_sync') . 'games/'. $item->thumbnail_url;
            if ($item->thumbnail_big_url && is_valid_remote_file(config_item('api_sync') . 'games/'. $item->thumbnail_big_url))
                $item->thumbnail_big_url = config_item('api_sync') . 'games/'. $item->thumbnail_big_url;
            else
                $item->thumbnail_big_url = config_item('api_sync') . 'games/'. $item->thumbnail_url;
            $this->data['top'] []= $item;
        }
        
        //load model album
        $this->load->model($this->_channel_name.'/items');
        $item = $this->items->get_by(array('ID'=>$gameId), TRUE);
        $item->thumbnail_url = config_item('api_sync') . 'games/'. $item->thumbnail_url;
        if ($item->thumbnail_big_url && is_valid_remote_file(config_item('api_sync') . 'games/'. $item->thumbnail_big_url)){
            $item->thumbnail_big_url = config_item('api_sync') . 'games/'. $item->thumbnail_big_url;
        }else{
            $item->thumbnail_big_url  = $item->thumbnail_url;
        }
        $this->data['item'] = $item;
        //check weather should play outside or in site
        if (strstr($item->swf_url, 'swf')){
            $this->data['inside'] = 1;
        }else{
            $this->data['inside'] = 0;
        }
        
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/itemdetail';
        $this->load->view('_layout_main', $this->data);
    }
}

?>
