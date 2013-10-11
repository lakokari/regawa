<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Melon
 *
 * @author master
 */
class Melon {
    private $auth_req_code = 'EC100';
    
    protected $curl = NULL;
    protected $mapiUrl = 'http://118.98.31.135:8000/mapi/'; 
    protected $uname = 'Telkom UZone Client';
    protected $upass = 'FDC6AE040A8C0360A26079200D384D4E';
    
    //melon member account
    protected $mbm_user = 'uzone.useetv@gmail.com';
    protected $mbm_pwd = 'T3lk0m1d';
    
    protected $_cookie_file = '_cookiemelon.log';
            
    function __construct() {
        $this->curl = curl_init();
    }
    
    protected function authenticationClient() {
        try {
            curl_setopt($this->curl, CURLOPT_POST, 1);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'clientName=' . urlencode($this->uname) . '&password=' . $this->upass);
            curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . "cookiesMelon.log");
            curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'authentication/client');
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($this->curl);
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function authenticationUser(){
        $userMelon = array(            
            'userEmail' => $this->mbm_user,
            'password'  => base64_encode($this->mbm_pwd)
        );
        //curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $userMelon);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'authentication/user'.'?'.  http_build_query($userMelon));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            $this->authenticationClient();
            return $this->authenticationUser();
        }
        return $data;
    }
    
    public function get_user($userid){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'users/'.$userid);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	
        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->get_user($userid);
            }
            $this->member_login();
        }
        
        return $data;
    }

    /**
     * AC Flag: RC
     * View daily Music Chart. Always provides the newest music chart.
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function chart_daily($offset=0,  $limit=NULL){
        $fields = array(          
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'chart/daily?'. http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->chart_daily($offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View weekly Music Chart search period list of the latest year
     * @param type $startDate optional format YYYYmmdd
     * @return type
     */
    public function chart_weekly($startDate=NULL, $offset=0, $limit=NULL){
        $fields = array(
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        
        if ($startDate)
            $startDate = '/'. $startDate;
        
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'chart/weekly' .$startDate .'?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->chart_weekly($startDate, $offset, $limit);
            }
        }
        
        return $data;
    }

    /**
     * AC Flag: RC
     * View songs from recent weekly Music Chart (former week).
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function chart_weekly_latest($offset=0,  $limit=NULL){
        $fields = array(          
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'chart/weekly/latest?'. http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->chart_weekly_latest($offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View song from a specific month’s Music Chart.
     * @param type $startDate YYYYMM
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function chart_monthly($startDate, $offset=0, $limit=NULL){
        $fields = array(          
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'chart/monthly/'.$startDate.'?'. http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->chart_monthly($startDate, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View song from the latest monthly Music Chart (former month)
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function chart_monthly_latest($offset=0, $limit=NULL){
        $fields = array(          
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'chart/monthly/latest?'. http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->chart_monthly_latest($offset, $limit);
            }
        }
        
        return $data;
    }
        
    public function albums_hot($limit=NULL, $genreId=NULL) {        
        $fields = array(            
            'limit'     =>  $limit,
            'genreId'   =>  $genreId
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/hot?'. http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->albums_hot($limit, $genreId);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View Album list according to issue date.
     * @param type $artistId
     * @param type $offset
     * @param type $limit
     * @param type $dir
     * @return type
     */
    public function albums_by_artist($artistId,$offset=0,$limit=10,$dir='asc'){
        $fields = array(
            'artistId'  =>  $artistId,
            'offset'    =>  $offset,
            'limit'     =>  $limit,
            'dir'       =>  $dir
        );
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/by/artist?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->albums_by_artist($artistId, $offset, $limit, $dir);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View Album list according to issue date
     * @param type $genreId
     * @param type $offset
     * @param type $limit
     * @param type $dir
     * @return type
     */
    public function albums_by_genre($genreId, $offset=0, $limit=10, $dir='asc'){
        $fields = array(
            'genreId'  =>  $genreId,
            'offset'    =>  $offset,
            'limit'     =>  $limit,
            'dir'       =>  $dir
        );
        //curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/by/genre?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->albums_by_genre($genreId, $offset, $limit, $dir);
            }
        }
        
        return $data;
    }
    
    /**
     * Ac Flag: RC
     * View Album list released within the last six months according to issue date
     * @param type $genreId
     * @param type $offset
     * @param type $limit
     * @param type $dir
     * @return type
     */
    public function albums_new($genreId=NULL, $offset=0, $limit=10, $dir='asc'){
        $fields = array(            
            'offset'    =>  $offset,
            'limit'     =>  $limit,
            'dir'       =>  $dir
        );
        if ($genreId){
            $fields['genreId'] = $genreId;
        }
        //curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/new?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->albums_new($genreId, $offset, $limit, $dir);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * function albums_new_by_map
     * Provides list of albums within the last six months sorted according to genre
     * @param int $limit, optional, default 8
     * @param string $dir, optional, asc|desc
     * @return mix
     */
    public function albums_new_by_map($limit=8, $dir='asc'){
        $fields = array(            
            'limit'     =>  $limit,
            'dir'       =>  $dir
        );
        //curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/new/by/map?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->albums_new_by_map($limit, $dir);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View lists to be released.
     * @param type $limit
     * @return type
     */
    public function albums_coming_soon($limit=NULL){
        $fields = array(            
            'limit'     =>  $limit
        );
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/comingsoon?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->albums_coming_soon($limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * function categories()
     * Provides list of defined categories such as Indonesia, Western, Korea, Japanese etc
     * @return array List<Genre>
     */
    public function categories() {
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'categories');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->categories();
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * function genres_from_category
     * Provides genre list of a specific category
     * @param INT $categoryId
     * @return array List<Genre>
     */
    public function genres_from_category($categoryId) {
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'categories/'.$categoryId.'/genres');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->genres_from_category($categoryId);
            }
        }
        
        return $data;
    }
    
    
    /**
     * AC Flag: RC
     * function categories_genres
     * Provides Category and Genre
     * @return array List<Genre>
     */
    public function categories_genres() {
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'categories/all');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->categories_genres();
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * @param type $albumId
     * @return type
     */
    public function album_detail($albumId){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'albums/'.$albumId);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->album_detail($albumId);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View artist information in detail
     * @param type $artistId
     * @return type
     */
    public function artists($artistId){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . '/artists/'.$artistId);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->artists($artistId);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Provides list of Hot Artist selected from the former week’s album chart ranking.
     * @param type $limit
     * @return type
     */
    public function artists_hot($limit=6){
        $fields = array(
            'limit'     =>  $limit
        );
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'artists/hot?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->artists_hot($limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Search artist using index.
     * @param Char $index ,Required, Determines the first letter of the artist to search. Can use A to Z. Uses ‘*’ if the
     *      artist starts with another letter
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function search_index_artist($index='A', $offset=0, $limit=10){
        $fields = array(          
            'index'     =>  $index,
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'search/index/artist?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->search_index_artist($index, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Search album using index.
     * @param char $index, Required, Determines the first letter of the album to search. Can use A to Z. Uses ‘*’ if the
     *          album starts with another letter
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function search_index_albums($index='A', $offset=0, $limit=10){
        $fields = array(   
            'index'     =>  $index,
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'search/index/album?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->search_index_albums($index, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Search Song using any Keywords, including song title, artist name, and/or album name
     * @param type $keyword
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function search_integration_song($keyword, $offset=0, $limit=10){
        $fields = array(          
            'keyword'   =>  $keyword,
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'search/integration/song?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->search_integration_song($keyword, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Search Artist using only Keyword.
     * @param type $keyword
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function search_integration_artist($keyword, $offset=0, $limit=10){
        $fields = array(          
            'keyword'   =>  $keyword,
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'search/integration/artist?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->search_integration_artist($keyword, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Search Album using only Keyword
     * @param type $keyword
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function search_integration_album($keyword, $offset=0, $limit=10){
        $fields = array(          
            'keyword'   =>  $keyword,
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'search/integration/album?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->search_integration_album($keyword, $offset, $limit);
            }
        }
        
        return $data;
    }
    /**
     * AC Flag: RU
     * Provides list of albums a specific user has scrapped.
     * @param type $userId
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function user_albums($userId, $offset=0, $limit=10){
        $fields = array(
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . $userId. '/albums?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->user_albums($userId, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View song list in album.
     * @param type $albumId
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function songs_from_album($albumId=NULL, $offset=0, $limit=10){
        $fields = array(
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        if ($albumId)
            $fields['albumId'] = $albumId;
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/album?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->songs_from_album($albumId, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View song list of artist.
     * @param type $artistId
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function songs_from_artist($artistId=NULL, $offset=0, $limit=10){
        $fields = array(
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        if ($artistId)
            $fields['artistId'] = $artistId;
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/artist?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->songs_from_artist($artistId, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View song list of genre
     * @param type $genreId
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function songs_from_genre($genreId=NULL, $offset=0, $limit=10){
        $fields = array(
            'offset'    =>  $offset,
            'limit'     =>  $limit
        );
        if ($genreId)
            $fields['genreId'] = $genreId;
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/genre?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->songs_from_genre($genreId, $offset, $limit);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View Title songs released within the last six months in release date order
     * @param type $genreId
     * @param type $offset
     * @param type $limit
     * @param type $dir
     * @return type
     */
    public function songs_new($genreId=NULL, $offset=0, $limit=10, $dir='asc'){
        $fields = array(
            'offset'    =>  $offset,
            'limit'     =>  $limit,
            'dir'       =>  $dir
        );
        if ($genreId)
            $fields['genreId'] = $genreId;
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/new?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->songs_new($genreId, $offset, $limit, $dir);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * Provides information of songs in parameter requested identifier list
     * @param array $songId
     * @return type
     */
    public function songs_set(array $songId){
        $fields = array(
            'songId'    => implode(',', $songId)
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/set?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->songs_set($songId);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View best recommended song according to Class
     * @return type
     */
    public function songs_recomend_genre(){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        //curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/recommend/genre');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->songs_recomend_genre();
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * View detailed information of a specific song
     * @param type $songid
     * @return type
     */
    public function get_song_detail($songid){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/'.  $songid);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->get_song_detail($songid);
            }
        }
        
        return $data;
    }
    
    /**
     * Ac Flag: RC
     * Provides MOD file information of a specific song.
     * @param type $songid
     * @param type $codec, Optional, default: CT0002, CT0001: MP3, CT0002: AAC+, CT0004: DCF
     * @return type
     */
    public function get_songs_mod($songid, $codec='CT0001'){
        $fields = array(
            'codecTypeCd'   =>  $codec
        );
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/'.  $songid.'/mods'.'?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->get_songs_mod($songid, $codec);
            }
        }
        
        return $data;
    }
    
    /**
     * Ac Flag: RC
     * Provides VOD file information of a specific song
     * @param type $songid
     * @return type
     */
    public function get_songs_vod($songid){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/'.  $songid.'/vods');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->get_songs_vod($songid);
            }
        }
        
        return $data;
    }
    
    /**
     * AC Flag: RC
     * To view information specific song lyrics
     * @param type $songid
     * @return type
     */
    public function get_songs_lyric($songid){
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $this->mapiUrl . 'songs/'.  $songid.'/lyric');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->get_songs_lyric($songid);
            }
        }
        
        return $data;
    }
    
    /** 
     * experimental get song's file
     * @param type $songId
     * @param type $songName
     * @param type $drmType
     * @param type $bitRate
     * @return type
     */
    public function get_songs_file($songId, $drmType='D', $bitRate=128){
        //$download_url = 'http://ri.melon.co.id:8200/drm/ri/downloadForm.jsp';
        //$download_url = 'http://dn.melon.co.id:8100/drm/download/downloadDcf.jsp?sessionId=1986220fe10aa65335989ba8984291a12561c1e48b17327';
        $download_url = 'http://www.melon.co.id/ajax/cart/song/download.do';
        $fields = array(
            'songId'    => $songId,
            'drmType'   => $drmType,
            'bitRate'    => $bitRate,
            //'contentName'   => urlencode($songName)
        );
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 0);
        curl_setopt($this->curl, CURLOPT_URL, $download_url. '?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = curl_exec($this->curl);
        
        curl_close($this->curl);
	        
        if(isset($data->code) AND $data->code==$this->auth_req_code){
            if (isset($data->message)){
                $this->whichAuthenticate($data->message);
                return $this->get_songs_file($songId, $drmType, $bitRate);
            }
        }
        
        return $data;
    }
    
    public function member_login(){
        $url = 'http://melon.co.id/member/login.do';
        $fields = array(
            'id'    => $this->mbm_user, //melon member account
            'pw'    => $this->mbm_pwd,
            'savedId'   => 'Y',
            'isFirst'   =>  'N',
            'returnUrl' => ''
        );
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        //curl_setopt($this->curl, CURLOPT_URL, $download_url. '?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
	        
        
        
        return $data;
    }
    
    /**
     * AC flag: RU (POST)
     * Get streamer flash object
     * @param type $songid, required
     * @param type $width, optional
     * @param type $height, optional
     * @return type
     */
    public function song_stream_object($songid,$width=300,$height=24){
        $fields = array(
            'cname'     => $this->uname,  //mapi account
            'cpass'     => $this->upass,
            'userid'    => $this->mbm_user, //melon member account
            'passwd'    => $this->mbm_pwd,
            'songid'    => $songid,
            'width'     => $width,
            'height'    => $height
        );
        
        $service_url = 'http://api.melon-service.com/stream';
        
        curl_setopt($this->curl, CURLOPT_COOKIEFILE, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        
        curl_setopt($this->curl, CURLOPT_URL, $service_url);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $fields);
        //curl_setopt($this->curl, CURLOPT_URL, $service_url. '?'.  http_build_query($fields));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        $stream_obj = curl_exec($this->curl);
        
        
        
        return $stream_obj;
    }
    
    /**
     * Helper function to determine which authentication method chould be used
     * @param type $message
     * @return type
     */
    protected function whichAuthenticate($message){
        if (strpos($message, 'User')){
            return $this->authenticationUser();
        }
        else if (strpos($message, 'Client')){
            return $this->authenticationClient();
        }
    }
}

?>
