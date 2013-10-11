<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Music
 *
 * @author master
 */
class Player extends U_Controller {
    
    protected $_channel_name = 'games';
    
    function __construct() {
        parent::__construct();
        $this->load->library('Gamelib');
    }
    
    public function getplayer(){
        
        //load game mode
        $this->load->model($this->_channel_name.'/items');
        $gameID = $this->input->post('gameID');
        
        if ($gameID)
        {
            $this->data['game'] = $this->items->get_by(array('ID'=>$gameID), TRUE);
        
            //$this->data['subview'] = 'channel/'.$this->_channel_name.'/player';
            $this->load->view('channel/'.$this->_channel_name.'/player', $this->data);
        }
    }
    
    public function getplayerframe(){
        
        //load game mode
        $this->load->model($this->_channel_name.'/items');
        $gameID = $_GET['id_games'];
        
        if ($gameID)
        {
            $this->data['game'] = $this->items->get_by(array('ID'=>$gameID), TRUE);
        
            //$this->data['subview'] = 'channel/'.$this->_channel_name.'/player';
            $this->load->view('channel/'.$this->_channel_name.'/player', $this->data);
        }
    }
    
}

?>
