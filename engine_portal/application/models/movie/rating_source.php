<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Rating_source extends MY_Model {
    protected $_table_name = 'movie_rating_source';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'name';

    public $rules = array(
        'rating' => array(
            'field' => 'rating', 
            'label' => 'name', 
            'rules' => 'required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
 
}

?>
