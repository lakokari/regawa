<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of MY_Model
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class MY_Model extends CI_Model {
    
    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = '';
    protected $_timestamps = FALSE;
            
    public $rules = array();
    
    function __construct() {
        parent::__construct();
    }
    
    public function array_from_post(array $fields){
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = $this->input->post($field);
            
        }
        return $data;        
    }
    
    public function get_tablename(){
        return $this->_table_name;
    }
    
    public function get($id = NULL, $single = FALSE, $method = 'result'){
        if ($id != NULL) {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key, $id);
            $method = 'row';
        }
        elseif($single == TRUE) {
            $method = 'row';
        }
        
        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);            
        }
        
        return $this->db->get($this->_table_name)->$method();
    }
    
    public function get_new($properties = NULL){
        if (!$properties){
            $properties = array();
            $fields = $this->get_fields_data();
            foreach($fields as $field){
                $properties[$field->name] = $field->type=='INT'?0:'';
            }
        }
        
        $new = new stdClass();
        foreach($properties as $prop=>$val){
            $new->$prop = $val;
        }
        
        return $new;
    }
    
    public function get_select_where($fields = '*', $where=NULL, $single= FALSE){
        $this->db->select($fields);
        if ($where) $this->db->where($where);
        
        return $this->get(NULL, $single);
    }

    public function get_count($where=NULL){
        $this->db->select('count(*) as found');
        
        if ($where)
            $this->db->where($where);
        
        $row = $this->db->get($this->_table_name)->row();
        
        return $row->found;
    }
    
    public function get_offset($fields='*', $where=NULL, $offset=0, $limit=20, $method='result'){
        $this->db->select($fields);
        
        if ($where)
            $this->db->where($where);
        
        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);            
        }
        if ($limit > 0){
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        
        return $this->db->get($this->_table_name)->$method();
    }
    
    public function get_by($where, $single = FALSE){
        $this->db->where($where);
        return $this->get(NULL, $single);
    }
    
    public function get_like($like, $fields='*', $offset=0, $limit=20, $method='result'){
        if (!is_array($like))
            return FALSE;
        
        $this->db->select($fields);
        
        if ($this->array_is_assoc($like)){
            $like_field = $like['field'];
            $like_val = $like['value'];
            if (!isset($like['position'])){
                $like_pos = 'both';
            }else{
                $like_pos = $like['position'];
            }
            
            $this->db->like($like_field, $like_val, $like_pos);
        }else{
            $i= 0;
            foreach($like as $item){
                if ($i==0)
                    $this->db->like($item['field'], $item['value'], isset($item['position'])?$item['position']:'both');
                else
                    $this->db->or_like($item['field'], $item['value'], isset($item['position'])?$item['position']:'both');
                
                $i++;
            }
        }
        
        
        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);            
        }
        
        if ($limit >0){
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        
        return $this->db->get($this->_table_name)->$method();
    }
    
    /* helper */
    function array_is_assoc($array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
    
    public function get_like_count($like){
        
        if (!is_array($like))
            return FALSE;
        
        $like_field = $like['field'];
        $like_val = $like['value'];
        if (!isset($like['position'])){
            $like_pos = 'both';
        }else{
            $like_pos = $like['position'];
        }
        
        $this->db->select('count(*) as found');
        
        $this->db->like($like_field, $like_val, $like_pos);
        
        $row = $this->db->get($this->_table_name)->row();
        
        return $row->found;
    }
    
    public function get_wherein_count($wherein=NULL){
        $this->db->select('count(*) as found');
        
        if ($wherein)
        {
            foreach ($wherein as $key => $value) {
                $this->db->where_in($key, $value);
            }
            
        }
        
        $row = $this->db->get($this->_table_name)->row();
        
        return $row->found;
    }
    
    public function get_wherein_offset($fields = '*', $wherein_list='', $offset=0, $limit=20, $method='result'){
        $this->db->select($fields);
        
        if ($wherein_list)
        {
            $this->db->where_in($wherein_list);
        }
        
        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);            
        }
        if ($limit > 0){
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        
        return $this->db->get($this->_table_name)->$method();
    }
    
    public function get_wherenotin_offset($fields = '*', $where=NULL, $wherenotin=NULL, $offset=0, $limit=20, $method='result'){
        $this->db->select($fields);
        
        if ($where)
            $this->db->where($where);
        
        if ($wherenotin)
        {
            foreach ($wherenotin as $key => $value) {
                $this->db->where_not_in($key, $value);
            }
            
        }
        
        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_order_by);            
        }
        if ($limit > 0){
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        
        return $this->db->get($this->_table_name)->$method();
    }
    
    public function save($data, $id = NULL){
		
        // Set timestamps
        if ($this->_timestamps == TRUE) {
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        // Insert
        if ($id === NULL) {
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->db->insert_id();
        }
        // Update
        else {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);            
        }
        
        return $id;
    }
    
    public function get_inserted_id(){
        return $this->db->insert_id();
    }
    
    public function delete($id){
        $filter = $this->_primary_filter;
        $id = $filter($id);
        
        if (!$id) {
            return FALSE;            
        }
        
        $this->db->where($this->_primary_key, $id);
        $this->db->limit(1);
        $this->db->delete($this->_table_name);
        
        return $this->db->affected_rows();
    }
    
    public function delete_where($where){
        $this->db->where($where);
        $this->db->delete($this->_table_name);
        
        return $this->db->affected_rows();
    }
    
    public function delete_like($like){
        
        if (!is_array($like))
            return FALSE;
        
        $like_field = $like['field'];
        $like_val = $like['value'];
        if (!isset($like['position'])){
            $like_pos = 'both';
        }else{
            $like_pos = $like['position'];
        }
        
        $this->db->like($like_field, $like_val, $like_pos);
        
        $this->db->delete($this->_table_name);
        
        return $this->db->affected_rows();
    }
    
    public function empty_table($table_name = NULL){
        if (!$table_name) $table_name = $this->_table_name;
        $this->db->empty_table($table_name);
        return $this->db->affected_rows();
    }
    
    public function get_fields(){
        return $this->db->list_fields($this->_table_name);
    }
    
    public function get_fields_data(){
        return $this->db->field_data($this->_table_name);
    }
    /**
     * function log: to create application log history
     * @param array $data ('actor', 'action')
     */
    public function log($data){
        if (is_array($data)){
            //create datetime if not set
            if (!isset($data['log_date'])){
                $data['log_date'] = time();
            }
            
            if (!isset($data['ip_address'])){
                $data['ip_address'] = $this->session->userdata['ip_address'];
            }
            
            if (!isset($data['http_uri'])){
                $data['http_uri'] = $this->uri->uri_string();
            }
            //insert data into database logs
            
            $this->db->insert('logs', $data);
        }
    }
    
    public function my_upload($field_name, $config, &$message='',$initConfig = TRUE){
        
        $this->load->library('upload');
        
        if ($initConfig)
            $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload($field_name)){
            $message = $this->upload->display_errors();
            return FALSE;
        }
        else{
            return $this->upload->data();
        }
    }
    
    public function image_manipulation($config, &$message='', $type='resize'){
        $this->load->library('image_lib', $config); 

        if (!$this->image_lib->$type()){
            $message = $this->image_lib->display_errors();
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
}


/*
 * file location: engine/application/core/MY_Model.php
 */
?>
