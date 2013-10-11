<?php

/**
 * Description of Cms
 *
 * @author marwan
 * @email marwan
 */
class Cms extends Ajax {
     
    private $hasTriedSync = FALSE;
    function __construct() {
        parent::__construct();
        
        //load feature model
        $this->load->model('feature_m');
        $this->load->model('channel_m');
        
        //load helper
        $this->load->helper('cms');
        
        $this->_result['found'] = 0;   
        $this->_result['size'] = 0;
    }
        
    function homeimage_getlist(){
        
    }
    function set_as_featured(){
        $channel_id = $this->input->post('channel_id');
        $item_id = $this->input->post('item_id');
        $callback = $this->input->post('callback');
        
        if ($channel_id && $item_id){
            $this->feature_m->set_as_featured($channel_id, $item_id);
            if ($callback) echo 1;
        }
        
        if ($callback) echo 0;
    }
    
    function channel_featured_items(){
        $channel_id = $this->input->post('channel_id');   
        $channel_name = $this->input->post('channel_name');
        
        $page = $this->input->post('page'); if (!$page) $page = 1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $offset = $page-1;
        $start = $offset * $limit;
        
        //load album model already load in contructor
        
        $where = array('channel_id' => $channel_id);
        
        $totalSize = $this->feature_m->get_count($where);
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $this->feature_m->get_offset('*', $where, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/featured/edit/'.$channel_id.'/'.$item->item_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/featured/delete/'.$channel_id.'/'.$item->item_id, 'title="Delete"');
                if ($item->cover)
                    $item->cover = base_url ($this->feature_m->feature_image_path.$channel_name.'/'.$item->cover);
                
                //get item name
                switch($channel_name){
                    case 'music':
                        $this->load->model('music/album');
                        $row = $this->album->get_select_where('albumName',array('albumId'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->albumName: NULL;
                        break;
                    case 'movie':
                        $this->load->model('movie/items');
                        $row = $this->items->get_select_where('item_name',array('id'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->item_name: NULL;
                        break;
                    case 'wow':
                        $this->load->model('wow/items');
                        $row = $this->items->get_select_where('item_name',array('id'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->item_name: NULL;
                        break;
                    case 'games':
                        $this->load->model('games/items');
                        $row = $this->items->get_select_where('title',array('ID'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->title: NULL;
                        break;
                    case 'book':
                        $this->load->model('book/items');
                        $row = $this->items->get_select_where('name',array('content_id_token'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->name: NULL;
                        break;
                    case 'apps':
                        $this->load->model('apps/items');
                        $row = $this->items->get_select_where('package_name',array('package_id'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->package_name: NULL;
                        break;
                    case 'radio':
                        $this->load->model('radio/items');
                        $row = $this->items->get_select_where('radio_name',array('radio_name'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->radio_name: NULL;
                        break;
                    case 'tv':
                        $this->load->model('tv/tv_schedules');
                        $row = $this->tv_schedules->get_select_where('acara',array('schedule_genid'=>$item->item_id),TRUE);
                        $item_name = $row ? $row->acara: NULL;
                        break;
                }
                $item->item_name = $item_name;
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            $this->_result['found'] = count($datalist);
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$channel_id.',"'.$channel_name.'",$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function coverstory_items(){
        $page = $this->input->post('page'); if (!$page) $page = 1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $offset = $page-1;
        $start = $offset * $limit;
        
        //load cover story model
        $this->load->model('coverstory_m');
        
        $totalSize = $this->coverstory_m->get_count();
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $this->coverstory_m->get_offset('*', NULL, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/coverstory/edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/coverstory/delete/'.$item->id, 'title="Delete"');
                if ($item->image_url)
                    $item->image_url = base_url ($this->coverstory_m->image_path.$item->image_url);
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            $this->_result['found'] = count($datalist);
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function get_genre_by_category(){
		$this->load->helper('cms');
        $categoryId = $this->input->post('categoryId');        
        $page = $this->input->post('page'); if (!$page) $page = 1;        
        $offset = $page-1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        $start = $offset * $limit;
        
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        //load album model
        $this->load->model('music/genre');
        $where = array('categoryId' => $categoryId);
        
        $totalSize = $this->genre->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $result = $this->genre->get_offset($fields, $where, $start, $limit);
            $datalist = array();
            foreach($result as $item){
				if($fields=='*'){
					$item->edit_url = btn_edit('cms/music/genre_edit/'.$item->id, 'title="Edit"');
					$item->delete_url = btn_delete('cms/music/genre_delete/'.$item->id, 'title="Delete"');
                }
                $datalist [] = $item;
            }
			
        $this->_result['totalSize'] = $totalSize;
        $this->_result['totalPages'] = $totalPages;
        $this->_result['offset'] = $offset;
        $this->_result['start'] = $start;
        $this->_result['items'] = $datalist;        
        $this->_result['size'] = count($datalist); 
        
        //create js paging
        $jsClick = 'javascript:loadGenreByCategory('.$categoryId.',$);';
        $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
    }
    
    function get_album_by_genre(){
        $genreId = $this->input->post('genreId');
        $page = $this->input->post('page'); if (!$page) $page = 1;        
        $offset = $page-1;      
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        //load album model
        $this->load->model('music/album');
        $where = array('genreId' => $genreId);
        
        $totalSize = $this->album->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $result = $this->album->get_offset($fields, $where, $start, $limit);
        
        $datalist = array();
        foreach($result as $item){
            if($fields=='*'){
					$item->edit_url = btn_edit('cms/music/album_edit/'.$item->id, 'title="Edit"');
					$item->delete_url = btn_delete('cms/music/album_delete/'.$item->id, 'title="Delete"');
                }
            //check if it is a featured
            $channel_id = $this->getChannelId('music');
            if ($this->feature_m->is_featured($channel_id,$item->albumId)){
                $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
            }else{
                $item->is_featured = '<a id="a_'.$item->albumId.'" href="javascript:setItemAsFeatured('.$channel_id.','.$item->albumId.');"><i class="icon-hand-right" title="set featured"></i></a>';
            }
            $datalist [] = $item;
        }
        $this->_result['totalSize'] = $totalSize;
        $this->_result['totalPages'] = $totalPages;
        $this->_result['offset'] = $offset;
        $this->_result['start'] = $start;
        $this->_result['items'] = $datalist;        
        $this->_result['size'] = count($datalist);   
        
        //create js paging
        $jsClick = 'javascript:loadAlbumsByGenre('.$genreId.',$);';
        $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
    }
    
    function get_album_by_artist(){
		$this->load->helper('cms');
        $artistId = $this->input->post('artistId');
        $page = $this->input->post('page'); if (!$page) $page = 1;        
        $offset = $page-1;      
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        //load album model
        $this->load->model('music/album');
        $where = array('mainArtistId' => $artistId);
        
        $totalSize = $this->album->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
		$result = $this->album->get_offset($fields, $where, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
				if($fields=='*'){
					$item->edit_url = btn_edit('cms/music/album_edit/'.$item->id, 'title="Edit"');
					$item->delete_url = btn_delete('cms/music/album_delete/'.$item->id, 'title="Delete"');
                }
                $datalist [] = $item;
            }
        $this->_result['totalSize'] = $totalSize;
        $this->_result['totalPages'] = $totalPages;
        $this->_result['offset'] = $offset;
        $this->_result['start'] = $start;
        $this->_result['items'] = $datalist;        
        $this->_result['size'] = count($datalist);   
        
        //create js paging
        //load helper
        $this->load->helper('cms');
        $jsClick = 'javascript:loadAlbumsByArtist('.$artistId.',$);';
        $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
    }

    function get_artist_by_index(){
        //load model
        $this->load->model('music/artist');
        $MM = $this->artist;
        
        $letter = $this->input->post('letter'); if (!$letter) $letter = 'A';
        $page = $this->input->post('page'); 
        if (!$page) $page=1;
        
        $offset = $page-1;
        
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        
        $like = array(
                    'field'     =>  'artistName',
                    'value'     =>  $letter,
                    'position'  =>  'after'
        );
        $totalSize = $MM->get_like_count($like);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_like($like, $fields, $start, $limit);
			$result = $MM->get_like($like, $fields, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
				if($fields=='*'){
					$item->edit_url = btn_edit('cms/music/artist_edit/'.$item->id, 'title="Edit"');
					$item->delete_url = btn_delete('cms/music/artist_delete/'.$item->id, 'title="Delete"');
                }
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
        }
        
        //create js paging
        $jsClick = 'javascript:loadArtistByIndex("'.$letter.'",$);';
        $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
    }
    
    function get_artist_by_genre(){
        //load helper
        $this->load->helper('cms');
        //load model
        $this->load->model('music/artist');
        $MM = $this->artist;
        
        $genre = $this->input->post('genreId');
        $page = $this->input->post('page'); 
        if (!$page) $page=1;
        
        $offset = $page-1;
        
        $limit = $this->input->post('limit'); if (!$limit) $limit = -1;
        
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        
        $where = array( 'genreId'=> $genre);
        $totalSize = $MM->get_count($where);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            $datalist = $MM->get_by($where);
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;
            $this->_result['size'] = count($datalist);   
        }
        
        //create js paging
    }

    function get_song_by_album(){
        $albumId = $this->input->post('albumId');    
        $page = $this->input->post('page'); if (!$page) $page=1;
        $offset = $page-1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 15;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        $autosync = $this->input->post('autoSync');
        
        //load album model
        $this->load->model('music/song');
        
        $where = array('albumId' => $albumId);
        
        $totalSize = $this->song->get_count($where);
        
        if ($totalSize==0){
            if (!$this->hasTriedSync && ($autosync && $autosync=='1')){
                //set flag that we have tried sync to avoid repeatation
                $this->hasTriedSync = TRUE;
                //sync the song from album
                //load Syncronize API library
                $this->load->library('syncronize/Syncmusic');
                if ($albumId)
                    $sync_count = $this->syncmusic->songByAlbum($albumId);
                
                //recount
                $totalSize = $sync_count;
            }
        }
        
        $totalPages = ceil($totalSize/$limit);
        
        if ($totalSize>0){
			$result = $this->song->get_offset($fields, $where, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
				if($fields=='*'){
					$item->edit_url = btn_edit('cms/music/song_edit/'.$item->id, 'title="Edit"');
					$item->delete_url = btn_delete('cms/music/song_delete/'.$item->id, 'title="Delete"');
                }
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
        }
        
        
        //create js paging
        $jsClick = 'javascript:loadSongs('.$albumId.',$);';
        $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
    }

    function get_songmod_by_category(){
        //load model
        $this->load->model('music/songmod');
        $MM = $this->songmod;
        
        $categoryId = $this->input->post('categoryId');
        $page = $this->input->post('page'); 
        if (!$page) $page=1;
        
        $offset = $page-1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('music_songs.categoryId' => $categoryId);
        $totalSize = $MM->get_count_join($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

			$result = $MM->get_offset($fields, $where, $start, $limit);
            $datalist = array();
            foreach($result as $item){
				if($fields=='*'){
					$item->edit_url = btn_edit('cms/music/songmode_edit/'.$item->id_songmod, 'title="Edit"');
					$item->delete_url = btn_delete('cms/music/songmode_delete/'.$item->id_songmod, 'title="Delete"');
                }
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadSongMod('.$categoryId.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function apps_get_category(){
        //load model
        $this->load->model('apps/category');
        $MM = $this->category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            $datalist = array();    
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/apps/category_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/apps/category_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function apps_get_items(){
        //load model
        $this->load->model('apps/items');
        $MM = $this->items;
        
        $parent_id = $this->input->post('parent_id'); 
        $category_id = $this->input->post('category_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('parent_id'=>$parent_id, 'category_id'=>$category_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/apps/items_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/apps/items_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$parent_id.','.$category_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function apps_get_featured(){
        //load model
        $this->load->model('apps/featured');
        $MM = $this->featured;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result  = $MM->get_offset('*', $where, $offset, $limit);

            foreach($result as $item){
                $item->edit_url = btn_edit('cms/apps/featured_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/apps/featured_delete/'.$item->id, 'title="Delete"');
                
                //check if it is a featured
                $channel_id = $this->getChannelId('apps');
                if ($this->feature_m->is_featured($channel_id,$item->package_id)){
                    $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
                }else{
                    $item->is_featured = '<a id="a_'.$item->package_id.'" href="javascript:setItemAsFeatured('.$channel_id.','.$item->package_id.');"><i class="icon-hand-right" title="set featured"></i></a>';
                }
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function book_get_category(){
        //load model
        $this->load->model('book/category');
        $MM = $this->category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $offset, $limit); // rename
            $result = $MM->get_offset('*', $where, $offset, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/book/category_edit/'.$item->category_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/book/category_delete/'.$item->category_id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function book_get_items(){
        //load model
        $this->load->model('book/items');
        $MM = $this->items;
        
        $category_id = $this->input->post('category_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('category_id'=>$category_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            $datalist = array();
            foreach($result as $item){
                //check if it is a featured
                $channel_id = $this->getChannelId('book');
                if ($this->feature_m->is_featured($channel_id,$item->content_id_token)){
                    $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
                }else{
                    $item->is_featured = '<a id="a_'.$item->content_id_token.'" href="javascript:setItemAsFeatured('.$channel_id.',\''.$item->content_id_token.'\');"><i class="icon-hand-right" title="set featured"></i></a>';
                }
                $item->edit_url = btn_edit('cms/book/items_edit/'.$item->auto_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/book/items_delete/'.$item->auto_id, 'title="Delete"');
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$category_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function book_get_featured(){
        //load model
        $this->load->model('book/featured');
        $MM = $this->featured;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $offset, $limit); // rename
            $result = $MM->get_offset('*', $where, $offset, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/book/featured_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/book/featured_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function book_get_topdownload(){
        //load model
        $this->load->model('book/topdownload');
        $MM = $this->topdownload;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $offset, $limit); // rename
            $result = $MM->get_offset('*', $where, $offset, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/book/topdownload_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/book/topdownload_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function radio_get_category(){
        //load model
        $this->load->model('radio/category');
        $MM = $this->category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $start, $limit); //rename
            $result = $MM->get_offset('*', $where, $start, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/radio/category_edit/'.$item->category_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/radio/category_delete/'.$item->category_id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }

    // new radio_get_genres
    function radio_get_genres(){
        //load model
        $this->load->model('radio/genres');
        $MM = $this->genres;
        
        $category_id = $this->input->post('category_id');
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        //$where = NULL;
        $where = array('category_id'=>$category_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $start, $limit); //rename
            $result = $MM->get_offset('*', $where, $start, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/radio/genre_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/radio/genre_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function radio_get_items(){
        //load model
        $this->load->model('radio/items');
        $MM = $this->items;
        
        $radio_source = $this->input->post('radio_source'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('radio_source'=>$radio_source);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $offset, $limit); // rename
            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/radio/items_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/radio/items_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems("'.$radio_source.'",$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }

    }
    
    function games_get_category(){
        //load model
        $this->load->model('games/category');
        $MM = $this->category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $start, $limit); //rename
            $result = $MM->get_offset('*', $where, $start, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/games/category_edit/'.$item->category_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/games/category_delete/'.$item->category_id, 'title="Delete"');
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function games_get_apis(){
        //load model
        $this->load->model('games/game_apis');
        $MM = $this->game_apis;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            //$datalist = $MM->get_offset('*', $where, $start, $limit); //rename
            $result = $MM->get_offset('*', $where, $start, $limit);

            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/games/apis_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/games/apis_delete/'.$item->id, 'title="Delete"');
                
                $sync_url_text = '<i class="icon-repeat" id="icon-repeat-'.$item->id.'"></i>';
                $sync_url_text .= '<span id="loader-sync-'.$item->id.'" class="ajax-loader-small"></span>';
                $item->sync_url = '<a href="javascript:syncSelectedApi('.$item->id.')"; title="Snycronize this api">'. $sync_url_text. '</a>';
                
                $datalist [] = $item;
            }

            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function games_get_items(){
        //load model
        $this->load->model('games/items');
        $MM = $this->items;
        
        $category_id = $this->input->post('category_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $like = array(
            'field'     =>  'categories',
            'value'     =>  $category_id,
            'position'  =>  'both'
        );
        $totalSize = $MM->get_like_count($like);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_like($like, '*', $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                //check if it is a featured
                $channel_id = $this->getChannelId('games');
                if ($this->feature_m->is_featured($channel_id,$item->ID)){
                    $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
                }else{
                    $item->is_featured = '<a id="a_'.$item->ID.'" href="javascript:setItemAsFeatured('.$channel_id.','.$item->ID.');"><i class="icon-hand-right" title="set featured"></i></a>';
                }
                $item->edit_url = btn_edit('cms/games/items_edit/'.$item->autoId, 'title="Edit"');
                $item->delete_url = btn_delete('cms/games/items_delete/'.$item->autoId, 'title="Delete"');
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems("'.$category_id.'",$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function wow_get_category(){
        //load model
        $this->load->model('wow/category');
        $MM = $this->category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/wow/category_edit/'.$item->category_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/wow/category_delete/'.$item->category_id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function wow_get_items(){
        //load model
        $this->load->model('wow/items');
        $MM = $this->items;
        
        $category_id = $this->input->post('category_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('category_id'=>$category_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/wow/items_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/wow/items_delete/'.$item->id, 'title="Delete"');
                $item->upload_url = btn_upload('cms/wow/items_upload/'.$item->id);
                
                //check if it is a featured
                $channel_id = $this->getChannelId('wow');
                if ($this->feature_m->is_featured($channel_id,$item->id)){
                    $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
                }else{
                    $item->is_featured = '<a id="a_'.$item->id.'" href="javascript:setItemAsFeatured('.$channel_id.','.$item->id.');"><i class="icon-hand-right" title="set featured"></i></a>';
                }
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$category_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function wow_get_like(){
        //load model
        $this->load->model('wow/like_list');
        $MM = $this->like_list;
        
        $item_id = $this->input->post('item_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('item_id'=>$item_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            $this->load->model('user_m');
            foreach($result as $item){
                $item->delete_url = btn_delete('cms/wow/like_delete/'.$item->id, 'title="Delete"');
                $user = $this->user_m->get_select_where('u_name', array('id'=>$item->user_id), TRUE);
                if ($user)
                    $item->user_name = $user->u_name;
                else
                    $item->user_name = 'unknown';

                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$item_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function movie_get_category(){
        //load model
        $this->load->model('movie/category');
        $MM = $this->category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/category_edit/'.$item->category_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/category_delete/'.$item->category_id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }


    function movie_get_subcategory(){
        //load model
        $this->load->model('movie/subcategory');
        $MM = $this->subcategory;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/featured_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/featured_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }

    function movie_get_source(){
        //load model
        $this->load->model('movie/source');
        $MM = $this->source;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/source_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/source_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }

    
    function movie_get_city(){
        //load model
        $this->load->model('movie/city');
        $MM = $this->city;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/city_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/city_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadCategory($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    

    function movie_get_theater(){
        //load model
        $this->load->model('movie/theater');
        $MM = $this->theater;
        
        $city_id = $this->input->post('city_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('city_id'=>$city_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            $this->load->model('movie/city');
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/theater_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/theater_delete/'.$item->id, 'title="Delete"');
                $user = $this->city->get_select_where('name', array('id'=>$item->city_id), TRUE);
                if ($user)
                    $item->city_name = $user->name;
                else
                    $item->city_name = 'unknown';

                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$city_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }

    function movie_get_schedule(){
        //load model
        $this->load->model('movie/schedule');
        $MM = $this->schedule;
        
        $theater_id = $this->input->post('theater_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('theater_id'=>$theater_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            $this->load->model('movie/city');
            $this->load->model('movie/theater');
            $this->load->model('movie/items');
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/schedule_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/schedule_delete/'.$item->id, 'title="Delete"');
                $city_n = $this->city->get_select_where('name', array('id'=>$item->city_id), TRUE);
                if ($city_n)
                    $item->city_name = $city_n->name;
                else
                    $item->city_name = 'unknown';

                $theater_n = $this->theater->get_select_where('name', array('id'=>$item->theater_id), TRUE);
                if ($theater_n)
                    $item->theater_name = $theater_n->name;
                else
                    $item->theater_name = 'unknown';

                $movie_n = $this->items->get_select_where('item_name', array('id'=>$item->item_id), TRUE);
                if ($movie_n)
                    $item->movie_title = $movie_n->item_name;
                else
                    $item->movie_title = 'unknown';

                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$theater_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }


    function movie_get_rating(){
        //load model
        $this->load->model('movie/rating');
        $MM = $this->rating;
        
        $item_id = $this->input->post('item_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('item_id'=>$item_id);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            $this->load->model('movie/items');
            $this->load->model('movie/source');
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/rating_edit/'.$item_id.'/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/rating_delete/'.$item_id.'/'.$item->id, 'title="Delete"');
                $itm = $this->items->get_select_where('item_name', array('id'=>$item->item_id), TRUE);
                if ($itm)
                    $item->item_names = $itm->item_name;
                else
                    $item->item_names = 'unknown';

                $srce = $this->source->get_select_where('name', array('id'=>$item->source_id), TRUE);
                if ($srce)
                    $item->names = $srce->name;
                else
                    $item->names = 'unknown';

                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$item_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }



    function movie_get_items(){
        //load model
        $this->load->model('movie/items');
        $MM = $this->items;
        
        $category_id = $this->input->post('category_id'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $like = array(
            'field'     =>  'categories',
            'value'     =>  $category_id,
            'position'  =>  'both'
        );
        $totalSize = $MM->get_like_count($like);
        $totalPages = ceil($totalSize/$limit);
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_like($like, '*', $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/movie/items_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/movie/items_delete/'.$item->id);
                $item->upload_url = btn_upload('cms/movie/items_upload/'.$item->id);
                $item->rating_url = '<a href="'.base_url('cms/movie/items_rating/'.$item->id).'"><i class="icon-star-empty"></i></a>';
                
                //check if it is a featured
                $channel_id = $this->getChannelId('movie');
                if ($this->feature_m->is_featured($channel_id,$item->id)){
                    $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
                }else{
                    $item->is_featured = '<a id="a_'.$item->id.'" href="javascript:setItemAsFeatured('.$channel_id.','.$item->id.');"><i class="icon-hand-right" title="set featured"></i></a>';
                }
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems('.$category_id.',$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function movie_get_row(){
        //load model
        $this->load->model('movie/items');
        $MM = $this->items;
        
        $row = $MM->get($this->input->post('id'), TRUE);
        $video = array();
        if ($row->item_url_webm!=''){
            $video[] = array(
                'item_url' => base_url('userfiles/movie').'/'.$row->item_url_webm,
                'type'     => 'video/webm'
            );
        }
        if ($row->item_url_mpeg!=''){
            $video[] = array(
                'item_url' => base_url('userfiles/movie').'/'.$row->item_url_mpeg,
                'type'     => 'video/mp4'
            );
        }
        if ($row->item_url_ogg!=''){
            $video[] = array(
                'item_url' => base_url('userfiles/movie').'/'.$row->item_url_ogg,
                'type'     => 'video/ogg'
            );
        }
        $this->_result['item'] = $video;
        $this->_result['size'] = count($video);
    }
    
    function wow_get_row(){
        //load model
        $this->load->model('wow/items');
        $MM = $this->items;
        
        $row = $MM->get($this->input->post('id'), TRUE);
        $video = array();
        if ($row->item_url!=''){
            $video[] = array(
                'item_url' => base_url('userfiles/wow').'/'.$row->item_url,
                'type'     => 'video/mp4'
            );
        }
        $this->_result['item'] = $video;
        $this->_result['size'] = count($video);
    }
    
    function tv_get_items(){
        //load model
        $this->load->model('tv/stations');
        $MM = $this->stations;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $totalSize = $MM->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            
			$result = $MM->get_offset($fields, null, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tv/station_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tv/station_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tv_category_get_items(){
        //load model
        $this->load->model('tv/tv_category');
        $MM = $this->tv_category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $totalSize = $MM->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            
            $result = $MM->get_offset('*', null, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tv/category_edit/'.$item->category_id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tv/category_delete/'.$item->category_id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tv_get_streams(){
        //load model
        $this->load->model('tv/tv_streamurl');
        $MM = $this->tv_streamurl;
        
        $streamtype = $this->input->post('streamtype'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('streamtype' => $streamtype);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            
			$result = $MM->get_offset($fields, $where, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tv/streams_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tv/streams_delete/'.$item->id, 'title="Delete"');
                
                $item->source = $item->source==0?'API':'CMS';
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems("'.$streamtype.'",$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tv_get_vods(){
        //load model
        $this->load->model('tv/tv_vod');
        $MM = $this->tv_vod;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $totalSize = $MM->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            
			$result = $MM->get_offset('*', null, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tv/vod_edit/'.$item->autoId, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tv/vod_delete/'.$item->autoId, 'title="Delete"');
                $item->upload_url = btn_upload('cms/tv/vod_upload/'.$item->autoId, 'title="Upload"');
                
                $item->source = $item->source==0?'API':'CMS';
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tv_get_schedules(){
        //load model
        $this->load->model('tv/tv_schedules');
        $MM = $this->tv_schedules;
        
        $tvcode = $this->input->post('tvcode'); 
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = array('tvcode' => $tvcode);
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            
            $result = $MM->get_offset($fields, $where, $start, $limit);
            
            $datalist = array();
            
            //Load category tv to categorize schedule
            $this->load->model('tv/tv_category');
            
            //get all tv category to be list in button
            $tv_list_cats = $this->tv_category->get();
            $tv_categories = array();
            foreach($tv_list_cats as $cat){
                $tv_categories[$cat->category_id] = $cat->category_name;
            }
                    
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tv/schedules_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tv/schedules_delete/'.$item->id, 'title="Delete"');
                
                $item->source = $item->source==0?'API':'CMS';
                
                //check if it is a featured
                $channel_id = $this->getChannelId('tv');
                if ($this->feature_m->is_featured($channel_id,$item->schedule_genid)){
                    $item->is_featured = '<i class="icon-thumbs-up" title="is featured"></i>';
                }else{
                    $item->is_featured = '<a id="a_'.$item->schedule_genid.'" href="javascript:setItemAsFeatured('.$channel_id.',\''.$item->schedule_genid.'\');"><i class="icon-hand-right" title="set featured"></i></a>';
                }
                
                //get category
                if (isset($tv_categories[$item->category]))
                    $category_name = $tv_categories[$item->category];
                else
                    $category_name = 'Other';
                
                //create categories button
                $str_categories = '<div class="btn-group">';
                $str_categories.= '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">';
                $str_categories.= '<span id="catselect_'.$item->id.'">'.$category_name.'</span>';
                $str_categories.= '<span class="caret"></span>';
                $str_categories.= '</a>';
                $str_categories.= '<ul class="dropdown-menu">';
                foreach($tv_categories as $key=>$val){
                    $str_categories.= '<li><a href="javascript:setTVScheduleItemCategory('.$item->id.',\''.$val.'\', '.$key.');">'.$val.'</a></li>';
                }
                $str_categories.= '</ul>';
                $str_categories.= '</div>';
                
                $item->category_buttons = $str_categories;
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems("'.$tvcode.'",$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tv_schedule_set_category(){
        //load model
        $this->load->model('tv/tv_schedules');
        $MM = $this->tv_schedules;
        
        $id = $this->input->post('id'); 
        $category = $this->input->post('category');
        
        $update= array('category'=>$category);
        if ($MM->save($update, $id)){
            $this->_result['status'] = 1;
        }
        else{
            $this->_result['status'] = 0;
        }
    }
    
    function tovi_get_parents(){
        //load model
        $this->load->model('tv/tovi_parent_category');
        $MM = $this->tovi_parent_category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $totalSize = $MM->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            $result = $MM->get_offset('*', null, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tovi/parent_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tovi/parent_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tovi_get_categories(){
        //load model
        $this->load->model('tv/tovi_category');
        $MM = $this->tovi_category;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $totalSize = $MM->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            $result = $MM->get_offset('*', null, $start, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/tovi/category_edit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/tovi/category_delete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function tovi_get_items(){
        //load model
        $this->load->model('tv/tovi_items');
        $MM = $this->tovi_items;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $totalSize = $MM->get_count();
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);
            $result = $MM->get_offset('*', null, $start, $limit);
            
            $datalist = array();
            if ($result){
                foreach($result as $item){
                    $item->edit_url = btn_edit('cms/tovi/items_edit/'.$item->autoId, 'title="Edit"');
                    $item->delete_url = btn_delete('cms/tovi/items_delete/'.$item->autoId, 'title="Delete"');
                    $item->upload_url = btn_upload('cms/tovi/tovi_upload/'.$item->autoId, 'title="Upload"');

                    if ($item->small_image1!='') 
                        $item->image = '<img src="'.$MM->img_base_url.$item->small_image1.'" width="40" />';
                    else
                        $item->image = '';
                    
                    $datalist [] = $item;
                }
            }
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function users_get_list(){
        //load model
        $this->load->model('user_m');
        $MM = $this->user_m;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/admin/useredit/'.$item->id, 'title="Edit"');
                $item->delete_url = btn_delete('cms/admin/userdelete/'.$item->id, 'title="Delete"');
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadUsers($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function groups_get_list(){
        //load model
        $this->load->model('usergroup_m');
        $MM = $this->usergroup_m;
        
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        $where = NULL;
        $totalSize = $MM->get_count($where);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $MM->get_offset('*', $where, $offset, $limit);
            
            $datalist = array();
            foreach($result as $item){
                $item->edit_url = btn_edit('cms/admin/groupedit/'.$item->id, 'title="Edit"');
                if ($item->removable==1)
                    $item->delete_url = btn_delete('cms/admin/groupdelete/'.$item->id, 'title="Delete"');
                else
                    $item->delete_url = '<i class="icon-remove" title="Not removable"></i>';
                
                $datalist [] = $item;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
    
    function groups_get_accesslist(){
        
        $this->load->model('usergroup_m');
        
        $group_id = $this->input->post('group_id');
        $page = $this->input->post('page'); 
        $limit = $this->input->post('limit'); if (!$limit) $limit = 10;
        
        if (!$page) $page=1;
        
        $offset = $page-1;
        $start = $offset * $limit;
        $fields = $this->input->post('fields'); if (!$fields) $fields = '*';
        
        //load roles model
        $this->load->model('roles_m');
        
        //store all role from this group for later iteration
        //load user and role model
        $this->load->model('user_roles_m');
        $group_roles_result = $this->user_roles_m->get_by(array('group_id'=>$group_id));
        $group_roles = array();        
        foreach($group_roles_result as $item){
            $group_roles[$item->role]= $item->enabled;
        }
        
        //count total roles        
        $totalSize = $this->roles_m->get_count(NULL);
        $totalPages = ceil($totalSize/$limit);
        
        $this->_result['size'] = 0; //default value
        
        if ($totalSize > 0)
        {
            $totalPages = ceil($totalSize/$limit);

            $result = $this->roles_m->get_offset('*', NULL, $start, $limit);
            
            $datalist = array();
            foreach($result as $role){
                //if is group super admin enabled all
                $SUPER_ADMIN =1;
                if ($group_id==$SUPER_ADMIN){
                    $role->enabled = 1;
                }else{
                    if (isset($group_roles[$role->id]))
                        $role->enabled = $group_roles[$role->id];
                    else
                        $role->enabled = 0;
                }
                
                $role->edit_url = btn_edit('cms/admin/groupaccess_edit/'.$group_id.'/'.$role->id, 'title="Edit"');
                $role->delete_url = btn_delete('cms/admin/groupaccess_delete/'.$group_id.'/'.$role->id, 'title="Delete"');
                
                $datalist[] = $role;
            }
            
            $this->_result['totalSize'] = $totalSize;
            $this->_result['totalPages'] = $totalPages;
            $this->_result['offset'] = $offset;
            $this->_result['start'] = $start;
            $this->_result['items'] = $datalist;        
            $this->_result['size'] = count($datalist);   
            
            //create js paging
            $jsClick = 'javascript:loadItems($);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
    }
}

/*
 * file location: /engine/application/controllers/ajax/music.php
 */
?>
