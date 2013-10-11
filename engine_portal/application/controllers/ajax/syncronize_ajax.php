<?php

/**
 * Description of Syncronize_ajax
 *
 * @author marwan
 * @email marwan
 */
class Syncronize_ajax extends Ajax {
            
    protected $channel_name = 'music';
    protected $ML = NULL;
    protected $MV = NULL;
    protected $BK = NULL;
            
    
    function __construct() {
        parent::__construct();
        
        //load Syncronize API library
        $this->load->library('syncronize/Syncmusic');
        $this->ML = $this->syncmusic;
        
        $this->_result['found'] = 0;        
    }
    
    function syncronize_category(){
        $result = $this->ML->category();
        if ($result){
            $this->_result['sync_status'] = 1;
            $this->_result['sync_count'] = $result;
            $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            
        }
            
        else
        {
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'No data to syncronize';
            
        }
    }
    
    function syncronize_genre(){
        //get categoryId from segment
        $categoryId = $this->input->post('categoryId');
        if ($categoryId>0){
            $result = $this->ML->genre($categoryId);
            if ($result){
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            else
            {
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }
    }
    
    function syncronize_album_by_category(){
        $categoryId = $this->input->post('categoryId');
        
        //set default return value
        $this->_result['sync_status'] = 0;
        $this->_result['sync_count'] = 0;
        $this->_result['sync_message'] = 'No data to syncronize';
        
        if ($categoryId>0){
            $result = $this->ML->albumByCategory($categoryId);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
        }else{
            $this->_result['sync_message'] = 'Category Id is not defined';
        }
        
    }
    
    function syncronize_album_by_genre(){
        $genreId = $this->input->post('genreId');
        
        //set default return value
        $this->_result['sync_status'] = 0;
        $this->_result['sync_count'] = 0;
        $this->_result['sync_message'] = 'No data to syncronize';
        
        if ($genreId>0){
            $result = $this->ML->albumByGenre($genreId);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            
        }else{
            $this->_result['sync_message'] = 'Genre Id is not defined';
        }
        
    }
    
    function syncronize_song_by_genre(){
        $genreId = $this->input->post('genreId');
        
        $deleteOld = TRUE;
        $syncLyrics = TRUE;
        
        //set default return value
        $this->_result['sync_status'] = 0;
        $this->_result['sync_count'] = 0;
        $this->_result['sync_message'] = 'No data to syncronize';
        
        if ($genreId>0){
            $result = $this->ML->songByGenre($genreId, $deleteOld, $syncLyrics);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
        }else{
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'Syncronize failed';
        }
        
    }
    
    function syncronize_song_by_album(){
        $albumId = $this->input->post('albumId');
        
        $deleteOld = TRUE;
        $syncLryrics = TRUE;
        
        if ($albumId>0){
            $result = $this->ML->songByAlbum($albumId, $deleteOld, $syncLryrics);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            else
            {
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }else{
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'Syncronize failed';
        }
        
    }
    
    function syncronize_song_mod(){
        $songId = $this->input->post('songId');
        
        $deleteOld = TRUE;
        
        if ($songId>0){
            $result = $this->ML->syncSongMod($songId, $deleteOld);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            else
            {
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }else{
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'Syncronize failed';
        }
    }
    
    function syncronize_song_mod_by_category(){
        $categoryId = $this->input->post('categoryId');
        
        $deleteOld = TRUE;
        
        if ($categoryId>0){
            $result = $this->ML->syncSongModByCategory($categoryId, $deleteOld);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            else
            {
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }else{
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'Syncronize failed';
        }
    }
    
    function syncronize_song_mod_by_category_progress_count(){
        $categoryId = $this->input->post('categoryId');
        //load model songmod
        $this->load->model('music/songmod');
        $this->_result['size'] = $this->songmod->get_count_join(array('categoryId'=>$categoryId));
    }
    
    function syncronize_artist_by_artistId(){
        $artistId = $this->input->post('artistId');
        
        if ($artistId>0){
            $result = $this->ML->syncArtistById($artistId);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            else
            {
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }else{
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'Syncronize failed';
        }
        
    }
    
    function syncronize_artist_by_index(){
        $letter = $this->input->post('letter');
        
        if ($letter){
            $result = $this->ML->artistByIndex($letter);
            
            if ($result)
            {
                $this->_result['sync_status'] = 1;
                $this->_result['sync_count'] = $result;
                $this->_result['sync_message'] = 'Syncronize success for '.$result.' records';
            }
            else
            {
                $this->_result['sync_status'] = 0;
                $this->_result['sync_count'] = 0;
                $this->_result['sync_message'] = 'No data to syncronize';
            }
        }else{
            $this->_result['sync_status'] = 0;
            $this->_result['sync_count'] = 0;
            $this->_result['sync_message'] = 'Syncronize failed';
        }
        
    }
    
}

?>
