<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Item_m
 *
 * @author master
 */
class Usergroup_m extends MY_Model {    
    protected $_table_name = 'user_groups';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    public $rules = array(
        'group' => array(
            'field' => 'group', 
            'label' => 'Group name', 
            'rules' => 'trim|required|callback_unique_groupname|xss_clean'
        ), 
        'removable' => array(
            'field' => 'removable', 
            'label' => 'Removable', 
            'rules' => 'numeric|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
    
    function get_group_name($group_id){
        $row =  $this->db->select('group')->where('id',$group_id)->get($this->_table_name)->row();
        if ($row)
            return $row->group;
        else
            return FALSE;
    }
}

/*
 * file location: /application/models/user_m.php
 */
