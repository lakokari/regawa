<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of channel_m
 *
 * @author master
 */
class Comment_rating_m extends MY_Model {
    
    
        
    protected $_table_name = 'comment_rating';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'channel_name, item_id, datetime desc';
    
    
    function __construct() {
        parent::__construct();
    }
        
}

?>
