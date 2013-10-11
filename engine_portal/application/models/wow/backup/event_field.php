<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Event_field extends MY_Model {
    protected $_table_name = 'wow_event_field';
    protected $_primary_key = 'id_event_field';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id_event_field';
    
    function __construct() {
        parent::__construct();
    }    
    
}

?>
