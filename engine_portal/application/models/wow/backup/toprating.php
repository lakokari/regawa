<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Toprating extends MY_Model {
    protected $_table_name = 'wow_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'rating_count DESC';

    function __construct() {
        parent::__construct();
    }    
}
?>
