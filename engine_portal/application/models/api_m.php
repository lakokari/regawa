<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api_m
 *
 * @author master
 */
class Api_m extends MY_Model {
    
    protected $_table_name = 'api_update';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'last_update';
    
    function __construct() {
        parent::__construct();
    }
    
    public function api_last_update($channel_name, $api_name, $category_id=0, $subcategory_id=0, $item_id=0, $item_tag=NULL){
        $data = array(
            'channel_name'  =>  $channel_name,
            'api_name'      =>  $api_name,
            'category_id'   =>  $category_id,
            'subcategory_id'=>  $subcategory_id,
            'item_id'       =>  $item_id,
            'item_tag'      =>  $item_tag,
            'last_update'   =>  date('Y-m-d')
        );
        
        $where = array('channel_name'=>$channel_name,'api_name'=>$api_name);
        if ($category_id) $where['category_id'] = $category_id;
        if ($subcategory_id) $where['subcategory_id'] = $subcategory_id;
        if ($item_id) $where['item_id'] = $item_id;
        if ($item_tag) $where['item_tag'] = $item_tag;
        //check if exist
        $row = $this->get_by($where, TRUE);
        if ($row){
            $id  = $row->id;
            
            //update
            
            $this->save($data, $id);
        }else{
            $this->save($data);
        }
    }
    
    public function is_feature_syncd_today($where=NULL){
        if (!$where || !is_array($where))
        {
            $where = array(
                'channel_name'      =>  '',
                'api_name'          =>  '',
                'last_update' =>  date('Y-m-d')
            );
        }
        
        $found = $this->get_count($where);
        return ($found>0);
    }
}

?>
