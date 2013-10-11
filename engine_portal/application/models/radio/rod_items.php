<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Rod_items extends MY_Model {
    protected $_table_name = 'radio_sod_subcategory';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'radio_name';
    
    function __construct() {
        parent::__construct();
    }    
}

?>
