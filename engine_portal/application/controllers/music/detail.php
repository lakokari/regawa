<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Music
 *
 * @author master
 */
class Detail extends U_Controller {
    
    protected $_channel_name = 'music';
    
    function __construct() {
        parent::__construct();
    }
    
    public function album($albumId){
        
        //load model album
        $this->load->model($this->_channel_name.'/album');
        //load genre model to get genreName
        $this->load->model($this->_channel_name.'/genre');
        //Load model for music album recommended
        $this->load->model($this->_channel_name.'/album_recommended');        
        //Load model for music album chart
        $this->load->model($this->_channel_name.'/top_daily_m');
        
        
        $album = $this->album->get_by(array('albumId'=>$albumId), TRUE);
        
        if (!$album){
            redirect('music/channel');
            exit;
        }
        
        $genre = $this->genre->get_by(array('genreId'=>$album->genreId), TRUE);
        $album->genreName = $genre->genreName;
        
        //get Main Artist Name
        $this->load->model($this->_channel_name.'/artist');
        $artist = $this->artist->get_by(array('artistId'=>$album->mainArtistId),TRUE);
        if(!empty($artist->artistName)) {
            $album->mainArtistName = $artist->artistName;
        } else {
            $album->mainArtistName = "";
        }
        
        $this->data['album'] = $album;
        
        //Load song list in this album
        $this->load->model($this->_channel_name.'/song');
        $songs = $this->song->get_by(array('albumId'=>$albumId));
        
        $this->data['songs'] = $songs;
        
        //load category model
        $this->load->model($this->_channel_name.'/category');
        $this->data['categories'] = $this->category->get();
        
        $this->data['chart'] = $this->top_daily_m->get_offset('*', NULL, 0, 10);
        
        //load playlist
        $playListSession = $this->getSongPlayListSession();
        $playList = array();
        if ($playListSession){
            $playList = $playListSession['songInfo'];
        }
        $this->data['playlist'] = $playList;
        
        //load recommendation
        
        $this->data['recommended'] = $this->album_recommended->get_offset('*', NULL, 0, 10);
        
        $this->data['subview'] = 'channel/'.$this->_channel_name.'/detail_album';
        $this->load->view('_layout_main', $this->data);
    }
}

?>
