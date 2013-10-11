<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of TV
 *
 * @author master
 */
class Channel extends U_Controller {
    protected $_channel_name = 'tv';
    
    function __construct() {
        parent::__construct();       
        $this->data['channel_name'] = $this->_channel_name;
    }
    
    public function index(){     
        //load tv category
        $this->load->model($this->_channel_name.'/tv_category');
        $this->load->model($this->_channel_name.'/tv_most_popular');
        
        $this->data['categories'] = $this->tv_category->get_by(array('showed_YN'=>'y'));
        
        
        $result_tv_popular = $this->tv_most_popular->get_offset('*', NULL, 0, 4);
        $popularitems = array();
        foreach($result_tv_popular as $item){
            if ($this->is_device('MOBILE')){
                $item->stream_url = base64_encode($item->hls);
            }else{
                $item->stream_url = base64_encode($item->rtmp);
            }
            $item->thumbnail = base64_encode(config_item('api_sync'). 'tv/' .$item->thumbnail);
            /*
            if (!file_exists($item->img)){
                $item->img = config_item('image_url') .'channel/tv/banner_tv.jpg';
            }*/
            $popularitems[] = $item;
        }
        $this->data['most_popular'] = $popularitems;
        
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/index';
        $this->load->view('_layout_main', $this->data);
    }
    
}
