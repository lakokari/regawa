<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Items extends U_CMS_Controller {
    
    function __construct() {
        parent::__construct();
        
    }
    
    public function index($channel_id=NULL, $category_id=NULL, $offset=0, $limit=30)
    {
        
        if (!$channel_id) $channel_id = 1;
        
        $this->data['channel_id'] = $channel_id;
        $this->data['channel_name'] = $this->channel_m->channel_label_from_list($this->data['channel_list'],$channel_id,'name');
        
        $this->data['category_id'] = $category_id;
        $this->data['offset'] = $offset;
        $this->data['limit'] = $limit;
        
        
        $this->data['page_title'] = $this->channel_m->channel_label_from_list($this->data['channel_list'],$channel_id);
        
        
        $dropdown_category = array();
        
        //load channel categories parent
        $channel_categories = $this->channel_m->get_channel_categories_parent($channel_id);        
        
        foreach($channel_categories as $category_parent){
            $dropdown_category [$category_parent->category_id] = $category_parent->category_name;
            //get child
            $child_category = $this->channel_m->get_channel_categories_by_parent($channel_id, $category_parent->category_id);
            if ($child_category){
                foreach($child_category as $child){
                    if (!$this->data['category_id']) $this->data['category_id'] = $child->category_id;
                    $dropdown_category[$child->category_id] = '-----'.$child->category_name;
                }
            }
        }
        $this->data['channel_categories'] = $dropdown_category;
        
        //get total items for pagination
        $this->data['channel_total_items'] = $this->channel_m->get_count_items($channel_id, $this->data['category_id']);
        $this->data['channel_total_pages'] = ceil($this->data['channel_total_items']/$this->data['limit']);
        //load items from selected channel        
        $channel_items = $this->channel_m->get_channel_items($channel_id, $this->data['category_id'], $this->data['offset'], $this->data['limit']);        
        $this->data['channel_items'] = $channel_items;
                
        //Load view
        $this->data['active_menu'] = 'channel';
        $this->data['subview'] = 'cms/items/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function edit($channel_id,$item_id,$offset=0,$limit=30,$retpage=NULL){
        
        $this->data['offset'] = $offset;
        $this->data['limit'] = $limit;
        $this->data['retpage'] = $retpage;
        
        // Set form
        $rules = $this->channel_m->rules_feature_image;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            $data_post = $this->channel_m->array_from_post(array('channel_id','category_id','item_id'));
            //try to proccess upload if exists
            $upload_message = '';
            $channel_name = $this->channel_m->channel_label_from_list($this->data['channel_list'],$channel_id,'name');
            $upload = $this->channel_m->upload_image_feature('cover', $upload_message, $channel_name);
            if ($upload){
                $data_post['cover'] = $upload['file_name'];
                if ($this->channel_m->save_feature_item($data_post)) {
                    if ($retpage)
                        redirect('cms/'.my_urldecode ($retpage).'/'.$data_post['channel_id']);
                    else
                        redirect('cms/items/index/'.$data_post['channel_id'].'/'.$data_post['category_id'].'/'.$offset.'/'.$limit);
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan perubahan');
                }
            }else{
                $this->session->set_flashdata('error', $upload_message);
            }
        }
        $feature_item = $this->channel_m->get_feature_item($channel_id,$item_id);
        
        $this->data['channel_name'] = $this->channel_m->channel_label_from_list($this->data['channel_list'],$channel_id,'name');
        
        $this->data['page_title'] = $this->channel_m->channel_label_from_list($this->data['channel_list'],$channel_id);
        
        $this->data['feature_item'] = $feature_item;
        
        //Load view
        $this->data['active_menu'] = 'channel';
        $this->data['subview'] = 'cms/items/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    
}
/*
 * file location: /application/controllers/cms/items.php
 */
