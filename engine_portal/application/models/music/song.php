<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Song
 *
 * @author master
 */
class Song extends MY_Model {
    protected $_table_name = 'music_songs';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'albumId';
    
    function __construct() {
        parent::__construct();
    }
	public $rules = array(
        'genreId' => array(
            'field' => 'genreId', 
            'label' => 'genreId', 
            'rules' => 'required|xss_clean'
        ),
        'albumId' => array(
            'field' => 'albumId', 
            'label' => 'albumId', 
            'rules' => 'required|xss_clean'
        ),
        'artistId' => array(
            'field' => 'artistId', 
            'label' => 'artistId', 
            'rules' => 'required|xss_clean'
        ),
        'categoryId' => array(
            'field' => 'categoryId', 
            'label' => 'categoryId', 
            'rules' => 'required|xss_clean'
        ),
        'songId' => array(
            'field' => 'songId', 
            'label' => 'songId', 
            'rules' => 'required|xss_clean'
        )
    );
	public function get_new(){
        $new = new stdClass();
		$field=$this->get_fields();
		unset($field[0]);
		foreach($field as $r){
			$new->$r='';
		}
        
        return $new;
    }

}

?>
