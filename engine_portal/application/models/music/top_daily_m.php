<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Top_daily_m extends MY_Model {
    protected $_table_name = 'music_daily_chart';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'ranking ASC, inserted_time DESC';
    
    function __construct() {
        parent::__construct();
    }
    
}

?>
