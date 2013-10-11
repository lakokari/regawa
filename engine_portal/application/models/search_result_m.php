<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Search_result_m
 *
 * @author master
 */
class Search_result_m extends MY_Model {
    protected $_table_name = 'search_results';
    protected $_primary_key = '';
    protected $_primary_filter = '';
    protected $_order_by = 'session_id';
    

    function __construct() {
        parent::__construct();
    }    


}

?>
