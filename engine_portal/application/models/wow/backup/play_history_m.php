<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Play_history_m extends MY_Model {
    protected $_table_name = 'wow_play_history';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'play_unixtime desc';

    function __construct() {
        parent::__construct();
    }    

    public function get_join($id=NULL, $event_id=NULL, $offset=0, $limit=5){
        if ($id){
            $this->db->select('*')->from($this->_table_name);
            $this->db->join('wow_items', 'wow_items.id = '.$this->_table_name.'.item_id');
            $this->db->where($this->_table_name.'.id='.$id);
            return $this->db->get()->row();
        }else{
            $table_items = $this->db->dbprefix('wow_items');
            $table_played = $this->db->dbprefix($this->_table_name);
            
            $fields = $this->db->list_fields($table_items);
            
            $select = array();
            $select [] = 'DISTINCT ('.$table_played.'.item_id)';
            foreach($fields as $field){
                $select[] = 'uz_wow_items.'.$field;
            }
            $sql = 'SELECT '.implode(',', $select).'  FROM '. $table_played.' JOIN '.$table_items.' ON '.$table_items.'.id='.  $table_played.'.item_id';   
            
            if ($event_id){
                if (is_array($event_id)){
                    $temp = array();
                    foreach ($event_id as $key=>$val){
                        $temp [] = $table_items .'.'. $key .'='. $val;
                    }
                    $event_id = implode(' AND ', $temp);
                }else{
                    $event_id = $table_items .'.event_id='.$event_id;
                }
                $sql.= ' WHERE '.$event_id;
            }
            $sql.= ' ORDER BY '.$this->_order_by.' LIMIT '.$offset.','.$limit;
            return $this->db->query($sql)->result();
        }
        return FALSE;
    }
    
    public function get_count($event_id=NULL){
        $totalCount = 0;
        
        $this->db->distinct()->select('item_id')->from($this->_table_name);
        if (!$event_id){            
            $totalCount = $this->db->count_all_results();
        }else{
            if (is_array($event_id)){
                $temp = array();
                foreach ($event_id as $key=>$val){
                    $temp [] = $key .'='. $val;
                }
                $event_id = implode(' AND ', $temp);
            }else{
                $event_id = ' event_id='.$event_id;
            }
            $table_items = $this->db->dbprefix('wow_items');
            $table_played = $this->db->dbprefix($this->_table_name);
            $sql = 'SELECT COUNT(DISTINCT item_id) total_item FROM '. $table_played.' JOIN '.$table_items.' ON '.$table_items.'.id='.  $table_played.'.item_id WHERE '.$event_id;            
            $query = $this->db->query($sql)->row();
            $totalCount = $query->total_item;
        }
        
        return $totalCount;
    }
}

?>
