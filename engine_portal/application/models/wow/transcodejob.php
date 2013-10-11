<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Transcodejob extends MY_Model {
    protected $_table_name = 'transcode_jobs';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    

    
    function __construct() {
        parent::__construct();
    }
    
}

?>
