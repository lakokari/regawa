<?php

/**
 * Description of Syncapps: Syncronize apps store channel
 *
 * @author master
 */
class Syncapps extends Syncronize {
    protected $apps = NULL;
    protected $channel_name = 'apps';
    
    function __construct() {
        parent::__construct();
        
        //load Melon Library
        $this->CI->load->library('Apstore');
        $this->apps = $this->CI->apstore;
    }
    
    public function category_all($deleteOld = TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model('apps/category');
        $MM = $this->CI->category;
        
        //get new category from api
        $data = $this->apps->category();
        
        //only update if success return from api
        if ($data && !isset($data->error_code)){
            
            //remove old category in database;
            if ($deleteOld)
                $MM->empty_table();
            
            if ($data->item_count>0)
            {
                $existing_fields = $MM->get_fields();
                
                foreach($data->categories as $nd){
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
    
    function syncronize_items_by_category($category_id, $deleteOld=TRUE)
    {
        $count_update = 0;
        //load category model
        $this->CI->load->model('apps/items');
        $MM = $this->CI->items;
        
        //get new category from api
        $data = $this->apps->category($category_id, 0, 500);  // 500 records to sync
        
        //only update if success return from api
        if ($data && !isset($data->error_code)){
            
            //remove old category in database;
            if ($deleteOld)
                $MM->delete_where(array('category_id'=>$category_id));
            
            if ($data->item_count>0)
            {
                $existing_fields = $MM->get_fields();
                
                foreach($data->items as $nd){
                    $data_update = array();
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
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        
        return $count_update;
    }
    
    function sync_featured($deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model('apps/featured');
        $MM = $this->CI->featured;
        
        //get new category from api
        $data = $this->apps->featured(); 
        
        //only update if success return from api
        if ($data && !isset($data->error_code)){
            
            //remove old category in database;
            if ($deleteOld)
                $MM->empty_table();
            
            if ($data->item_count>0)
            {
                $existing_fields = $MM->get_fields();
                
                foreach($data->items as $nd){
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
