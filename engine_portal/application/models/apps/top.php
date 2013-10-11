<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Top extends MY_Model {
    protected $_table_name = 'apps_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'download_count DESC';

    function __construct() {
        parent::__construct();
    }    
}
?>
