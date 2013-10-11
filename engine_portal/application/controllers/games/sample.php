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
        $this->load->library('Gamelib');
        $this->Lib = $this->gamelib;
    }
    
    function majapahit(){
        var_dump($this->Lib->majapahit_online());
    }
    
    function api(){
        //$api_url = 'http://project.digitalmind.co.id/ugame/category/shooting';
        //$api_url = 'http://api.ugame.co.id/free-games/shooting?api';
        //$api_url= 'http://api.ugame.co.id/category/free-games/other?json=1';
        //$api_url = 'http://api.ugame.co.id/free-games/other/2718';
        
        $api_url = 'http://api.ugame.co.id/category/free-games/dressup?api';
        $result = json_decode(file_get_contents($api_url));
        
        if (json_last_error()){
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    echo ' - No errors';
                break;
                case JSON_ERROR_DEPTH:
                    echo ' - Maximum stack depth exceeded';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Underflow or the modes mismatch';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Unexpected control character found';
                break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Syntax error, malformed JSON';
                break;
                case JSON_ERROR_UTF8:
                    echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
                default:
                    echo ' - Unknown error';
                break;
            }
        }
        
        
        var_dump($result);
    }
    
}

?>
