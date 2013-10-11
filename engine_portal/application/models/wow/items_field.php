<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Items_field extends MY_Model {
    protected $_table_name = 'wow_item_fieldvalue';
    protected $_primary_key = 'id_fieldvalue';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id_fieldvalue';
    
    public $rules = array(
        'fieldvalue' => array(
            'field' => 'fieldvalue', 
            'label' => 'Field Value', 
            'rules' => 'xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    
}

?>
