<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Album extends MY_Model {
    protected $_table_name = 'music_albums';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'issueDate DESC';
    
    function __construct() {
        parent::__construct();
    }
	public $rules = array(
        'genreId' => array(
            'field' => 'genreId', 
            'label' => 'genreId', 
            'rules' => 'required|xss_clean'
        ),
        'albumId' => array(
            'field' => 'albumId', 
            'label' => 'albumId', 
            'rules' => 'required|xss_clean'
        ),
        'mainArtistId' => array(
            'field' => 'mainArtistId', 
            'label' => 'mainArtistId', 
            'rules' => 'required|xss_clean'
        ),
        'mainSongId' => array(
            'field' => 'mainSongId', 
            'label' => 'mainSongId', 
            'rules' => 'required|xss_clean'
        )
    );

	function topclick($genre, $limit){
		//$sql="SELECT a.albumId, a.albumLImgPath, a.albumName, SUM(b.view_count) as clicked FROM uz_music_albums a
		//	  INNER JOIN uz_music_songs b ON (b.albumId=a.albumId) 
		//	  WHERE a.genreId=".$genre." AND b.view_count != 0
		//	  GROUP BY b.albumId  ORDER BY clicked DESC limit 0,".$limit;
		$sql="SELECT a.albumId, a.albumLImgPath, a.albumName, b.clicked FROM uz_music_albums a
	  		RIGHT JOIN uz_music_album_view b ON (b.albumId=a.albumId) 
	  		WHERE a.genreId=".$genre."
	  		ORDER BY b.clicked DESC limit 0,".$limit;
		$data=$this->db->query($sql);
		return $data->result();
	}


    
}

?>
