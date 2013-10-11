<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Contact
 *
 * @author master
 */
class Contact_form extends MY_Model {
    protected $_table_name = 'wow_contact_form';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';

    public $rules = array(
        'sure_name' => array(
            'field' => 'sure_name', 
            'label' => 'Fullname', 
            'rules' => 'required|xss_clean'
        )
    );

   
    function __construct() {
        parent::__construct();
    }

    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->name = '';
        $new->email = '';
        $new->phone = '';
        $new->content = '';
        $new->create_date = date('y-m-d');
        
        return $new;
    }

}

?>
