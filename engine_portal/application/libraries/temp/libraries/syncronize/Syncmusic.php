<?php

/**
 * Description of SyncMusic: Syncronize music channel
 *
 * @author master
 */
class Syncmusic extends Syncronize {
    protected $melon = NULL;
    protected $channel_name = 'music';
    
    function __construct() {
        parent::__construct();
        
        //load Melon Library
        $this->CI->load->library('Melon');
        $this->melon = $this->CI->melon;
    }
    
    public function category($deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/category');
        $CM = $this->CI->category;
        
        //get new category from api
        $new_category = $this->melon->categories();
        
        //only update if success return from api
        if ($new_category && count($new_category)){
            
            //remove old category in database;
            if ($deleteOld)
                $CM->empty_table();
            
            //update with new category
            $existing_fields = $CM->get_fields();
            foreach($new_category as $nc){
                $data_update = array();
                foreach($existing_fields as $field_name){
                    if ($field_name!='id'){
                        if (isset($nc->$field_name)&&$nc->$field_name!=NULL)
                            $data_update[$field_name] = $nc->$field_name;
                    }
                }
                //insert new data using model
                $CM->save($data_update); $count_update++;
            }
            
            //set last update
            $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        }
        
        return $count_update;
    }
    
    public function genre($categoryId, $deleteOld=TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/genre');
        $MG = $this->CI->genre;
        
        //get new category from api
        $new_genre = $this->melon->genres_from_category($categoryId);
        
        //only update if success return from api
        if ($new_genre && count($new_genre)){
            
            //remove old category in database;
            if ($deleteOld)
                $MG->delete_where(array('categoryId'=>$categoryId));
            
            //update with new category
            $existing_fields = $MG->get_fields();
            foreach($new_genre as $n){
                $data_update = array();
                foreach($existing_fields as $field_name){
                    $data_update['categoryId'] = $categoryId;
                    if ($field_name!='id'&&$field_name!='categoryId'){
                        if (isset($n->$field_name)&&$n->$field_name!=NULL)
                            $data_update[$field_name] = $n->$field_name;
                    }
                }
                //insert new data using model
                $MG->save($data_update); $count_update++;
            }
            
            //set last update
            $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        }
        
        return $count_update;
    }
    
    public function albumByGenre($genreId, $deleteOld=TRUE){
        $count_update = 0;
        //get categoryId by genreId
        $this->CI->load->model($this->channel_name.'/genre');
        $categoryId = $this->CI->genre->get_select_where('categoryId',array('genreId'=>$genreId),TRUE)->categoryId;
        
        //load category model
        $this->CI->load->model($this->channel_name.'/album');
        $MM = $this->CI->album;
        
        //get new album from api
        //first we need how many records actually exists in api
        $data = $this->melon->albums_by_genre($genreId,0,1);
        
        if ($data){
            
            if (!isset($data->dataList))
                return $count_update;
            
            $max_data_sync = 5000;            
            $totalSize = $data->totalSize;
            if ($totalSize > $max_data_sync){
                $pages = ceil($totalSize/$max_data_sync)+1;
            }else{
                $pages = 1;
            }
            
            for($page=0; $page< $pages; $page++){
                $start = $page * $max_data_sync;
                //now get all data from api
                $data = $this->melon->albums_by_genre($genreId,$start,$max_data_sync);
                
                if ($data){
                    //real data is in dataList object
                    $dataList = $data->dataList;
                }

                if ($dataList && count($dataList)){

                    if ($deleteOld)
                        $MM->delete_where(array('genreId'=>$genreId));

                    //Update with new data
                    
                    $existing_fields = $MM->get_fields();
                    foreach($dataList as $n){
                        $data_update = array('categoryId'=>$categoryId);

                        foreach($existing_fields as $field_name){
                            if ($field_name!='id'){
                                if (isset($n->$field_name)&&$n->$field_name!=NULL)
                                    $data_update[$field_name] = $n->$field_name;
                            }
                        }

                        //insert new data using model
                        $MM->save($data_update); $count_update++;
                    }
                }
            }
            
            //set last update
            $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        }
                
        return $count_update;
    }
    
