<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Genre
 *
 * @author master
 */
class Genre extends MY_Model {
    protected $_table_name = 'radio_sod_subcategory';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    function __construct() {
        parent::__construct();
    }    
}

?>
