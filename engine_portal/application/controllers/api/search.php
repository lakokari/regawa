<?php

/**
 * Description of search
 *
 * @author Marwan
 * @email amazzura.biz@gmail.com
 */
class Search extends Tapi {
    protected $_req_auth        = TRUE;
    protected $_log_requests    = TRUE;
    
    protected $_tablename_searchresult = 'search_results';
    protected $_session_id = NULL;
    
    //protected $available_channel_search = array('music','movie','book','apps','radio','tv','wow','games');
    protected $available_channel_search = array('music','movie','book','apps','radio','wow','games');
    
    function __construct($log_enabled=TRUE) {
        parent::__construct($log_enabled);
        $this->_session_id = $this->input->post('session_id');
        if (!$this->_session_id){
            $err = array(
                'status'            =>  'Failed',
                'retCode'           =>  'E0040',
                'retCodeMessage'    =>  'Parameter SESSION_ID is not defined'
            );
            $this->send_error($err);
        }
        //if (!$this->_session_id) $this->_session_id = '10101';
    }
    
    function all($keyword = NULL){
        $this->return['success'] = TRUE;
        $this->return['retCode'] = 'E0000';
        $this->return['retCodeMessage'] = $this->ERR_CODE['E0000'];
        
        if (!$keyword)
            $keyword = $this->input->post('keyword');
        
        $this->return['keyword'] = urldecode($keyword);
        
        $this->return['found'] = $this->createIntegratedSearch(urldecode($keyword));
        
        $this->_send_output();
    }
    
    function by_channel($channel_name='music', $keyword='thinks'){
        $this->return['success'] = TRUE;
        $this->return['retCode'] = 'E0000';
        $this->return['retCodeMessage'] = $this->ERR_CODE['E0000'];
        
        if (!$keyword)
            $keyword = $this->input->post('keyword');
        $this->return['keyword'] = urldecode($keyword);
        
        $search_result = array();
        
        if (in_array($channel_name, $this->available_channel_search)){
            $method = $channel_name.'_search';
            $search_result = $this->$method(urldecode($keyword));
        }
        
        $this->return['search_result'] = $search_result;
        $this->return['found'] = count($this->return['search_result']);
        $this->_send_output();
    }
    
    function createIntegratedSearch($keyword, $save=TRUE, $return_data = FALSE){
        $search_result = array();
        //start looping all searchable table
        
        /**
         * GENERAL STRATEGY: 
         * Collect all match keyword in all searchable table
         * Each result embed channel name, remap field to be used as general scheme for displaying result data
         * All searching functions are protected, we want only internal allow to access these functions
         * 
         * TODO Custom search channel target
         * 
         * 
         * For now, start from channel music
         * 
         * In channel music, we will search focus in album and artist
         * The result target will be the album.
         * 
         * Strategy: 
         * 1. Search keyword match in album , put in array
         * 2. Search keyword match in artist, put in array, mapping to album by artist
         * 3. Join both result array
         */
        
        //only search from available channel search
        foreach($this->available_channel_search as $channel){
            $method = $channel.'_search';
            $channel_result = $this->$method(urldecode($keyword));
            
            if ($channel_result&&count($channel_result))
                $search_result = array_merge($search_result, $channel_result);
        }
        
        /*
         * update table search result by deleting old search result where same session id
         * then insert batch search result for this session
         */
        
        
        $this->db->where('session_id', $this->_session_id);
        $this->db->delete($this->_tablename_searchresult);
        
        if ($save)
        {
            if (count($search_result)){
                $this->db->insert_batch($this->_tablename_searchresult, $search_result);
            }
        }
        if ($return_data)
            return $search_result;
        else
            return count($search_result);
    }
    
    /**************** MUSIC CHANNEL SEARCH FUNCTIONS **************************/
    protected function music_search($keyword){
        $search_result = array();
        
        $album_search = $this->music_search_album($keyword);
        
        if ($album_search&&count($album_search))
            $search_result = array_merge($search_result, $album_search);
        
        $artist_search = $this->music_search_artist($keyword);
        if ($artist_search&&count($artist_search))
            $search_result = array_merge($search_result, $artist_search);
        
        return $search_result;
    }
    
