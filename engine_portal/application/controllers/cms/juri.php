<?php

/**
 * Description of Wow
 *
 * @author master
 */
class Juri extends U_CMS_Controller {
    
    protected $channel_name = 'wow';
    
    function __construct() {
        parent::__construct();
        
        $this->data['active_menu'] = 'juri';
    }

    public function items() {
        $judge_id = $this->session->userdata('userid');
        //get event_id from session
        $event_id = $this->session->userdata('wow_event_id');

        if($event_id > 0){
            //get event name by event_id
            $this->load->model($this->channel_name.'/wow_event_m');
            $event_name = $this->wow_event_m->get($event_id, TRUE)->name;
            
            $this->data['page_title'] = 'Event '.$event_name;
        } else {
            $this->data['page_title'] = "Event Tidak Ditemukan.";
        }

        

        $this->data['subview'] = 'cms/channels/juri/items/list';
        $this->load->view('cms/_layout_main', $this->data);
    }

    /*
    public function nilai(){
        $this->load->model('wow/judge_m');
        $data_post = $this->judge_m->array_from_post(array('score','comment','item_id'));
        $data_post['judge_id'] = $this->session->userdata('userid');
        $data_post['datetime'] = date('Y-m-d H:i:s');

        if(($data_post['score']>100) || ($data_post['score']<0)){
            $this->session->set_flashdata('error', 'nilai hanya boleh 1-100');
            //redirect('cms/juri/items');
        }
        if ($this->judge_m->save($data_post) == TRUE) {
            redirect('cms/juri/items');
            exit;
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan nilai atau comment');
        }
    }*/
}