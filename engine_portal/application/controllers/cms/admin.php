<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Admin
 *
 * @author master
 */
class Admin extends U_CMS_Controller {
    
    function __construct() {
        parent::__construct();
        
        //load channel list for channel sub menu
        $this->load->model('channel_m');
        $this->data['channel_list'] = $this->channel_m->get();
        
        //load library
        $this->load->library('table');
    }
    
    public function index(){
		//get group by group_id(session)
        $this->load->model('usergroup_m');

        $group = $this->usergroup_m->get($this->session->userdata('group_id'), TRUE)->group;

        switch($group){
            case 'Juri Wow':
                redirect('cms/juri/items');
                break;
            case 'Event Organizer Wow':
                redirect('cms/wow/news');
                break;
        }

        $this->data['page_title'] = 'Dashboard '. $this->session->userdata('group_id');
        

        //Load view
        $this->data['active_menu'] = 'home';
        $this->data['subview'] = 'cms/dashboard/index';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function userlist(){
        $this->data['page_title'] = 'User List';
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/list';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function useredit($userid=NULL){
        //load users model
        $this->load->model('user_m');
        
        $this->data['userid'] = $userid;
        
        // Set form
        if (!$userid)
            $rules = $this->user_m->rules_new;
        else
            $rules = $this->user_m->rules_edit;
        
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            if (!$userid){
                $data_post = $this->user_m->array_from_post(array('u_name','u_password','group_id','is_activeYN'));
                $data_post['u_password'] = $this->user_m->hash($data_post['u_password']);
            }
            else
                $data_post = $this->user_m->array_from_post(array('u_name','group_id','is_activeYN'));
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/userlist';
            if ($this->user_m->save($data_post, $userid)){
                redirect($retUrl); exit;
            }
        }
        
        $this->data['page_title'] = $userid?'Edit User':'Create User';
        $this->data['retUrl'] = 'cms/admin/userlist';
        
        if ($userid){
            $data = $this->user_m->get($userid);
        }else{
            $data = $this->user_m->get_new(array(
                'u_name'        =>  '',
                'u_password'    =>  '',
                'group_id'      =>  $this->user_m->user_group('Member'),
                'is_activeYN'   =>  'y'
                )
            );
        }
        
        $this->data['data'] = $data;
        
        //get user group list as dropdown
        $this->load->model('usergroup_m');
        $res_group = $this->usergroup_m->get();
        
        foreach ($res_group as $item){
            $this->data['groups'][$item->id] = $item->group;
        }
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function changemypwd(){
        //load users model
        $this->load->model('user_m');
        
        $userid = $this->session->userdata('userid');
        
        // Set form
        $rules = $this->user_m->rules_change_password;        
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $new_password = $this->input->post('new_password');
            $data_post['u_password'] = $this->user_m->hash($new_password);
            
            $retUrl = $this->input->post('retUrl'); if (!$retUrl) $retUrl = 'cms/userlist';
            if ($this->user_m->save($data_post, $userid)){
                $this->session->set_flashdata('error','Your password changed to successfully!. Your password no is '.$new_password );
                //redirect($retUrl); exit;
            }
        }
        
        $this->data['page_title'] = 'Change My Password';
        $this->data['retUrl'] = 'cms/admin/changemypwd';
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/change_password';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function user_check_oldpassword(){
        $userid = $this->session->userdata('userid');
        $password = $this->input->post('old_password');
        
        $where = array(
            'id'            =>  $userid,
            'u_password'    => $this->user_m->hash($password)
        );
        
        $this->db->where($where);
        $found = $this->user_m->get();
        if (!$found){
            $this->form_validation->set_message('user_check_oldpassword','%s did not match!');
            
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function grouplist(){
        $this->data['page_title'] = 'Group List';
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/grouplist';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function groupedit($groupid=NULL){
        //load groups model
        $this->load->model('usergroup_m');
        
        $this->data['groupid'] = $groupid;
        
        // Set form
        $rules = $this->usergroup_m->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $data_post = $this->usergroup_m->array_from_post(array('group'));
            if ($this->usergroup_m->save($data_post, $groupid)){
                redirect('cms/admin/grouplist'); exit;
            }else{
                $this->session->set_flashdata('error','Update Failed!');
            }
        }
        
        if ($groupid){
            $data = $this->usergroup_m->get($groupid);
        }else{
            $data = $this->usergroup_m->get_new(array('group' =>  ''));
        }
        $this->data['page_title'] = $groupid?'Edit Group - '.$data->group : 'Create Group';
        
        
        
        $this->data['data'] = $data;
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/groupedit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function unique_groupname(){
        //do not validate if exist
        //Unless it is the current record
        $id = $this->uri->segment(4);
        
        $this->db->where('group', $this->input->post('group'));
        !$id || $this->db->where('id !=', $id);
        
        $found = $this->usergroup_m->get();
        if (count($found)){
            $this->form_validation->set_message('unique_groupname','%s already exists!');
            
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function groupaccess($group_id=NULL){
        //load group list as dropdown 
        $this->load->model('usergroup_m');
        $groups = $this->usergroup_m->get();
        $this->data['groups'] = $groups;
        
        $this->data['group_id'] = $group_id;
        $this->data['page_title'] = 'Group Access';
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/groupaccess';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function groupaccess_edit($group_id=NULL, $role_id=NULL){
        if (!$group_id || !$role_id)
            redirect('cms/admin/groupaccess');
        
        //load userrole to be edited
        $this->load->model('user_roles_m');
        
        // Set form
        $rules = $this->user_roles_m->rules;
        $this->form_validation->set_rules($rules);
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can continue proccess the form
            $id = $this->input->post('id');
            $data_post = $this->user_roles_m->array_from_post(array('role','group_id','enabled'));
            if ($this->user_roles_m->save($data_post, $id)){
                redirect('cms/admin/groupaccess/'.$data_post['group_id']); exit;
            }else{
                $this->session->set_flashdata('error','Update Failed!');
            }
        }
        
        //get groupname by group id
        $this->load->model('usergroup_m');
        $this->data['group'] = $this->usergroup_m->get($group_id);
        
        //load role
        $this->load->model('roles_m');
        $this->data['role'] = $this->roles_m->get($role_id);
        
        $role_user = $this->user_roles_m->get_by(array('role'=>$role_id, 'group_id'=>$group_id), TRUE);
        if ($role_user)
            $this->data['roleuser'] = $role_user;
        else{
            $role_user = new stdClass();
            $role_user->id = NULL;
            $role_user->role = $role_id;
            $role_user->group_id = $group_id;
            if ($group_id==1)
                $role_user->enabled = 1;
            else
                $role_user->enabled = 0;
            
            $this->data['roleuser'] = $role_user;
        }
        //exit(var_dump($this->data['roleuser']));
        
        $this->data['page_title'] = 'Group Access Edit';
        
        //Load view
        $this->data['active_menu'] = 'users';
        $this->data['subview'] = 'cms/users/groupaccess_edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
}
/*
 * file location: /application/controllers/cms/admin.php
 */
