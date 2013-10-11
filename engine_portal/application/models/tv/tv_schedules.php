<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tvod
 *
 * @author master
 */
class Tv_schedules extends MY_Model {
    protected $_table_name = 'tv_schedules';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'date desc, start_time, end_time';
    
    public $rules = array(
        'tvcode' => array(
            'field' => 'tvcode', 
            'label' => 'TV Code', 
            'rules' => 'required|xss_clean'
        ),
        'schedule_genid' => array(
            'field' => 'schedule_genid', 
            'label' => 'Schedule ID', 
            'rules' => 'required|xss_clean'
        ),
        'date' => array(
            'field' => 'date', 
            'label' => 'Date', 
            'rules' => 'required|xss_clean'
        ),
        'jam' => array(
            'field' => 'jam', 
            'label' => 'Jam', 
            'rules' => 'required|xss_clean'
        ),
        'acara' => array(
            'field' => 'acara', 
            'label' => 'Acara', 
            'rules' => 'required|xss_clean'
        ),
        'start_time' => array(
            'field' => 'start_time', 
            'label' => 'Start Time', 
            'rules' => 'required|xss_clean'
        ),
        'end_time' => array(
            'field' => 'end_time', 
            'label' => 'End Time', 
            'rules' => 'required|xss_clean'
        ),
        'file_status' => array(
            'field' => 'file_status', 
            'label' => 'File Status', 
            'rules' => 'required|xss_clean'
        ),
        'tvod_stream' => array(
            'field' => 'tvod_stream', 
            'label' => 'TVOD Stream', 
            'rules' => 'required|xss_clean'
        ),
        'category' => array(
            'field' => 'category', 
            'label' => 'Category', 
            'rules' => 'required|xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }
    
    function today($tvcode='antv'){
        $schedule = $this->get_by(array('tvcode'=>$tvcode, 'date'=>date('Y-m-d')));
        return $schedule;
    }
    
    function bydate($date, $tvcode='antv'){
        $schedule = $this->get_by(array('tvcode'=>$tvcode, 'date'=>$date));
        return $schedule;
    }
    function cat_schedules($category, $limit=10, $date=NULL, $tvcode=NULL){
        $where_text = 'a.category='.$category;
        
        if ($date)
        {
            $where_text .= " AND a.date='$date'";
        }
        
        if ($tvcode){
            $where_text .= " AND a.tvcode='$tvcode'";
        }
        
	$sql="SELECT a.id, a.tvcode, a.acara, a.jam, a.tvod_stream, a.tvod_stream_mobile, b.small_logo1 FROM uz_tv_schedules a
            INNER JOIN uz_tv_stations b ON(b.tv_code=a.tvcode)
            WHERE $where_text ORDER BY a.jam ASC limit 0,".$limit;
		
        $data=$this->db->query($sql);
		
        return $data->result();
    }
}
?>
