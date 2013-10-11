<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Genres extends MY_Model {
    protected $_table_name = 'radio_genres';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    public $rules = array(
		'category_id' => array(
			'field' => 'category_id', 
			'label' => 'Category Id', 
			'rules' => 'trim|required|xss_clean'
		),
        'genre_name' => array(
            'field' => 'genre_name', 
            'label' => 'Genre Name', 
            'rules' => 'trim|required|xss_clean'
        )
    );
    //is_unique[uz_radio_genres.genre_name]
    function __construct() {
        parent::__construct();
    }    
}

?>
