<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Items extends MY_Model {
    protected $_table_name = 'movie_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'release_date desc';
    
    public $thumb_width = 200;
    public $thumb_height = 200;
    
    public $upload_video = array(
        'upload_path'           =>  '/userfiles/movie/',
        'max_size'              =>  8000,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
    
    public $upload_config_thumbnail = array(
        'upload_path'           =>  '/userfiles/movie/thumbnail/',
        'allowed_types'         =>  'jpg',
        'max_size'              =>  500,
        'overwrite'             =>  TRUE,
        'remove_spaces'          =>  TRUE
    );
    
    public $config_thumb_resize = array(
        'image_library'         =>  'gd2',
        'source_image'          =>  '',
        'create_thumb'          =>  FALSE,
        'maintain_ratio'        =>  FALSE,
        'width'                 =>  200,
        'height'                =>  200
    );

    public $upload_rules = array(
        'item_url_mpeg' => array(
            'field' => 'item_url_mpeg', 
            'label' => 'MPEG File', 
            'rules' => 'xss_clean'
        ),
        'item_url_webm' => array(
            'field' => 'item_url_webm', 
            'label' => 'Webm Video File', 
            'rules' => 'xss_clean'
        ),
        'item_url_ogg' => array(
            'field' => 'item_url_ogg', 
            'label' => 'Ogg Video File', 
            'rules' => 'xss_clean'
        ),
        'item_thumbnail' => array(
            'field' => 'item_thumbnail', 
            'label' => 'Image File', 
            'rules' => 'xss_clean'
        )
    );
    
    public $rules = array(
        'categories' => array(
            'field' => 'categories', 
            'label' => 'Categories', 
            'rules' => 'required|xss_clean'
        ),
        'item_name' => array(
            'field' => 'item_name', 
            'label' => 'Item Name', 
            'rules' => 'required|xss_clean'
        ),
        'item_description' => array(
            'field' => 'item_description', 
            'label' => 'Item Description', 
            'rules' => 'xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
    }    
    function topview($limit){
		$sql='select * from uz_movie_items order by view_count desc limit 0,'.$limit;
		$data=$this->db->query($sql);
		return $data->result();
	}
	function toppaid($limit){
		$sql='select * from uz_movie_items order by view_paid_count desc limit 0,'.$limit;
		$data=$this->db->query($sql);
		return $data->result();
	}

    
}

?>
