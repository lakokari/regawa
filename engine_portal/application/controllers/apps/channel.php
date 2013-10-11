<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of store
 *
 * @author master
 */
class Channel extends U_Controller {
    
    protected $_channel_name = 'apps';
    
    function __construct() {
        parent::__construct();       
        
        //load Book lib (ApStore)
        $this->load->library('apstore');
    }
    
    public function index(){
        //load category_parent model
        $this->load->model('apps/parentcategory');
        $this->data['parentcategories'] = $this->parentcategory->get();

        //image slider
        $channel_id = 0;
        foreach($this->data['channels'] as $channel){
            if ($channel->name==$this->_channel_name){
                $channel_id = $channel->id;
                break;
            }
        }
        if ($channel_id){
            $this->load->model('feature_m');
            $this->data['featureds'] = $this->feature_m->get_featured($channel_id, 5);
            $this->data['featured_path'] = base_url($this->feature_m->feature_image_path.$this->_channel_name).'/';
        }
        
        //load new album from static syncfile
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/index';
        $this->load->view('_layout_main', $this->data);
    }
        
    function commentview(){
        $this->load->helper('cms');
        $id=$this->input->post('item_id');
        $page=$this->input->post('page');
        $limit=$this->input->post('limit');
        $this->load->model(array('comment_rating_m'));
        $offset = $page-1;
        $start = $offset * $limit;
        $result = $this->comment_rating_m->get_offset('*', array('channel_name'=>'apps','item_id'=>$id), $start, $limit);
        $totalSize = $this->comment_rating_m->get_count(array('channel_name'=>'apps','item_id'=>$id));
        $data['items'] = $result; 
        $data['found'] = count($result);
        $totalPages = ceil($totalSize/$limit);
        //create js paging
        $jsClick = 'javascript:loadcomment('.$id.',$);';
        $data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        echo json_encode($data);
    }

}

?>
