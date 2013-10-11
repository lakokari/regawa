<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class WowDefault extends U_Controller {
    
    function __construct() {
        parent::__construct();
    }
    /**
     * set footer video
     * @param int $eventId
     */
    protected function setPlaymeDataByEvent($eventId=null) {
        $this->load->model($this->_channel_name.'/gallery_items');
        if ($eventId == NULL) {
            $where = array('playme'=>1, 'transcoded'=>1);
        } else {
            $where = $this->getOptionDataPlaymeByEvent($eventId);
        }
        
        
        $this->data['playme_video'] = false;
        $dataVideo = $this->gallery_items->get_select_where('*', $where, FALSE, 1);
        /*set to default image of cover image empty */
        if ($dataVideo[0]->cover_image == '' || $dataVideo[0]->cover_image == '0') {
           $dataVideo[0]->cover_image = config_item('userfiles').'wow/news/roadshow_default.jpg';
        } else {
           $dataVideo[0]->cover_image =  config_item('userfiles') . 'wow' . '/gallery/image/' . $dataVideo[0]->cover_image;
        }        
        //die(var_dump($where,$dataVideo));
        $this->data['playme_video'] = $dataVideo;
    }
    
    /**
     * 
     * @param int $eventId
     * @return array
     */
    protected function getOptionDataPlaymeByEvent($eventId) {
        $where = array('playme'=>1, 'event_id' => $eventId, 'transcoded'=>1);
        $countData = $this->countDataFromModel('uz_'.$this->gallery_items->get_tablename(), $where);
        
        if ($countData->total_records == 0) {
            $where = array('playme'=>1, 'transcoded'=>1);
        }
        return $where; 
    }


    /**
     * 
     * @param int $id
     * @return MY_Model
     */
    protected function getDataPlayme($id=NULL) {
        $this->load->model($this->_channel_name.'/gallery_items');
        if ($id == NULL) {
            $where = array('playme'=>1, 'transcoded'=>1);
            $dataPlayme = $this->gallery_items->get_select_where('*', $where, FALSE, 1);            
        } else {
            $dataPlayme = $this->gallery_items->get($id);
        }
        
        if (!is_array($dataPlayme)) {
            $dataPlayme = array($dataPlayme);
        }
        /*set to default image of cover image empty */
        if ($dataPlayme[0]->cover_image == '' || $dataPlayme[0]->cover_image == '0') {
           $dataPlayme[0]->cover_image = config_item('userfiles').'wow/news/roadshow_default.jpg';
        } else {
            $dataPlayme[0]->cover_image = config_item('userfiles') . 'wow' . '/gallery/image/' . $dataPlayme[0]->cover_image;
        }
        return $dataPlayme;
        
    }



    /**
     * Mengambil jumlah data dari table
     * @param string $tableName
     * @param array string $where
     * @return int
     */
    protected function countDataFromModel($tableName, $where=array()) {
        $sql = 'SELECT COUNT(*) as total_records FROM '.$tableName.' WHERE ';
        $addSql = '';
        foreach($where as $key => $w) {
            if (is_numeric($w)) {
                $addSql .= ($addSql == '')? ' `'.$key."` = ".$w." ": 'AND `'.$key."` = ".$w." "; 
            } else {
                $addSql .= ($addSql == '')? ' `'.$key."` = '".$w."' ":'AND `'.$key."` = '".$w."' ";
            }
        } 
        $sql .= $addSql; 
        $count = $this->db->query($sql)->row();
        return $count;
    }
    
    /**
     * Initial menu for all menu page
     */
    protected function initMenuWOW() {
        $this->load->model($this->_channel_name . '/wow_event_m');
        $this->load->model($this->_channel_name . '/content_static');
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;
    }
}
