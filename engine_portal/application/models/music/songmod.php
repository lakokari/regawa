<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Songmod
 *
 * @author master
 */
class Songmod extends MY_Model {
    protected $_table_name = 'music_songmod';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'songId';
    
    function __construct() {
        parent::__construct();
    }
	public $rules = array(
        'contentId' => array(
            'field' => 'contentId', 
            'label' => 'contentId', 
            'rules' => 'required|xss_clean'
        ),
        'originalFileName' => array(
            'field' => 'originalFileName', 
            'label' => 'originalFileName', 
            'rules' => 'required|xss_clean'
        ),
        'fullFilePath' => array(
            'field' => 'fullFilePath', 
            'label' => 'fullFilePath', 
            'rules' => 'required|xss_clean'
        ),
        'songId' => array(
            'field' => 'songId', 
            'label' => 'songId', 
            'rules' => 'required|xss_clean'
        )
    );
    public function get($id = NULL, $fields='*', $single = FALSE, $method = 'result'){
        $this->db->select($fields);
        $this->db->join('music_songs','music_songs.songId='.$this->_table_name.'.songId');
        
        return parent::get($id, $single, $method);
    }
    
    public function get_count_join($where=NULL){
        $this->db->select('count(*) as found');
        $this->db->join('music_songs','music_songs.songId='.$this->_table_name.'.songId');
        
        return parent::get_count($where);
    }
    
    public function get_offset($fields='*', $where=NULL, $offset=0, $limit=20, $method='result'){
		$this->db->select($fields.','. $this->_table_name.'.id as id_songmod');
        $this->db->join('music_songs','music_songs.songId='.$this->_table_name.'.songId');
        
        if ($where)
            $this->db->where($where);
        
        if (!count($this->db->ar_orderby)) {
            $this->db->order_by($this->_table_name.'.'.$this->_order_by);            
        }
        if ($limit > 0){
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        
        return $this->db->get($this->_table_name)->$method();
    }
}

?>
