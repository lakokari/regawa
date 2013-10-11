<?php

/**
 * Description of Synctv: Syncronize apps store channel
 *
 * @author master
 */
class Synctv extends Syncronize {
    protected $tv = NULL;
    protected $channel_name = 'tv';
    
    function __construct() {
        parent::__construct();
        
        //load Melon Library
        $this->CI->load->library('TVLib');
        $this->tv = $this->CI->tvlib;
    }
    
    public function sync_stations($deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/stations');
        $MM = $this->CI->stations;
        
        //get new category from api
        $data = $this->tv->tv_channels();
        
        //only update if success return from api
        if ($data){
            
            //remove old category in database;
            if ($deleteOld)
                $MM->empty_table();
            
            if (count($data)>0)
            {
                $existing_fields = $MM->get_fields();
                
                foreach($data as $nd){
                    $data_update = array();
                    foreach($existing_fields as $field_name){
                        if (isset($nd->$field_name)&&$nd->$field_name!=NULL){
                            $data_update[$field_name] = $nd->$field_name;
                        }
                    }
                    
                    //insert new data
                    $MM->save($data_update); $count_update++;
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    /**
     * Syncronize all TV streamurl for all type and tv stations
     * @param type $deleteOld
     * @return int
     */
    public function sync_streamurl($deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/tv_streamurl');
        $MM = $this->CI->tv_streamurl;
        
        //we have to load the station model to iterate all station (tvcode)
        $this->CI->load->model($this->channel_name.'/stations');
        $stations = $this->CI->stations->get_select_where('tv_code');
        
        //we also have to iterate for all streamtypes
        $streamtypes = array('tvod', 'live');
        //start the iteration
        if ($stations){
            foreach($stations as $station){
                foreach ($streamtypes as $st_type){
                    //get data from api
                    $sync_get = $this->tv->stream_url($st_type, $station->tv_code);
                    
                    //only continue if success and has new data
                    if ($sync_get){
                        //if delete parameter is true, delete the old data
                        if ($deleteOld)
                            $MM->delete_where(array('streamtype'=>$st_type, 'tvcode'=>$station->tv_code, 'source'=>0));
                        
                        //Save the new sync data to our database
                        foreach($sync_get as $item){
                            $sync_save = array(
                                'streamtype'    =>  $st_type,
                                'tvcode'        =>  $station->tv_code,
                                'url_streaming' =>  (isset($item['url_streaming'])&&$item['url_streaming']) ? $item['url_streaming']:'',
                                'source'        =>  0
                            );
                            
                            $MM->save($sync_save);
                            $count_update++;
                        }
                    }
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    public function sync_vod($deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/tv_vod');
        $MM = $this->CI->tv_vod;
        
        //get new VOD from api
        $data = $this->tv->video_on_demand();
        
        //only update if success return from api
        if ($data){
            
            //remove old category in database;
            if ($deleteOld)
                $MM->empty_table();
            
            if (count($data)>0)
            {
                $existing_fields = $MM->get_fields();
                
                foreach($data as $nd){
                    $data_update = array();
                    foreach($existing_fields as $field_name){
                        if (isset($nd[$field_name])&&$nd[$field_name]!=NULL){
                            $data_update[$field_name] = $nd[$field_name];
                        }
                        
                        $data_update['source'] = 0; //tag API
                    }
                    
                    //insert new data
                    $MM->save($data_update); $count_update++;
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    public function sync_schedules($startdate=NULL, $day_length=5, $deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/tv_schedules');
        $MM = $this->CI->tv_schedules;
        
        //we have to load the station model to iterate all station (tvcode)
        $this->CI->load->model($this->channel_name.'/stations');
        $stations = $this->CI->stations->get_select_where('tv_code');
        
        if (!$startdate) $startdate = date('Y-m-d');
        
        //create array of date to sync the schedules
        $dates = array();
        for($i=0; $i<$day_length; $i++){
            $dates[] = date('Y-m-d', strtotime($startdate .' -'.$i.' day'));
        }
        
        //start the iteration
        if ($stations){
            //get schedule by tvcode
            foreach($stations as $station){
                
                //get schedule for each date
                foreach ($dates as $date){
                    //get data from api
                    $sync_get = $this->tv->get_schedules_tv($station->tv_code, $date);
                    
                    //only continue if success and has new data
                    if ($sync_get){
                        //if delete parameter is true, delete the old data
                        if ($deleteOld)
                            $MM->delete_where(array('tvcode'=>$station->tv_code, 'date'=>$date, 'source'=>0));
                        
                        //get our table field
                        $existing_fields = $MM->get_fields();
                        
                        //Save the new sync data to our database
                        foreach($sync_get as $nd){
                            $sync_save = array(
                                'tvcode'        =>  $station->tv_code,
                                'source'        =>  0
                            );
                            
                            //generate uzine tv schedule id for later use
                            $sync_save['schedule_genid'] = $station->tv_code. strtotime($nd['start_time']);
                            
                            foreach($existing_fields as $field_name){
                                if ($field_name=='tvcode'){
                                    $sync_save['tvcode'] = $station->tv_code;
                                }elseif ($field_name=='source'){
                                    $sync_save['source'] = 0;
                                }elseif ($field_name=='date'){
                                    $sync_save['date'] = date('Y-m-d',  strtotime($nd['start_time']));
                                }else{
                                    if (isset($nd[$field_name])&&$nd[$field_name]!=NULL){
                                        $sync_save[$field_name] = $nd[$field_name];
                                    }
                                }
                            }

                            //insert new data
                            $MM->save($sync_save); $count_update++;
                        }
                    }
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    public function sync_schedule($tvcode, $date=NULL, $deleteOld=TRUE){
        //set default date to current date
        if (!$date) $date = date('Y-m-d');
        
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/tv_schedules');
        $MM = $this->CI->tv_schedules;
        
        //try to sync for this tvcode and date
        $sync_get = $this->tv->get_schedules_tv($tvcode, $date);
        
        //only continue if success and has new data
        if ($sync_get){
            //if delete parameter is true, delete the old data
            if ($deleteOld)
                $MM->delete_where(array('tvcode'=>$tvcode, 'date'=>$date, 'source'=>0));
                        
            //get our table field
            $existing_fields = $MM->get_fields();
                        
            //Save the new sync data to our database
            foreach($sync_get as $nd){
                $sync_save = array(
                    'tvcode'        =>  $tvcode,
                    'source'        =>  0
                );
                           
                //generate uzine tv schedule id for later use
                $sync_save['schedule_genid'] = $tvcode.'_'. strtotime($nd['start_time']);
                            
                foreach($existing_fields as $field_name){
                    if ($field_name=='tvcode'){
                        $sync_save['tvcode'] = $tvcode;
                    }elseif ($field_name=='source'){
                        $sync_save['source'] = 0;
                    }elseif ($field_name=='date'){
                        $sync_save['date'] = date('Y-m-d',  strtotime($nd['start_time']));
                    }else{
                        if (isset($nd[$field_name])&&$nd[$field_name]!=NULL){
                            $sync_save[$field_name] = $nd[$field_name];
                        }
                    }
                }

                //insert new data
                $MM->save($sync_save); $count_update++;
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    public function sync_tovi_items($deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/tovi_items');
        $MM = $this->CI->tovi_items;
                
        //get new metdata from api
        //need to know how many total record is, so we call pagesize=1 only, first.
        $data = $this->tv->tovi('c_tokovideo', 'C_TokoVideo_International', 1, 0, 1);
        if ($data && isset($data['total'])){
            //get the total size
            $pagesize = $data['total'];
            
            //now we call with total page size
            $data = $this->tv->tovi('c_tokovideo', 'C_TokoVideo_International', 1, 0, $pagesize);
        }
        
        //only update if success return from api
        if ($data){
            //remove old category in database;
            if ($deleteOld)
                $MM->empty_table();
            
            if (count($data['programs'])>0)
            {   
                $existing_fields = $MM->get_fields();
                
                foreach($data['programs'] as $program){
                    $data_update = array();
                    //get info from program and video clips array
                    foreach ($program as $nd){
                        foreach($existing_fields as $field_name){
                            if (isset($nd[$field_name])&&$nd[$field_name]!=NULL){
                                $data_update[$field_name] = $nd[$field_name];
                            }
                        }
                        
                        $data_update['source'] = 0; //tag API
                    }
                    
                    //insert new data
                    $MM->save($data_update); $count_update++;
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
}

?>
