<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Radio
 *
 * @author master
 */
class Channel extends U_Controller {
    
    protected $_channel_name = 'radio';
    
    function __construct() {
        parent::__construct();      
        
        //load Radio lib
        $this->load->library('radio');
    }
    
    public function index(){     
        $this->load->model('radio/model_radio');
        $this->load->model($this->_channel_name.'/category');
        $this->data['sod_cat_list'] = $this->category->get();
        
        //if search action to load podcast
        if (!empty($_GET['search_podcast'])) {
            $url_api_search = "http://www.diradio.net/apis/data/search/";
            $input_search   = $url_api_search.$_GET['search_podcast'];
            $this->data['search_podcast'] = json_decode(file_get_contents($input_search ));
        }
        
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/index';
        $this->load->view('_layout_main', $this->data);
    }
    
    public function list_rod($rodId=null) {
        $this->load->model('radio/radio_sod_items');
        $this->load->model('radio/radio_sod_sub_category');
        $this->load->model('radio/radio_sod_category');
        
        if (!$rodId) $rodId = $this->input->post('rodId');
        
        if(empty($rodId)){
            $rodId = 1;
        }
        
        //get sub category title by sub category id
        $sod_subcategory = $this->radio_sod_sub_category->get($rodId, TRUE);
        $this->data['sod_title'] = $sod_subcategory->sub_category;
        
        //get category name
        $sod_category = $this->radio_sod_category->get($sod_subcategory->id_category, TRUE);
        $this->data['sod_category'] = $sod_category->category;
        
        //sod data
        $sod = $this->radio_sod_items->get_offset('*', array(
            'sod_sub_category_id'   =>  $rodId,
            'showed_YN'             =>  'y'
        ),0, 13);
        foreach($sod as $item){
            $item->attachment = config_item('api_sync') .'radio/' . $item->attachment;
            
            $this->data['sod'] [] = $item;
        }
        
        $this->load->view('channel/'.$this->_channel_name.'/list_rod', $this->data);
    }
    
    public function load_chart_attack(){
        $this->load->model('radio/mostplayed_lastweek');
        $this->load->model('radio/mostplayed_lastmonth');
        /*************** CHART LAST WEEK *****************/
        
        $mostplayed_lastweek = $this->mostplayed_lastweek->get_offset('*', NULL, 0, 10);
        
        $mostly_week_parsed = array();
        foreach($mostplayed_lastweek as $item){
            $item->attachment = config_item('api_sync') . $this->_channel_name . '/' . $item->attachment;
            $mostly_week_parsed[] = $item;
        }
        $this->data['chart_lastweeks'] = $mostly_week_parsed;
        
        /*************** CHART LAST MONTH *****************/
        
        $mostplayed_lastmonth = $this->mostplayed_lastmonth->get_offset('*', NULL, 0, 10);
        
        $mostly_month_parsed = array();
        foreach($mostplayed_lastmonth as $item){
            $item->attachment = config_item('api_sync') . $this->_channel_name . '/' . $item->attachment;
            $mostly_month_parsed[] = $item;
        }
        $this->data['chart_lastmonths'] = $mostly_month_parsed;
        //exit(var_dump($mostly_month_parsed));
    
        $this->load->view('channel/'.$this->_channel_name.'/chart_attack', $this->data);
    }
    
    public function load_best_podcast(){
        $this->load->model('radio/radio_sod_items');
        $this->load->model('radio/radio_sod_sub_category');
        
        /*************** BEST PODCAST INDONESIA *****************/  
        $bestpostcast_indonesia = $this->radio_sod_items->get_offset('*', array(
            'sod_subname'           =>  'pop-indonesia',
            'showed_YN'             =>  'y'
        ),0, 20);
        foreach($bestpostcast_indonesia as $item){
            $item->attachment = config_item('api_sync') .'radio/' . $item->attachment;
            
            $this->data['bestpodcast_indonesia'] [] = $item;
        }
        /*************** BEST PODCAST BARAT *****************/
        $bestpostcast_barat = $this->radio_sod_items->get_offset('*', array(
            'sod_subname'           =>  'pop-barat',
            'showed_YN'             =>  'y'
        ),0, 20);
        foreach($bestpostcast_barat as $item){
            $item->attachment = config_item('api_sync') .'radio/' . $item->attachment;
            
            $this->data['bestpodcast_barat'] [] = $item;
        }
        
        $this->load->view('channel/'.$this->_channel_name.'/best_podcast', $this->data);
    }
    
    public function load_radio_req(){
        $this->load->model('radio/model_radio');
        $this->data['list_radio_data_request'] = $this->model_radio->getListRadioDataRequest();
        
        $this->load->view('channel/'.$this->_channel_name.'/radio_request', $this->data);
    }
    
    public function data_request(){
        if(!empty($_GET['api_url'])) { $url_api = $_GET['api_url']; } else { $_GET['api_url'] = ""; }
        
        $this->data['view_radio_req'] = json_decode(file_get_contents($url_api));
        
        $this->load->view('channel/'.$this->_channel_name.'/view_radio_req', $this->data);
    }
    
    public function load_radio_station(){
        $this->load->model('radio/items','radio_stations_m');
        
        $radio_stations = $this->radio_stations_m->get();
        foreach($radio_stations as $radio){
            
            //update image url
            $radio->radio_image = config_item('api_sync') .'radio/' . $radio->radio_image;
            
            $this->data['listRadio_all'] [] = $radio ;
        }
        
        
        
        $this->load->view('channel/'.$this->_channel_name.'/list_radio_station', $this->data);
    }
    
    public function search_podcast(){
        $keyword = $this->input->post('keyword',TRUE);
        //if search action to load podcast
        if (!empty($_GET['search_podcast'])) {
            $url_api_search = "http://www.diradio.net/apis/data/search/";
            $input_search   = $url_api_search.$keyword ;
            $this->data['search_podcast'] = json_decode(file_get_contents($input_search ));
        }
        $this->load->view('channel/'.$this->_channel_name.'/search_podcast', $this->data);
    }

}

?>
