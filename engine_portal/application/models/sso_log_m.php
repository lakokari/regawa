<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sso_client_m
 *
 * @author master
 */
class Sso_log_m extends MY_Model {
    
    protected $_table_name = 'sso_log';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'sso_datetime';
    
    function __construct() {
        parent::__construct();
    }
    
}
