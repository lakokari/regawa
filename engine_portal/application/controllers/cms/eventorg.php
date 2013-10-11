<?php

/**
 * Description of music
 *
 * @author master
 */
class Eventorg extends U_CMS_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('news_m');
        $this->data['active_menu'] = 'news';
    }

    public function news(){
        $this->data['page_title'] = 'Wow News';
        $this->data['subview'] = 'cms/channels/eventorg/news/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function news_edit($id=NULL){
        //load model wow news_m
        $this->load->model('news_m');

        // Set form
        $rules = $this->news_m->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $data_post = $this->news_m->array_from_post(array('item_id','news_title','news_text','type')); 
            $data_post['news_datetime'] = $this->input->post('news_datetime').' '.date('H:i:s');
            $data_post['news_by'] = $this->session->userdata('userid');
            $data_post['channel_name'] = 'wow';

            //try to upload video
            $upload_message_video = '';
            $upload_config_file = $this->news_m->upload_video;
            $upload_config_file['upload_path'] = SITE_PATH.$upload_config_file['upload_path'];
            $upload_config_news['file_name'] = 'WOW_NEWS_'.time().'.jpg';
            $upload_file = $this->news_m->my_upload('video',$upload_config_file, $upload_message_video);
            if ($upload_file){
                $data_post['video_path'] = $upload_file['file_name'];
            }else{
                $this->session->set_flashdata('error', $upload_message_video);
            }

            //try to upload news
            $upload_message_news = '';
            $upload_config_news = $this->news_m->upload_config_news_wow;
            $upload_config_news['upload_path'] = SITE_PATH.$upload_config_news['upload_path'];
            //$upload_config_thumb['upload_path'] = config_item('userfiles').'wow/banner/';
            $upload_config_news['file_name'] = 'WOW_NEWS_'.time().'.jpg';
            $upload_news = $this->news_m->my_upload('image',$upload_config_news, $upload_message_news);
            if ($upload_news){
                $data_post['img_path'] = $upload_news['file_name'];
            }

            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/eventorg/news';
            
            if ($this->news_m->save($data_post, $id) == TRUE) {
                redirect($retUrl);
                exit;
            } else{
                $this->session->set_flashdata('error','Failed to save new update');
            }
        }

        //set page title
        $this->data['page_title'] = $id ? 'Wow News - Edit':'Wow News - New';
        
        //load data to edit
        if ($id)
            $data = $this->news_m->get($id, TRUE);
        else
            $data = $this->news_m->get_new();
        
        //set data in form
        $this->data['data'] = $data;
        $this->data['retUrl'] = site_url('cms/eventorg/news');

        //get event for dropdown
        $this->load->model('wow/wow_event_m');
        $result = $this->wow_event_m->get();
        $list_event = array();
        foreach ($result as $item){
            $list_event [$item->id] = $item->name;
        }
        $this->data['list_event'] = $list_event;

        //list type - statis
        $list_type = array(1=>'News',2=>'RoadShow',3=>'Appetisers');
        $this->data['list_type'] = $list_type;

        $this->data['subview'] = 'cms/channels/eventorg/news/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }

    public function news_delete($id=NULL){
        if($id) {
            $this->load->model('news_m');
            $this->news_m->delete($id);
        }
        redirect('cms/eventorg/news');
    }
}

?>
