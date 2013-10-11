<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of U_CMS_Controller
 *
 * @author master
 */
class U_CMS_Controller extends MY_Controller {
    function __construct() {
        parent::__construct();
        
        //set shared data to all child classes
        $this->data['cms_title'] = 'UZone Content Management System';
        $this->data['page_title'] = 'CMS'; //default page title
        
        //table edit form template format
        $this->data['table_tmpl'] = array(
            'table_open'        =>  '<table class="table table-striped">',
            'table_close'       => '</table>'
        );
        
        //load library
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('table');
        
        //load helper
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cms');
        
        //load default model
        $this->load->model('user_m');
        
        //load channel list for channel sub menu
        $this->load->model('channel_m');
        $this->data['channel_list'] = $this->channel_m->get();        
        
        //always redirect to login page if user is not loggedin
        if (!$this->user_m->is_loggedin()){
            redirect('auth');
        }
        
        if (!$this->user_m->can_cp()){
            redirect('home');
        }
    }
    
}
/*
 * file location: /application/libraries/U_CMS_Controller.php
 */