    protected function music_search_album($keyword){
        $channel_name = 'music';
        $model_name = 'album';
        $this->load->model($channel_name.'/'.$model_name);
        
        $search_result = array();
                
        $search_condition = array(
            'field'         =>  'albumName',
            'value'         =>  $keyword,
            'position'      =>  'both'
        );
        $fields = 'id, albumId, albumName, albumLImgPath';
        $founds = $this->$model_name->get_like($search_condition, $fields, 0, 100);
        
        if ($founds){
            //mapping resulted fields to general search iteration
            foreach ($founds as $item){
                $item = array(
                    'session_id'=>  $this->_session_id,
                    'channel'   =>  $channel_name,
                    'path'      =>  'detail/album',
                    'id'        =>  $item->albumId,
                    'name'      =>  $item->albumName,
                    'description'=> $item->albumName,
                    'image'     =>  $item->albumLImgPath ? 'http://melon.co.id/image.img?fileuid='.$item->albumLImgPath:''
                );
                
                $search_result[] = $item;
            }
        }
        
        return $search_result;
    }
    
    protected function music_search_artist($keyword){
        $channel_name = 'music';
        $table_name = 'music_artists';
        
        
        $search_result = array();
                
        $search_condition = array(
            array(
                'field'         =>  'artistName',
                'value'         =>  $keyword,
                'position'      =>  'both'
            )
        );
        $fields = 'artistId ,artistName';
        
        //build query
        $this->db->select($fields)->from($table_name);
        $i = 0;
        foreach($search_condition as $cond){
            if ($i==0)
                $this->db->like($cond['field'],$cond['value'],$cond['position']);
            else
                $this->db->or_like($cond['field'],$cond['value'],$cond['position']);
            $i++;
        }
        
        $founds = $this->db->get()->result();
        
        if ($founds){
            //Since our target out is album,
            //we need to research albums where mainArtistId is artistId
            $artistIdFound = array();
            foreach ($founds as $item){
                $artistIdFound [] = $item->artistId;
            }
            //now search album
            $this->load->model($channel_name.'/album');
            $albums = $this->album->get_wherein_offset('id,albumId, albumName, albumLImgPath', implode(',', $artistIdFound));
            if ($albums){
                //mapping resulted fields to general search iteration
                foreach ($albums as $item){
                    $item = array(
                        'session_id'=>  $this->_session_id,
                        'channel'   =>  $channel_name,
                        'path'      =>  'detail/album',
                        'id'        =>  $item->albumId,
                        'name'      =>  $item->albumName,
                        'description'=> $item->albumName,
                        'image'     =>  $item->albumLImgPath ? 'http://melon.co.id/image.img?fileuid='.$item->albumLImgPath:''
                    );

                    $search_result[] = $item;
                }
            }
        }
        
        return $search_result;
    }
    
    /**************** MOVIE CHANNEL SEARCH FUNCTION ***************************/
    protected function movie_search($keyword){
        $channel_name = 'movie';
        $table_name = 'movie_items';
        
        $search_result = array();
        
        $search_condition = array(
            array(
                'field'         =>  'item_name',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'item_description',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'publisher_name',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'synopsis',
                'value'         =>  $keyword,
                'position'      =>  'both'
            )
        );
        $fields = 'id, item_name, item_thumbnail, item_description, publisher_name';
        //build query
        $this->db->select($fields)->from($table_name);
        $i = 0;
        foreach($search_condition as $cond){
            if ($i==0)
                $this->db->like($cond['field'],$cond['value'],$cond['position']);
            else
                $this->db->or_like($cond['field'],$cond['value'],$cond['position']);
            $i++;
        }
        
        $founds = $this->db->get()->result();
        
        if ($founds){
            //mapping resulted fields to general search iteration
            foreach ($founds as $item){
                $item = array(
                    'session_id'=>  $this->_session_id,
                    'channel'   =>  $channel_name,
                    'path'      =>  'channel/detail',
                    'id'        =>  $item->id,
                    'name'      =>  $item->item_name,
                    'description'=> $item->item_description,
                    'image'     =>  $item->item_thumbnail ? base_url('userfiles/'.$channel_name.'/thumbnail/'.$item->item_thumbnail):''
                );
                
                $search_result[] = $item;
            }
        }
        return $search_result;
    }
    
