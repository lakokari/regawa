<?php

/**
 * Description of Syncradio: Syncronize radio channel
 *
 * @author master
 */
class Syncradio extends Syncronize {
    protected $api = NULL;
    protected $channel_name = 'radio';
    protected $concate_tag = '|';
    /**
     *
     * Mapping fields CMS local data to API
     */
    public $usee_fields_map = array(
        'radio_id'          =>  'id',
        'radio_name'        =>  'radio_name',
        'radio_city'        =>  'radio_city',
        'radio_province'    =>  'radio_province',
        'live_stream'       =>  'live_stream',
        'radio_image'       =>  'big_logo2'
    );
    
    public $sr_fields_map = array(
        'radio_id'          =>  'id',
        'radio_name'        =>  'name',
        'radio_city'        =>  'kota',
        'radio_province'    =>  'namapropinsi',
        'live_stream'       =>  'sitea_dd|url_stream_stereo',
        'radio_image'       =>  'pathlogo'
    );
    
    function __construct() {
        parent::__construct();
        
        //load Qbaca Library
        $this->CI->load->library('Radio');
        $this->api = $this->CI->radio;
    }
    
    function syncronize_items_usee($deleteOld=TRUE)
    {
        //load category model
        $this->CI->load->model('radio/items');
        $MM = $this->CI->items;
        
        //set default variable value
        $radio_source = 'useetv';
        $radio_source_id = 1;
        $count_update = 0;
        
        //get new data from api
        $data = $this->api->items_usee();
        //only update if success return from api
        
        if (count($data)){
            //get how many size does its has
            if ($data&&$deleteOld)
                $MM->delete_where(array('radio_source'=>$radio_source));
            
            foreach($data as $nd){
                $data_update = array();
                $data_update['radio_source'] = $radio_source;
                $data_update['radio_source_id'] = $radio_source_id;
                
                //start looping using fields mapping
                foreach($this->usee_fields_map as $local_field=>$api_field){
                    //check if any concate field
                    
                    if (strpos($api_field, $this->concate_tag)){
                        $data_update[$local_field] = ''; //set initial value
                        $api_arr_fields = explode($this->concate_tag, $api_field);
                        
                        for($i=0; $i<count($api_arr_fields); $i++){
                            $data_update[$local_field].= '/'.$nd->$api_arr_fields[$i];
                        }
                    }
                    else
                    {
                        if ($local_field=='radio_image')
                            $data_update[$local_field] = 'http://cms.useetv.com/files/images/'. $nd->$api_field;
                        else
                            $data_update[$local_field] = $nd->$api_field;
                    }
                }
                //insert new data
                $MM->save($data_update); $count_update++;
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    function syncronize_items_sr($deleteOld=TRUE)
    {
        //load category model
        $this->CI->load->model('radio/items');
        $MM = $this->CI->items;
        
        //set default variable value
        $radio_source = 'suararadio';
        $radio_source_id = 2;
        $count_update = 0;
        
        //get new data from api
        $data = $this->api->items_sr();
        //only update if success return from api
        
        if (count($data)){
            //get how many size does its has
            if ($data&&$deleteOld)
                $MM->delete_where(array('radio_source'=>$radio_source));
            
            foreach($data as $nd){
                $data_update = array();
                $data_update['radio_source'] = $radio_source;
                $data_update['radio_source_id'] = $radio_source_id;
                
                //start looping using fields mapping
                foreach($this->sr_fields_map as $local_field=>$api_field){
                    //check if any concate field
                    
                    if (strpos($api_field, $this->concate_tag)){
                        $data_update[$local_field] = ''; //set initial value
                        $api_arr_fields = explode($this->concate_tag, $api_field);
                        
                        for($i=0; $i<count($api_arr_fields); $i++){
                            $data_update[$local_field].= '/'. $nd->$api_arr_fields[$i];
                        }
                    }
                    else
                    {
                        $data_update[$local_field] = $nd->$api_field;
                    }
                }
                
                //insert new data
                $MM->save($data_update); $count_update++;
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    function syncronize_items_all(){
        $count_update  = 0;
        
        //sync usee
        $count_update += $this->syncronize_items_usee();
        
        //sync suararadio
        $count_update += $this->syncronize_items_sr();
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
}

?>
