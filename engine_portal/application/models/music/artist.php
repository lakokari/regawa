<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Artist
 *
 * @author master
 */
class Artist extends MY_Model {
    protected $_table_name = 'music_artists';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'artistName';
    
    function __construct() {
        parent::__construct();
    }
	public $rules = array(
        'artistId' => array(
            'field' => 'artistId', 
            'label' => 'artistId', 
            'rules' => 'required|xss_clean'
        ),
        'artistName' => array(
            'field' => 'artistName', 
            'label' => 'artistName', 
            'rules' => 'required|xss_clean'
        ),
        'genreId' => array(
            'field' => 'genreId', 
            'label' => 'genreId', 
            'rules' => 'required|xss_clean'
        )
    );
}

?>
