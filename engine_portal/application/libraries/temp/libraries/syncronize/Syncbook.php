<?php

/**
 * Description of Syncbook: Syncronize book channel
 *
 * @author master
 */
class Syncbook extends Syncronize {
    protected $api = NULL;
    protected $channel_name = 'book';
    
    function __construct() {
        parent::__construct();
        
        //load Qbaca Library
        $this->CI->load->library('Qbook');
        $this->api = $this->CI->qbook;
        $this->api->_format = 'array';
    }
    
    function syncronize_items_by_category($category_name, $category_id=0, $deleteOld=TRUE)
    {
        $count_update = 0;
        //load category model
        $this->CI->load->model('book/items');
        $MM = $this->CI->items;
        
        //get new category from api
        $data = $this->api->get_by_category($category_name, 1); //test to get how many size        
        //only update if success return from api
        
        if (isset($data->status) && (bool)$data->status == TRUE){
            //get how many size does its has
            $totalSize = $data->count;
            //Now we get all data
            $data = $this->api->get_by_category($category_name, $totalSize);
            
            // if 0, get category_id on our database by category_name
            if ($category_id==0)
            {
                $this->CI->load->model('book/category');
                $category_id = @$this->CI->category->get_select_where('category_id', array('category_name'=>$category_name), TRUE)->category_id;
                if (!$category_id) $category_id = 0;
            }
            
            //start updating our database
            
            if ($data->count>0)
            {
                
                //remove old category in database;
                if ($data&&$deleteOld)
                    $MM->delete_where(array('category_id'=>$category_id));
            
                $existing_fields = $MM->get_fields();
                
                foreach($data->data as $nd){
                    $data_update = array();
                    $data_update['category_name'] = $category_name;
                    $data_update['category_id'] = $category_id;
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($nd->$field_name)&&$nd->$field_name!=NULL){
                                $data_update[$field_name] = $nd->$field_name;
                            }
                        }
                    }
                    
                    //insert new data
                    $MM->save($data_update); $count_update++;
                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__, $category_id);
        
        return $count_update;
    }
    
    function syncronize_items_all(){
        $count_update  = 0;
        
        $this->CI->load->model('book/category');
        $MM = $this->CI->category;
        
        foreach($MM->get() as $category){
            $count_update += $this->syncronize_items_by_category($category->category_name, $category->category_id);
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    function syncronize_feature($deleteOld=TRUE)
    {
        $count_update = 0;
        //load category model
        $this->CI->load->model('book/featured');
        $MM = $this->CI->featured;
        
        //get new category from api
        $data = $this->api->featured(); //test to get how many size        
        //only update if success return from api
        
        if (isset($data->status) && (bool)$data->status == TRUE){
            //start updating our database
            
            if ($data->count>0)
            {
                
                //remove old category in database;
                if ($data&&$deleteOld)
                    $MM->empty_table();
            
                $existing_fields = $MM->get_fields();
                
                foreach($data->data as $nd){
                    $data_update = array();
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($nd->$field_name)&&$nd->$field_name!=NULL){
                                $data_update[$field_name] = $nd->$field_name;
                            }
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
    
    function syncronize_topdownload($deleteOld=TRUE)
    {
        $count_update = 0;
        //load category model
        $this->CI->load->model('book/topdownload');
        $MM = $this->CI->topdownload;
        
        //get new category from api
        $data = $this->api->top_download(); //test to get how many size        
        //only update if success return from api
        
        if (isset($data->status) && (bool)$data->status == TRUE){
            //start updating our database
            
            if ($data->count>0)
            {
                
                //remove old category in database;
                if ($data&&$deleteOld)
                    $MM->empty_table();
            
                $existing_fields = $MM->get_fields();
                
                foreach($data->data as $nd){
                    $data_update = array();
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($nd->$field_name)&&$nd->$field_name!=NULL){
                                $data_update[$field_name] = $nd->$field_name;
                            }
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
}

?>