    public function albumByCategory($categoryId, $deleteOld=TRUE){
        //load genre by category
        $this->CI->load->model($this->channel_name.'/genre');
        $genres = $this->CI->genre->get_select_where('genreId', array('categoryId'=>$categoryId));
        
        //start updating for each genre
        $count_update = 0;
        foreach($genres as $genre){
            $count_update += $this->albumByGenre($genre->genreId, $deleteOld);
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
            
        return $count_update;
    }
    
    public function songByGenre($genreId, $deleteOld=TRUE, $updateLyricAndArtist = TRUE){
        //First load all albums in this genre
        $this->CI->load->model($this->channel_name.'/album');
        $albums = $this->CI->album->get_select_where('albumId', array('genreId'=>$genreId));
        
        //start updating song for each album
        $count_update = 0;
        foreach ($albums as $album){
            $count_update += $this->songByAlbum($album->albumId, $deleteOld, $updateLyricAndArtist);
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
            
        return $count_update;
    }
    
    public function songByAlbum($albumId, $deleteOld = TRUE, $updateLyricAndArtist = TRUE){
        //get categoryId by genreId
        $this->CI->load->model($this->channel_name.'/album');        
        $categoryId = $this->CI->album->get_select_where('categoryId',array('albumId'=>$albumId),TRUE)->categoryId;
        
        $count_update = 0;
        //load category model
        $this->CI->load->model('music/song');
        $MM = $this->CI->song;
        
        //get new album from api
        //first we need how many records actually exists in api
        $data = $this->melon->songs_from_album($albumId,0,1);
        if ($data){
            
            if (!isset($data->dataList))
                return $count_update;
            
            $totalSize = $data->totalSize;
            
            if ($totalSize > 1)
            {
                //now get all data from api
                $data = $this->melon->songs_from_album($albumId,0,$totalSize);
            }
            
            //real data is in dataList object
            $dataList = $data->dataList;
            
            if ($dataList && count($dataList)){
                if ($deleteOld)
                    $MM->delete_where(array('albumId'=>$albumId));
                
                //Update with new data
                $existing_fields = $MM->get_fields();
                foreach($dataList as $n){
                    $data_update = array();
                    $data_update['categoryId'] = $categoryId;
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($n->$field_name)&&$n->$field_name!=NULL)
                                $data_update[$field_name] = $n->$field_name;
                        }
                    }
                    
                    //insert new data using model
                    $MM->save($data_update); $count_update++;
                    
                    //Update lyrics and Artist
                    if ($updateLyricAndArtist)
                    {
                        if($n->textLyricYN=='Y'||$n->slfLyricYN=='Y'){
                            $this->lyricBySong($n->songId);
                        }
                            
                        if ($n->artistId){
                            $this->syncArtistById($n->artistId);
                        }
                    }
                }
            }
            
            //set last update
            $this->API_M->api_last_update($this->channel_name, __FUNCTION__, 0, $albumId);
        }
                
