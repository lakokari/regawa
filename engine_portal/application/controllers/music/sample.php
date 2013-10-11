<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Sample
 *
 * @author master
 */
class Sample extends U_Controller {
    
    protected $_channel_name = 'radio';
    protected $Lib = null;
            
    function __construct() {
        parent::__construct();
        
        //load melon lib
        $this->load->library('Melon');
        $this->Lib = $this->melon;
    }
    
    function chart(){
        var_dump($this->Lib->chart_weekly_latest());
    }
    function album($albumId){
        var_dump($this->Lib->album_detail($albumId));
    }
    function recomend(){
        var_dump($this->Lib->songs_recomend_genre());
    }
    
}

?>
