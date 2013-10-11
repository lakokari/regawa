<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Genre
 *
 * @author master
 */
class Genre extends MY_Model {
    protected $_table_name = 'music_genres';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'orderNum';
    
    function __construct() {
        parent::__construct();
    }
	public $rules = array(
        'genreid' => array(
            'field' => 'genreid', 
            'label' => 'genreid', 
            'rules' => 'required|xss_clean'
        ),
        'genrename' => array(
            'field' => 'genrename', 
            'label' => 'genrename', 
            'rules' => 'required|xss_clean'
        ),
        'categoryid' => array(
            'field' => 'categoryid', 
            'label' => 'categoryid', 
            'rules' => 'required|xss_clean'
        )
    );
	public function get_new(){
        $new = new stdClass();
        $new->categoryId = 0;
		$new->genreId = '';
		$new->genreName = '';
		$new->orderNum = '';
        
        return $new;
    }
}

?>
