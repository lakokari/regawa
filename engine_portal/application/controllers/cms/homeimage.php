<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channels
 *
 * @author master
 */
class Homeimage extends U_CMS_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->data['page_title'] = 'Home Cover Image';
        
        //Load view
        $this->data['active_menu'] = 'channel';
        $this->data['subview'] = 'cms/homeimage/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function edit($channel_id=NULL){
        
        // Set form
        $rules = $this->channel_m->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->channel_m->array_from_post(array('name','title','description','sort','showed','hasFeatured'));
            //try to proccess upload if exists
            $upload_message = '';            
            $upload = $this->channel_m->upload_channel_cover('cover', $upload_message);
            if ($upload){
                $data_post['cover'] = $upload['file_name'];
                
            }else{
                $this->session->set_flashdata('error', $upload_message);
            }
            if ($this->channel_m->save($data_post, $channel_id) == TRUE) {
                redirect('cms/channels');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
        
        }
        
        $this->data['page_title'] = 'Channel Edit';
        
        if ($channel_id)
            $this->data['channel'] = $this->channel_m->get($channel_id);
        else
            $this->data['channel'] = $this->channel_m->get_new();
        
        //Load view
        $this->data['active_menu'] = 'channel';
        $this->data['subview'] = 'cms/channels/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function delete($channel_id=NULL){
        if ($channel_id)
            $this->channel_m->delete_channel($channel_id);
            
        redirect('cms/channels');
    }
    
    public function sync($channel_id=NULL){
        if ($channel_id){
            $this->channel_m->channel_items_sync($channel_id);
        }
        
        redirect('cms/channels');
    }
    
    
    public function unique_channel_name(){
        //do not validate if exist
        //Unless it is the current record
        $id = $this->uri->segment(4);
        
        $this->db->where('name', $this->input->post('name'));
        !$id || $this->db->where('id !=', $id);
        
        $found = $this->channel_m->get();
        if (count($found)){
            $this->form_validation->set_message('unique_channel_name','%s already exists!');
            
            return FALSE;
        }
        
        return TRUE;
    }
    
}
/*
 * file location: /application/controllers/cms/channels.php
 */
