<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tovi_parent_category
 *
 * @author master
 */
class Tovi_parent_category extends MY_Model {
    protected $_table_name = 'tv_tovi_parent_category';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'name';
    
    function __construct() {
        parent::__construct();
    }
}
?>
