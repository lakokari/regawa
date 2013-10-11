<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Coverstory
 *
 * @author master
 */
class Coverstory extends U_CMS_Controller {

    protected $FM = NULL;
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('coverstory_m');
        $this->FM = $this->coverstory_m;
        
        $this->data['active_menu'] = 'channels';
    }    
    public function index(){
        $this->data['page_title'] = 'Cover Story List';
        //Load view
        $this->data['subview'] = 'cms/coverstory/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function edit($id=NULL){
        
        $rules = $this->FM->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            
            //get all post data
            $data_post = $this->FM->array_from_post(array('name','title','sort','showed','image_url','target_url'));
            //we need id to be part of filename, so if no id, save it firt and get the new id
            if (!$id){
                $this->FM->save($data_post, $id);
                $id = $this->FM->get_inserted_id();
            }
            if(!empty($_FILES['image_url']['name']))
            {
                $id_to_filename = str_pad($id, 6, '0', STR_PAD_LEFT);
                $upload_err = '';
                $upload_config = $this->FM->cover_config;
                $upload_config['upload_path'] = SITE_PATH . $this->FM->image_path;
                $upload_config['file_name'] = 'COVERSTR_'.$id_to_filename.'.jpg';
                $upload = $this->FM->my_upload('image_url',$upload_config,$upload_err,TRUE);
                if ($upload){
                    $image_url = $upload['file_name'];
                    //do we need to resize
                    If ($upload['width']!=$this->FM->cover_w || $upload['height']!=$this->FM->cover_h)
                    {
                        //resize image
                        $config_thumb = $this->FM->cover_resize;
                        $config_thumb['source_image'] = $upload['full_path'];
                        $this->FM->image_manipulation($config_thumb);
                    }

                    //save data
                    $this->FM->save(array('image_url'=>$image_url), $id);
                }else{
                    $this->session->set_flashdata('error','Upload failed!. Error message: '.$upload_err);
                }
            }
            
            redirect('cms/coverstory/index');
        }
        
        $this->data['page_title'] = $id?'Edit Cover':'Create New Cover';
        
        if ($id)
            $cover_row = $this->FM->get($id, TRUE, 'row');
        else
            $cover_row = $this->FM->get_new();
        
        $this->data['cs_row'] = $cover_row;
        //Load view
        $this->data['subview'] = 'cms/coverstory/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function delete($id=NULL){
        if ($id){
            $this->FM->delete($id);
        }
        
        redirect('cms/coverstory');
    }
    
    
}
/*
 * file location: /application/controllers/cms/features.php
 */
