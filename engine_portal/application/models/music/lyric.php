<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Lyric
 *
 * @author master
 */
class Lyric extends MY_Model {
    protected $_table_name = 'music_lyrics';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'songId';
    
    function __construct() {
        parent::__construct();
    }    
}

?>
