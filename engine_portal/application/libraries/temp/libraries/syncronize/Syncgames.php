<?php

/**
 * Description of Syncradio: Syncronize game channel
 *
 * @author master
 */
class Syncgames extends Syncronize {
    protected $api = NULL;
    protected $channel_name = 'games';
    
    
    function __construct() {
        parent::__construct();
        
        //load Qbaca Library
        $this->CI->load->library('Gamelib');
        $this->api = $this->CI->gamelib;
    }
    
    function syncronize_categories($deleteOld=TRUE)
    {
        //load category model
        $this->CI->load->model($this->channel_name.'/category');
        $MM = $this->CI->category;
        
        $count_update = 0;
        
        //get all data from all items
        $data = $this->api->allgames();
        
        //load from japahit also
        $data_majapahit = $this->api->majapahit_online();
        //if any, merge result
        if (count($data_majapahit)){
            $data = array_merge($data, $data_majapahit);
        }
        //only update if success return from api
        
            
        
        if (count($data)){
            //get the categories data only
            $categories = array();
            foreach($data as $item){
                $cat_api = $item->categories;
                if (is_array($cat_api)){
                    foreach ($cat_api as $cat_api_item){
                        if (!in_array($cat_api_item, $categories)){
                            $categories [] = $cat_api_item;
                        }
                    }
                    
                }else{
                    if (!in_array($cat_api, $categories)){
                        $categories [] = $cat_api;
                    }
                }
            }
            
            //Now update category if any
            if (count($categories)){
                //delete if stated
                if ($deleteOld){
                    $MM->empty_table();
                }
                
                //start inserting data
                foreach($categories as $cat){
                    $MM->save(array('category_name'=>$cat));
                    $count_update++;
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    function syncronize_items($deleteOld=TRUE)
    {
        //load category model
        $this->CI->load->model($this->channel_name.'/items');
        $MM = $this->CI->items;
                
        //set default variable value
        $count_update = 0;
        
        //get new data from api
        $data = $this->api->allgames();
        //load from japahit also
        $data_majapahit = $this->api->majapahit_online();
        //if any, merge result
        if (count($data_majapahit)){
            $data = array_merge($data, $data_majapahit);
        }
        
        
        //only update if success return from api
        
        if (count($data)){
            //get how many size does its has
            if ($data&&$deleteOld)
                $MM->empty_table();
            
            foreach($data as $item){
                $data_update = array();
                $data_update['ID'] = $item->ID;
                $data_update['title'] = $item->title;
                $data_update['categories'] = implode(',',$item->categories);
                
                $meta = get_object_vars($item->meta);
                foreach($meta as $key=>$val){
                    /*
                    if ($key=='width'||$key=='height')
                        $val = 0;
                    */
                    if ($val!=NULL)
                        $data_update[$key] = $val;
                }
                /*
                foreach($meta as $meta_key=>$meta_val){
                    $data_update[$meta_key] = $meta_val;
                }*/
                //insert new data
                $MM->save($data_update); $count_update++;
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
}

?>
