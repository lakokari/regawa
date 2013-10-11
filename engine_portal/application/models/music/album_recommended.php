<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Album_recommended extends MY_Model {
    protected $_table_name = 'uz_music_recommended';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'issueDate DESC';
    
}

?>
