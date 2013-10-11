<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Jury extends MY_Model {
    protected $_table_name = 'wow_jury';
    protected $_primary_key = 'user_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';

    public $rules = array(
        'sure_name' => array(
            'field' => 'sure_name', 
            'label' => 'Fullname', 
            'rules' => 'required|xss_clean'
        )
    );

    public $upload_config_image = array(
        'upload_path'           =>  '/userfiles/wow/category/',
        'allowed_types'         =>  'jpg',
        //'max_size'              =>  1000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
   
    function __construct() {
        parent::__construct();
    }

    public function get_new(){
        $new = new stdClass();
        $new->id = 0;
        $new->sure_name = '';
        $new->occupation = '';
        $new->facebook_id = '';
        $new->tweeter_id = '';
        $new->age = '';
        $new->creation = '';
        $new->motto = '';
        $new->description = '';
        $new->avatar = '';
        $new->create_date = date('y-m-d');
        
        return $new;
    }


    function get_join_jury($limit, $offset){
    	$sql = "SELECT
					uz_users.u_name,
					uz_users.id,
					uz_users.wow_event_id,
					uz_wow_jury.event_id,
					uz_wow_jury.sure_name,
					uz_wow_jury.occupation,
					uz_wow_jury.facebook_id,
					uz_wow_jury.tweeter_id,
					uz_wow_jury.age,
					uz_wow_jury.creation,
					uz_wow_jury.motto,
					uz_wow_jury.description,
					uz_wow_jury.avatar,
					uz_wow_jury.create_date
				FROM
					uz_users
				LEFT JOIN 
					uz_wow_jury 
				ON uz_users.id = uz_wow_jury.user_id WHERE group_id = 4 LIMIT ".$limit.",".$offset;
		$query = $this->db->query($sql);
		return $query->result();
    }
}

?>
