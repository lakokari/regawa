<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Movietag
 *
 * @author master
 */
class Movietag extends MY_Model {
    protected $_table_name = 'movie_tags';
    protected $_primary_key = 'tag';
    protected $_primary_filter = 'strval';
    protected $_order_by = 'tag';
    
    public $rules = array(
        'tag' => array(
            'field' => 'tag', 
            'label' => 'Tag Name', 
            'rules' => 'required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    public function save($data){
        return @parent::save($data);
    }
}
?>
