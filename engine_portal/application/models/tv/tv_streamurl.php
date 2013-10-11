<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tvod
 *
 * @author master
 */
class Tv_streamurl extends MY_Model {
    protected $_table_name = 'tv_streamurl';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'tvcode';
    
    public $rules = array(
        'streamtype' => array(
            'field' => 'streamtype', 
            'label' => 'Stream Type', 
            'rules' => 'required|xss_clean'
        ),
        'tvcode' => array(
            'field' => 'tvcode', 
            'label' => 'TV Code', 
            'rules' => 'required|xss_clean'
        ),
        'url_streaming' => array(
            'field' => 'url_streaming', 
            'label' => 'URL Streaming', 
            'rules' => 'required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
}
?>
