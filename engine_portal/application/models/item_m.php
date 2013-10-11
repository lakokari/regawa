<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Item_m
 *
 * @author master
 */
class Item_m extends MY_Model {
    const GROUP_ADMIN = 1;
    const GROUP_MEMBER = 2;
    
    protected $_table_name = 'users';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'u_name';
    
    public $rules_login = array(
        'name' => array(
            'field' => 'u_name', 
            'label' => 'Username', 
            'rules' => 'trim|required|xss_clean'
        ), 
        'password' => array(
            'field' => 'u_password', 
            'label' => 'Password', 
            'rules' => 'trim|required'
        )
    );
    public $rules = array();
    
    function __construct() {
        parent::__construct();
    }
    
    public function login(){
        $u_name = $this->input->post('u_name', TRUE); //XSS_FILTER
        $u_password = $this->input->post('u_password');
        //get user with username $u_user
        $user = $this->get_by(array(
            'u_name' =>$u_name,
            'u_password'    => $this->hash($u_password)
        ), TRUE);
        
        if (count($user)){
            //valid registered user
            $userdata = array(
                'loggedin'  => TRUE,
                'userid'    => $user->id,
                'username'  => $u_name,
                'group_id'  => $user->group_id,
                'roles'     => $this->get_user_roles($user->group_id)
            );
            
            $this->session->set_userdata($userdata);
            
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function logout(){
        $this->session->sess_destroy();
    }
    
    public function is_loggedin(){
        return (bool) $this->session->userdata('loggedin');
    }
    
    public function has_access($role_id){
        $roles = $this->session->userdata('roles');
        
        if ($this->session->userdata('group_id')==self::GROUP_ADMIN)
            return TRUE;
        else
            return (isset($roles[$role_id])?$roles[$role_id]:FALSE);
    }
    
    public function hash($string){
        return hash('sha512', $string . config_item('encryption_key'));
    }
    
    public function get_user_roles($group_id=self::GROUP_MEMBER)
    {
        $roles = array();
        //get all roles
        $qs = $this->db->select('id')->get('roles')->result();
        
        if (count($qs)){
            //If user in SUPER ADMIN group, everything is enabled
            
            foreach($qs as $item){
                $roles[$item->id] = $group_id==self::GROUP_ADMIN;
            }
            
            //for group not SUPER ADMIN, only role which exists will be updated
            if ($group_id!=self::GROUP_ADMIN)
            {
                $this->db->select('role,enabled');
                $this->db->where(array('group_id'=>$group_id));
                $user_roles = $this->get('user_roles')->result();

                if (count($user_roles))
                {
                    //start iteration
                    foreach($user_roles as $item){
                        $roles[$item->role] = (bool) $roles->enabled;
                    }
                }
            }
            
        }
        
        return $roles;
    }
}

/*
 * file location: /application/models/user_m.php
 */
