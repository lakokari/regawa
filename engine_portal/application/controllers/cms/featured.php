<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Features
 *
 * @author master
 */
class Featured extends U_CMS_Controller {
    
    protected $channel_id = 1;
    protected $channel_name = '';
    protected $channel_title = '';
    
    protected $FM = NULL;
    
    function __construct() {
        parent::__construct();
        $this->data['active_menu'] = 'channels';
        
        //Load model
        $this->load->model('feature_m');
    }    
    
    protected function set_channel($channel_id){
        //load channel model //already loaded in parent class
        $channel = $this->channel_m->get_select_where('name, title', array('id'=>$channel_id), TRUE);
        $this->channel_id = $channel_id;
        $this->channel_name = $channel->name;
        $this->channel_title = $channel->title;
    }
    
    public function index($channel_id=NULL){        
        if (!$channel_id)
            $this->channel_id = 1;
        else
            $this->channel_id = $channel_id;
        
        $this->set_channel($this->channel_id);
        
        $this->data['channel_id'] = $this->channel_id;
        $this->data['channel_name'] = $this->channel_name;
        $this->data['page_title'] = $this->channel_title.' Featured Image List';
        //Load view
        $this->data['subview'] = 'cms/features/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function edit($channel_id=NULL, $item_id=NULL){
        if (!$channel_id || !$item_id){
            redirect('cms/featured/index/'.$channel_id);
        }
        $this->set_channel($channel_id);
        
        $this->set_channel($this->channel_id);
        
        if(!empty($_FILES['cover']['name']))
        {
            $upload_err = '';
            $upload_config = $this->feature_m->cover_config;
            $upload_config['upload_path'] = SITE_PATH . $this->feature_m->feature_image_path.$this->channel_name;
            $upload_config['file_name'] = 'FEAT_'.$item_id.'.jpg';
            $upload = $this->feature_m->my_upload('cover',$upload_config,$upload_err,TRUE);
            if ($upload){
                $cover = $upload['file_name'];
                //resize image
                $config_thumb = $this->feature_m->cover_resize;
                $config_thumb['source_image'] = $upload['full_path'];
                $this->feature_m->image_manipulation($config_thumb);
                
                //save data
                $this->feature_m->save_cover($channel_id, $item_id, $cover);
                
                redirect('cms/featured/index/'.$channel_id);
            }else{
                $this->session->set_flashdata('error','Upload failed!. Error message: '.$upload_err);
            }
        }
        
        $this->data['channel_id'] = $this->channel_id;
        $this->data['channel_name'] = $this->channel_name;
        $this->data['page_title'] = $this->channel_title.' Featured Image List';
        
        $feature = $this->feature_m->get_select_where('cover',array('channel_id'=>$channel_id, 'item_id'=>$item_id), TRUE);
        $this->data['feature'] = $feature;
        //Load view
        $this->data['subview'] = 'cms/features/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function delete($channel_id, $item_id=NULL){
        $feature_id = $this->feature_m->get_select_where('id',array('channel_id'=>$channel_id,'item_id'=>$item_id),TRUE)->id;
        if ($feature_id){
            $this->load->model('feature_m');
            $this->feature_m->delete($feature_id);
        }
        
        redirect('cms/featured/index/'.$channel_id);
    }
    
    
}
/*
 * file location: /application/controllers/cms/features.php
 */
