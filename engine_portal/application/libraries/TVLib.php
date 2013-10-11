<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Tvlib
 *
 * @author master
 */

class Tvlib {
    
    protected $_api_url = 'http://cms.useetv.com/uzone-api?';
    
    public $imageUrl = 'http://cms.useetv.com/files/images/';
    
    function __construct() {
    }
    
    /**
     * List All channel TV
     * 
     * @return array
     */
    public function tv_channels () {
        $result = file_get_contents($this->_api_url.'req=channels');
        return  $this->_output($result);
    }
    
    /**
     * Mendapatkan format stream url untuk tvod atau live tv dari suatu channel
     * @param type $stream_type [tvod|live]
     * @param type $tvcode one of tvcode
     * @return mixed
     */
    public function stream_url($tvcode='antv', $stream_type='tvod', $device='all'){
        $fields = array(
            'req'           =>  'streamurl',
            'streamtype'    =>  $stream_type,
            'tvcode'        =>  $tvcode,
            'device'        =>  $device
        );
        $result = file_get_contents($this->_api_url.  http_build_query($fields));
        return  $this->_output($result);
    }
    
    /**
     * Mendapatkan jadwal acara dari channel dalam satu hari
     * @param type $tvCode
     * @param type $date YYYY-mm-dd
     * @return type
     */
    public function get_schedules_tv($tvCode='antv', $date=NULL) {
        if (!$date) $date = date("Y-m-d");
        
        $fields = array(
            'req'           =>  'schedules',
            'tvcode'        =>  $tvCode,
            'date'          =>  $date
        );
        
        $result = file_get_contents($this->_api_url.  http_build_query($fields));
        return  $this->_output($result);
    }
    
    /**
     * Mendapatkan list vod (video on demand)
     * @return json
     */
    public function video_on_demand () {
        $fields = array(
            'req'           =>  'vod'
        );
        
        $result = file_get_contents($this->_api_url.  http_build_query($fields));
        return  $this->_output($result);
    }
    
    /**
     * Mendapatkan list TOVI dr useetv & metadatanya
     * @param string $par_category ['c_tokovideo'=tovi | mov_demo='vod']
     * @param string $cat_code ['C_TokoVideo_International'=movie | 'C_TokoVideo_PPV'=new | 'C_TokoVideo_MiniTV'=mini ]
     * @param int $detail [ 0=no detail | 1=with detail ]
     * @param int $pageindex offset
     * @param int $pagesize limit
     * @return mixed json
     */
    public function tovi($par_category='c_tokovideo', $cat_code='C_TokoVideo_International',$detail=1,$pageindex=0, $pagesize=1){
        $tovi_url = 'http://www.useetv.com/services/QueryProgramee?';
        $fields = array(
            'ParentCategory'        =>  $par_category,
            'CategoryCode'          =>  $cat_code,
            'Withdetail'            =>  $detail,
            'PageIndex'             =>  $pageindex,
            'PageSize'              =>  $pagesize
        );
        
        $result = file_get_contents($tovi_url.  http_build_query($fields));
        return  $this->_output($result);
    }
    /**
     * Helper function to output return value format
     * @param mix $data
     * @return mix
     */
    public function _output($data){
        return json_decode ($data, TRUE);
    }
    
    public function getImageUrl(){
        return $this->imageUrl;
    }
    
    public function setImageUrl($imgUrl) {
        $this->imageUrl = $imgUrl;
    }
}

?>
