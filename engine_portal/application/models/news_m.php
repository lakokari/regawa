<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of category
 *
 * @author master
 */
class News_m extends MY_Model {
    protected $_table_name = 'channel_news';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'news_datetime';

    public $rules = array(
        'item_id' => array(
            'field' => 'item_id', 
            'label' => 'Item Id', 
            'rules' => 'trim|required|callback_unique_channel_name|xss_clean'
        ), 
        'news_title' => array(
            'field' => 'news_title', 
            'label' => 'news title', 
            'rules' => 'trim|required|xss_clean'
        ), 
        'news_text' => array(
            'field' => 'news_text', 
            'label' => 'news text', 
            'rules' => 'trim|xss_clean'
        ), 
    );

    function __construct() {
        parent::__construct();
    }    
    
    /*function get_new(){
        $category = new stdClass();
        $category->item_id = '';
        $category->genreName = '';
        $category->orderNum = 0;
    }*/
	function getitems($channel){
		switch($channel){
			case 'game': $field='title'; $table=$channel."_items";
			break;
			case 'music': $field='albumName';  $table=$channel."_albums";
			break;
			default :
			$sql="SHOW COLUMNS FROM uz_".$channel."_items where field like '%name' or field like 'name' or field like 'name%'";
			$field=$this->db->query($sql);
			$field=$field->row();$field=$field->Field;
			$table=$channel."_items";
			break;
		}
		$this->db->select('id, '.$field);
		$this->db->order_by($field, "asc"); 
		$data=$this->db->get($table);
		$data=array('field'=>$field, 'data'=>$data->result_array());
		return $data;
	}
}

?>
