<?php

/**
 * Description of Music
 *
 * @author marwan
 * @email marwan
 */
class Radio extends Ajax {
            
    protected $channel_name = 'radio';
            
    function __construct() {
        parent::__construct();
        $this->_result['found'] = 0;        
    }
        
    function get_sod_subcategory(){
        $this->load->model('radio/genre');
        $categoryId = $this->input->post('categoryId',TRUE);
        $this->_result['items'] = $this->genre->get_select_where('*', array('id_category'=>$categoryId, 'status' => 'aktif'), FALSE);
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function send_radio_message(){
        $radio = $this->input->post('radio');
        $message = $this->input->post('message');
        //get api url for requested radio
        //load model
        $this->load->model('radio/model_radio');
        $api_url = $this->model_radio->get_select_where('radio_site', array('id'=>$radio),TRUE)->radio_site;

        $this->_result['status'] = 0;

        if ($api_url){
            $api_url.= '/apis/data/message';

            $sender = 'UZone';

            //check if user loggedin to get message sender name
            //load user
            $this->load->model('user_m');
            if ($this->user_m->is_loggedin()){
                $sender .= ' - ' . $this->session->userdata('name');
            }

            //send message via Lib
            $status = json_decode($this->radio->send($api_url, $sender, $message));
            $this->_result['status'] = $status;
            if ($status->code==2)
                $this->_result['message'] = 'Pesan berhasil dikirim';
            else
                $this->_result['message'] = 'Pesan gagal dikirim';

        }
    }
    
    
    /* kalau pake ajax viewnya, yang sekarang memekai iframe
    function get_radio_message(){
        $api_url = $this->input->post('api');

        $messages = json_decode(file_get_contents($api_url));

        $data = array();

        foreach($messages as $message){
            $data [] = array(
                    'foto'      =>  isset($message->foto) ? $message->foto :'',
                    'pengirim'  =>  urldecode($message->pengirim),
                    'pesan'     =>  urldecode($message->pesan)
                );
        }

        $this->_result['items'] = $data;
        $this->_result['found'] = count($data);

    }*/
          
}

/*
 * file location: /engine/application/controllers/ajax/music.php
 */
?>
