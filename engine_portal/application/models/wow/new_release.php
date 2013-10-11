<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class New_release extends MY_Model {
    protected $_table_name = 'wow_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'upload_date DESC';

    function __construct() {
        parent::__construct();
    }    
}
?>