        return $count_update;
    }
    
    public function syncSongMod($songId, $deleteOld = TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/songmod');
        $MM = $this->CI->songmod;
        
        //get new data from api
        //do all for all codecs type
        $codes = array('CT0001','CT0002','CT0004');
        foreach($codes as $codec)
        {
            $data = $this->melon->get_songs_mod($songId,$codec);
            if ($data){
                if ($deleteOld)
                    $MM->delete_where(array('songId'=>$songId, 'codecTypeCd'=>$codec));

                //Update with new data
                $existing_fields = $MM->get_fields();
                foreach($data as $n){
                    $data_update = array('songId'=>$songId);
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($n->$field_name)&&$n->$field_name!=NULL)
                                $data_update[$field_name] = $n->$field_name;
                        }
                    }

                    //insert new data using model
                    $MM->save($data_update); $count_update++;

                }
            }
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__,0,0,$songId);
                
        return $count_update;
    }
    
    public function syncSongModByCategory($categoryId){
        //load category model
        $this->CI->load->model($this->channel_name.'/song');
        $MM = $this->CI->song;
        
        $count_update = 0;
        
        $songs = $MM->get_select_where('songId', array('categoryId'=>$categoryId));
        if (!$songs) return $count_update;
        
        foreach($songs as $song){
            $count_update += $this->syncSongMod($song->songId, TRUE);
        }
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__, $categoryId);
        
        return $count_update;
    }
    
    public function lyricBySong($songId, $deleteOld = TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/lyric');
        $M_LR = $this->CI->lyric;
        
        //get new album from api
        //first we need how many records actually exists in api
        $data = $this->melon->get_songs_lyric($songId);
        if ($data){       
            if (isset($data->code)&&$data->code=='EA001'){
                return $count_update;
            }
            
            if ($deleteOld)
                $M_LR->delete_where(array('songId'=>$songId));

            //Update with new data
            $existing_fields = $M_LR->get_fields();
            
            $data_update = array();
            foreach($existing_fields as $field_name){
                if ($field_name!='id'){
                    if (isset($data->$field_name)&&$data->$field_name!=NULL){
                        $data_update[$field_name] = $data->$field_name;
                    }
                }
            }
                
            //insert new data using model
            $M_LR->save($data_update); $count_update++;
        }
                
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__,0,0,$songId);
        
        return $count_update;
    }
    
    public function syncArtistById($artistId, $deleteOld = TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/artist');
        $MM = $this->CI->artist;
        
        //get new album from api
        //first we need how many records actually exists in api
        $data = $this->melon->artists($artistId);
        if ($data){       
            if (isset($data->code)&&$data->code=='EA001'){
                return $count_update;
            }
            
            if ($deleteOld)
                $MM->delete_where(array('artistId'=>$artistId));

            //Update with new data
            $existing_fields = $MM->get_fields();
            
            $data_update = array();
            foreach($existing_fields as $field_name){
                if ($field_name!='id'){
                    if (isset($data->$field_name)&&$data->$field_name!=NULL){
                        $data_update[$field_name] = $data->$field_name;
                    }
                }
            }
                
            //insert new data using model
            $MM->save($data_update); $count_update++;
        }
                
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__,0,0,$artistId);
        
        return $count_update;
    }
    
    
    public function artistByIndex($index, $deleteOld = TRUE){
        $count_update = 0;
        //load category model
        $this->CI->load->model($this->channel_name.'/artist');
        $MM = $this->CI->artist;
        
        //get new album from api
        //first we need how many records actually exists in api
        $data = $this->melon->search_index_artist($index,0,1);
        if ($data){
            
            if (!isset($data->dataList))
                return $count_update;
            
            $totalSize = $data->totalSize;
            
            if ($totalSize > 1)
            {
                //now get all data from api
                $data = $this->melon->search_index_artist($index,0,$totalSize);
            }
            
            //real data is in dataList object
            $dataList = $data->dataList;
            
            if ($dataList && count($dataList)){
                if ($deleteOld)
                    $MM->delete_like(array('field'=>'artistName','value'=>$index,'position'=>'after'));
                
                //Update with new data
                $existing_fields = $MM->get_fields();
                foreach($dataList as $n){
                    $data_update = array();
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($n->$field_name)&&$n->$field_name!=NULL)
                                $data_update[$field_name] = $n->$field_name;
                        }
                    }
                    
                    //insert new data using model
                    $MM->save($data_update); $count_update++;
                }
            }
        }
                
        
        //set last update
        $this->API_M->api_last_update($this->channel_name, __FUNCTION__, 0, 0, 0, $index);
        
        return $count_update;
    }
    
    public function syncByChartLatest(){
        $this->CI->load->model($this->channel_name.'/genre'); //need to get categoryId from genreId
        
        $count_update = 0;
        //load model
        //load category model
        $this->CI->load->model($this->channel_name.'/album');
        $MG = $this->CI->album;
        
        //get new category from api
        $data = $this->melon->chart_weekly_latest();
        
        //only update if success return from api
        if ($data){
            if (isset($data->size)&&$data->size > 0 )
            {
                $datalist = $data->dataList;                
                $existing_fields = $MG->get_fields();
                foreach($datalist as $n){
                    $MG->delete_where(array('albumId'=>$n->albumId));
                    
                    $data_update = array();
                    //get album detail
                    $album  = $this->melon->album_detail($n->albumId);
                    //get categoryId by genreId                        
                    $categoryId = @$this->CI->genre->get_select_where('categoryId',array('genreId' => $album->genreId),TRUE)->categoryId;
                    if (!$categoryId) $categoryId = 0;
                    $data_update['categoryId'] = $categoryId;
                    foreach($existing_fields as $field_name){
                        if ($field_name!='id'){
                            if (isset($album->$field_name)&&$album->$field_name!=NULL)
                                $data_update[$field_name] = $album->$field_name;
                        }
                        
                    }
                    //insert new data using model
                    $MG->save($data_update); $count_update++;
                }
            }

            //set last update
            $this->API_M->api_last_update($this->channel_name, __FUNCTION__);
        }
        
        return $count_update;
    }
    
}

?>
