<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Makko extends MY_Model {
    protected $_table_name = 'book_makko_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    function __construct() {
        parent::__construct();
    }    
}

?>