    /**************** BOOK CHANNEL SEARCH FUNCTION ***************************/
    protected function book_search($keyword){
        $channel_name = 'book';
        $table_name = 'book_items';
        
        $search_result = array();
                
        $search_condition = array(
            array(
                'field'         =>  'name',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'description',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'sub_publisher_name',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'author',
                'value'         =>  $keyword,
                'position'      =>  'both'
            )
        );
        $fields = 'id, content_id_token, name, description, sub_publisher_name, thumbnail_url';
        //build query
        $this->db->select($fields)->from($table_name);
        $i = 0;
        foreach($search_condition as $cond){
            if ($i==0)
                $this->db->like($cond['field'],$cond['value'],$cond['position']);
            else
                $this->db->or_like($cond['field'],$cond['value'],$cond['position']);
            $i++;
        }
        $founds = $this->db->get()->result();
        
        if ($founds){
            //mapping resulted fields to general search iteration
            foreach ($founds as $item){
                $item = array(
                    'session_id'=>  $this->_session_id,
                    'channel'   =>  $channel_name,
                    'path'      =>  'detail/book',
                    'id'        =>  $item->content_id_token,
                    'name'      =>  $item->name,
                    'description'=> $item->description,
                    'image'     =>  $item->thumbnail_url
                );
                
                $search_result[] = $item;
            }
        }
        return $search_result;
    }
    
    /**************** APPS CHANNEL SEARCH FUNCTION ***************************/
    protected function apps_search($keyword){
        $channel_name = 'apps';
        $table_name = 'apps_items';
        
        $search_result = array();
                
        $search_condition = array(
            array(
                'field'         =>  'package_name',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'developer_or_publisher',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'description',
                'value'         =>  $keyword,
                'position'      =>  'both'
            )
        );
        $fields = 'id, package_id, package_name, description, icon_url';
        //build query
        $this->db->select($fields)->from($table_name);
        $i = 0;
        foreach($search_condition as $cond){
            if ($i==0)
                $this->db->like($cond['field'],$cond['value'],$cond['position']);
            else
                $this->db->or_like($cond['field'],$cond['value'],$cond['position']);
            $i++;
        }
        $founds = $this->db->get()->result();
        
        if ($founds){
            //mapping resulted fields to general search iteration
            foreach ($founds as $item){
                $item = array(
                    'session_id'=>  $this->_session_id,
                    'channel'   =>  $channel_name,
                    'path'      =>  'detail/apps',
                    'id'        =>  $item->package_id,
                    'name'      =>  $item->package_name,
                    'description'=> $item->description,
                    'image'     =>  $item->icon_url
                );
                
                $search_result[] = $item;
            }
        }
        return $search_result;
    }
    
    /**************** RADIO CHANNEL SEARCH FUNCTION ***************************/
    protected function radio_search($keyword){
        $channel_name = 'radio';
        $table_name = 'radio_items';
        
        $search_result = array();
                
        $search_condition = array(
            array(
                'field'         =>  'radio_name',
                'value'         =>  $keyword,
                'position'      =>  'both'
            ),
            array(
                'field'         =>  'radio_city',
                'value'         =>  $keyword,
                'position'      =>  'both'
            )
        );
        $fields = 'id, radio_name, radio_city, radio_province, radio_image';
        $order_by = 'radio_name';
        //build query
        $this->db->select($fields)->from($table_name);
        $i = 0;
        foreach($search_condition as $cond){
            if ($i==0)
                $this->db->like($cond['field'],$cond['value'],$cond['position']);
            else
                $this->db->or_like($cond['field'],$cond['value'],$cond['position']);
            $i++;
        }
        $this->db->order_by($order_by);
        $founds = $this->db->get()->result();
        
        if ($founds){
            //mapping resulted fields to general search iteration
            foreach ($founds as $item){
                $item = array(
                    'session_id'=>  $this->_session_id,
                    'channel'   =>  $channel_name,
                    'path'      =>  'detail/apps',
                    'id'        =>  $item->package_id,
                    'name'      =>  $item->package_name,
                    'description'=> $item->description,
                    'image'     =>  $item->icon_url
                );
                $search_result[] = $item;
            }
        }
        
        return $search_result;
    }
}