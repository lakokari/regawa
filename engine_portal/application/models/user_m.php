<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of user_m
 *
 * @author master
 */
class User_m extends MY_Model {
    const GROUP_ADMIN = 1;
    const GROUP_MEMBER = 2;    
    
    protected $TYPE_INTERNAL = 0;
    protected $TYPE_EXTERNAL = 1;
    
    protected $_table_name = 'users';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'type, group_id, u_name';
    
    protected $fb_clientid = 'facebook';
    protected $twitter_clientid = 'twitter';
    
    protected $avatar_default = 'default/default.png';
    
    
    
    public $rules_login = array(
        'u_name' => array(
            'field' => 'u_name', 
            'label' => 'Username', 
            'rules' => 'trim|required|xss_clean'
        ), 
        'u_password' => array(
            'field' => 'u_password', 
            'label' => 'Password', 
            'rules' => 'trim|required'
        )
    );
    public $rules_new = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Fullname', 
            'rules' => 'trim|required|xss_clean'
        ), 
        'u_name' => array(
            'field' => 'u_name', 
            'label' => 'Username', 
            'rules' => 'trim|required|callback_unique_user_name|xss_clean'
        ), 
        'email' => array(
            'field' => 'email', 
            'label' => 'Email', 
            'rules' => 'trim|valid_email|required'
        ),
        'u_password' => array(
            'field' => 'u_password', 
            'label' => 'Password', 
            'rules' => 'trim|min_length[5]|required'
        ),
        'u_password_conf' => array(
            'field' => 'u_password_conf', 
            'label' => 'Password Confirmation', 
            'rules' => 'matches[u_password]|required'
        )
        
    );
    
    public $rules_edit = array(
        'u_name' => array(
            'field' => 'u_name', 
            'label' => 'Username', 
            'rules' => 'trim|required|callback_unique_user_name|xss_clean'
        ), 
        'email' => array(
            'field' => 'email', 
            'label' => 'Email', 
            'rules' => 'trim|valid_email'
        ),
        'group_id' => array(
            'field' => 'group_id', 
            'label' => 'Group', 
            'rules' => 'trim|required'
        )
    );
    
    public $rules_change_password = array(
        'old_password' => array(
            'field' => 'old_password', 
            'label' => 'Old Password', 
            'rules' => 'trim|callback_user_check_oldpassword|required'
        ),
        'new_password' => array(
            'field' => 'new_password', 
            'label' => 'New Password', 
            'rules' => 'trim|min_length[5]|required'
        ),
        'new_password_conf' => array(
            'field' => 'new_password_conf', 
            'label' => 'New Password Confirmation', 
            'rules' => 'matches[new_password]|required'
        )
    );
    
    function __construct() {
        parent::__construct();
        
        //load usergroup model
        $this->load->model('usergroup_m');
    }
    
    public function user_group($type='Member'){
        if ($type=='Member')
            return self::GROUP_MEMBER;
        elseif ($type=='Super Admin')
            return self::GROUP_ADMIN;
        else 
            return $this->get_groupid_byname ($type);
    }
    
    public function get_groupid_byname($group_name='Member'){
        $row = $this->db->select('id')->from('user_groups')->where('group', $group_name)->get()->row();
        if ($row)
            return $row->id;
        else
            return FALSE;
    }
    
    public function login(){
        $u_name = $this->input->post('u_name', TRUE); //XSS_FILTER
        $u_password = $this->input->post('u_password');
        //get user with username $u_user
        $user = $this->get_by(array(
            'u_name' =>$u_name,
            'u_password'    => $this->hash($u_password),
            'type'  => $this->TYPE_INTERNAL,
            'is_activeYN'   => 'y'
        ), TRUE);
        
        if (count($user)){
            //valid registered user
            $this->create_session($user);
            
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function logout(){
        $userid = $this->session->userdata('userid');
        if ($userid){
            //set user record in database
            $data = array('is_onlineYN' => 'n');
            $this->save($data, $userid);
        }
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
            return (isset($roles[$role_id])?(bool)$roles[$role_id]:FALSE);
    }
    
    public function create_session($user){
        //Update user status in database
        $this->update_session($user->id);
        
        if (!isset($user->client_id)||!isset($user->client_app))
        {
            //get user client_app and cliet_id if user type is external
            if ($user->type!=$this->TYPE_INTERNAL){
                $get_user_ext_info = $this->db->select('client_userid, client_app')->get('userclient_map')->row();
                $user->client_id = $get_user_ext_info->client_userid;
                $user->client_app = $get_user_ext_info->client_app;
            }else{
                $user->client_id = 0;
                $user->client_app = 'uzone';
            }
        }
        
        //if user external, avatar already get when successfull login
        if ($user->type == $this->TYPE_INTERNAL){
            if ($user->avatar!='')
                $user->avatar = config_item('userfiles'). 'avatar/'.$user->avatar;
            else
                $user->avatar = config_item('userfiles'). 'avatar/'.$this->avatar_default;
        }else{
            $user->avatar = $this->session->userdata('client_avatar');
        }
        //Create the session
        $userdata = array(
            'loggedin'  => TRUE,
            'userid'    => $user->id,
            'username'  => $user->u_name,
            'group_id'  => $user->group_id,
            'type'      => $user->type,
            'client_id' =>  $user->client_id,
            'client_app'=>  $user->client_app,
            'name'      => $user->name,
            'email'     => $user->email,
            'avatar'    => $user->avatar,
            'wow_event_id' => $user->wow_event_id //tambahan reza
            //'roles'     => $this->get_user_roles($user->group_id)
        );
        
        $this->session->set_userdata($userdata);
        
        //create session rule
        $this->_create_session_rules($user->group_id);
    }
    
    public function update_session($userid){
        $data = array(
            'is_onlineYN'   =>  'y',
            'last_activity' =>  time()
        );
        
        $this->save($data, $userid);
    }
    
    public function hash($string){
        return hash('sha512', $string . config_item('encryption_key'));
    }
    
    public function can_cp(){
        $can_cp = $this->session->userdata('group_id')==self::GROUP_ADMIN || $this->is_user_has_access('CAN_CP')== TRUE;
        return ($can_cp) ;
    }
    
    public function is_super(){
        return ($this->session->userdata('group_id')==self::GROUP_ADMIN);
    }
    
    public function super_id(){
        return self::GROUP_ADMIN;
    }
    
    protected function _get_user_roles($group_id)
    {
        $roles = array();
        //get all roles
        $qs = $this->db->select('id, role')->get('roles')->result();
        
        if (count($qs)){
            //If user in SUPER ADMIN group, everything is enabled
            
            foreach($qs as $item){
                $roles[$item->id] = array(
                    'role_id'   =>  $item->id,
                    'role'      =>  $item->role,
                    'enabled'   =>  ($group_id==self::GROUP_ADMIN)?TRUE:FALSE
                );
            }
            
            //for group not SUPER ADMIN, only role which exists will be updated
            if ($group_id!=self::GROUP_ADMIN)
            {
                
                $this->db->select('role,enabled');
                $this->db->where(array('group_id'=>$group_id));
                $user_roles = $this->db->get('user_roles')->result();

                if ($user_roles&&count($user_roles))
                {
                    //start iteration
                    foreach($user_roles as $item){
                        if (isset($roles[$item->role]))
                            $roles[$item->role]['enabled'] = $item->enabled==1?TRUE:FALSE;
                            //$roles[$item->role] = $item->enabled==1?TRUE:FALSE;
                    }
                }
            }
            
        }
        
        return $roles;
    }
    
    protected function _create_session_rules($group_id){
        //Load rules
        $rules = $this->_get_user_roles($group_id);
        
        $session_rules = array();
        $session_rule_prefix = '_group_rule_';
        foreach($rules as $role){
            $session_rules [$session_rule_prefix . $role['role']] = $role['enabled'];
        }
        
        //set in session
        $this->session->set_userdata($session_rules);
    }
    
    public function is_user_has_access($role){
        $session_rule_prefix = '_group_rule_';
        
        return $this->session->userdata($session_rule_prefix . $role);
    }
    public function delete($id) {
        //check if user is root, forbidden
        $user = $this->get($id, TRUE, 'row');
        if ($user && $user->u_name!='root'){
            //check if user is client user (external)
            if ($user->type!=0){
                //delete userclient user row
                $this->db->where('userid', $user->id)->delete('userclient_map');
            }
            parent::delete($id);
        }
        else
            return FALSE;
    }
    
    /**
     * Create external user
     * @param type $data
     * @return boolean
     */
    public function create_ext_user($data){
        $data['type'] = $this->TYPE_EXTERNAL;
        $data['group_id'] = self::GROUP_MEMBER;
        $data['last_activity'] = time();
        $data['creation_date'] = time();
        
        
        $this->save($data);
        
        $userid = $this->get_inserted_id();
        
        if ($userid)
            return $this->get($userid, TRUE, 'row');
        else
            return FALSE;
    }
}

/*
 * file location: /application/models/user_m.php
 */
