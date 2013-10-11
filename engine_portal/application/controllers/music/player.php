<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Music
 *
 * @author master
 */
class Player extends U_Controller {
    
    protected $_channel_name = 'music';
    
    function __construct() {
        parent::__construct();
        
        //load melon lib
        $this->load->library('melon');
    }
    
    public function getplayerframe(){
        $songId = $_GET['song_id'];
        
        //keep the song info in the playlist session
        $this->addSongIntoPlayListSession($songId);
        
        $this->data['player_obj'] = $this->melon->song_stream_object($songId);  
        
        $this->load->view('channel/'.$this->_channel_name.'/player', $this->data);
    }
}

?>
