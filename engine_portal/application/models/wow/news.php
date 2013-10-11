<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class News extends MY_Model {
    protected $_table_name = 'channel_news';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
   
    function __construct() {
        parent::__construct();
    }
}

?>
