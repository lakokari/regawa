<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author master
 */
class Category extends MY_Model {
    protected $_table_name = 'music_categories';
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
			'rules' => 'trim|required|xss_clean'
		),
		'genrename' => array(
			'field' => 'genrename', 
			'label' => 'genrename', 
			'rules' => 'trim|required|xss_clean'
		),
		'ordernum' => array(
			'field' => 'ordernum', 
			'label' => 'ordernum', 
			'rules' => 'trim|required|xss_clean'
		)
	);
    function get_new(){
        $category = new stdClass();
        $category->genreId = '';
        $category->genreName = '';
        $category->orderNum = 0;
		return $category;
    }
}

?>
