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
        
        //Get random images for each channel
        $random_images = array();
        foreach($this->data['channels'] as $channel){
            $random_images[$channel->name] = $this->_get_random_images($channel->name, 3);
        }
        $this->data['random_images'] = $random_images;
        
        $this->data['subview'] = 'home/index';
        $this->load->view('_layout_home', $this->data);
    }
    
    protected function _get_random_images($channel_name, $image_num=3){
        $this->load->model('home_random_image_m');
        
        $result_images = $this->home_random_image_m->get_by(array('channel_name'=>$channel_name));
        
		$image_list = array();
		
        if (count($result_images)){
            //generate random index number
            $min = 0;
            $max = count($result_images)-1;

            $index_selected = array();
            
            while (TRUE){
                //generate random
                $random_index = rand($min, $max);
                //check if random index already in list
                if (in_array($random_index, $index_selected)){
                    continue;
                }

                //if unique, put it in list
                $index_selected[] = $random_index;
                $selected_row = $result_images[$random_index];
                $image_list [] = $selected_row->image_url;
                if (count($image_list) >= $image_num)
                    break;
            }
        }
        
        return $image_list;
    }
}

?>
