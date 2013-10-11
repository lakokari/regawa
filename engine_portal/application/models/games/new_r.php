<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class New_r extends MY_Model {
    protected $_table_name = 'game_items';
    protected $_primary_key = 'autoId';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'inserted_time DESC';
    
    function __construct() {
        parent::__construct();
    }    
}

?>
