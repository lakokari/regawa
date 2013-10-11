<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of channel_m
 *
 * @author master
 */
class Channel_m extends MY_Model {
    
    public $feature_image_url = '';
    
    private $channel_cover_w = 203;
    private $channel_cover_h = 188;
        
    protected $_table_name = 'channels';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'sort';
    
    //channel helper table
    private $tbl_category = 'channel_categories';
    private $tbl_items = 'channel_items';
    private $tbl_feature_images = 'channel_feature_images';
    
    private $sync_channel_items_num = 1000; //number of items to be syncronized with api
    
    public $rules = array(
        'name' => array(
            'field' => 'name', 
            'label' => 'Channel name', 
            'rules' => 'trim|required|callback_unique_channel_name|xss_clean'
        ), 
        'title' => array(
            'field' => 'title', 
            'label' => 'Channel title', 
            'rules' => 'trim|required|xss_clean'
        ), 
        'description' => array(
            'field' => 'description', 
            'label' => 'Channel desription', 
            'rules' => 'trim|max_length[254]|xss_clean'
        ), 
        'hasFeatured' => array(
            'field' => 'hasFeatured', 
            'label' => 'Featured', 
            'rules' => 'xss_clean'
        )
    );
    
    public $rules_feature_image = array(
        'channel_id' => array(
            'field' => 'channel_id', 
            'label' => 'Channel Id', 
            'rules' => 'required'
        ),
        'item_id' => array(
            'field' => 'item_id', 
            'label' => 'Item Id', 
            'rules' => 'required'
        ),
        'cover' => array(
            'field' => 'cover', 
            'label' => 'Cover image', 
            'rules' => 'xss_clean'
        )
    );
    
    function __construct() {
        parent::__construct();
        $this->feature_image_url = 'images/feature_list/';
    }
    
    public function get_by_name($channel_name, $single=FALSE){
        return parent::get_by(array('name'=>$channel_name),$single);
    }
    
    public function get_new(){
        $channel = new stdClass();
        
        $channel->id = 0;
        $channel->name = '';
        $channel->title = '';
        $channel->description = '';
        $channel->sort = 0;
        $channel->showed = 1;
        $channel->hasFeatured = 'y';
        $channel->cover = '';
        
        return $channel;
    }
    
    public function get_channel_categories($channel_id, $include_parent=FALSE){
        if (!$include_parent){
            $where = array(
                'channel_id' =>  $channel_id,
                'category_parent !=' => 0
            );
        }else{
            $where = array('channel_id' => $channel_id);
        }
        
        return $this->db->where($where)->get($this->tbl_category)->result();
    }
    
    public function get_channel_categories_parent($channel_id){
        $where = array(
            'channel_id'    =>  $channel_id,
            'category_parent'   =>  0
        );
        
        return $this->db->where($where)->get($this->tbl_category)->result();
    }
    
    public function get_channel_categories_by_parent($channel_id, $parent_id){
        $where = array(
            'channel_id'    =>  $channel_id,
            'category_parent'   =>  $parent_id
        );
        
        return $this->db->where($where)->get($this->tbl_category)->result();
    }    
    
    public function get_channel_items($channel_id, $category_id, $offset=0, $limit=30){
        $this->db->select('*')->from($this->tbl_items);
        $this->db->join($this->tbl_category, $this->tbl_category.'.category_id='.$this->tbl_items.'.category_id','left');
        $this->db->where(array($this->tbl_items.'.channel_id'=>$channel_id, $this->tbl_items.'.category_id'=>$category_id));
        $this->db->offset($offset*$limit)->limit($limit);
        
        //need to combined with cover image
        $qs = $this->db->get()->result();
        
        $result = array();
        
        if ($qs){
            foreach($qs as $item){
                $row = $this->db->where(array(
                    'channel_id'    =>  $channel_id,
                    'category_id'   =>  $category_id,
                    'item_id'       =>  $item->item_id
                ))->get($this->tbl_feature_images)->row();
                
                !$row || $item->cover = $row->cover;
                
                $result [] = $item;
            }
        }
        
        return $result;
    }
    
    public function get_feature_item($channel_id, $item_id){
        $row = $this->db->where(array(
                'channel_id'=>  $channel_id,
                'item_id'   =>  $item_id
        ))->get($this->tbl_items)->row();
        
        $qs = $this->db->select('cover')->where(array(
                'channel_id'=>  $channel_id,
                'item_id'   =>  $item_id
        ))->get($this->tbl_feature_images)->row();
        
        if ($qs)
            $row->cover = $qs->cover;
        else
            $row->cover = '';
        
        return $row;
    }
    
    public function get_feature_images($channel_id, $offset=0, $limit=5){
        if (!is_int($channel_id)){
            $channel = $this->get_by(array('name'=>$channel_id), TRUE);
            $channel_id = $channel->id;
        }
            
        $this->db->where('channel_id', $channel_id)->offset($offset)->limit($limit);
        return $this->db->get($this->tbl_feature_images)->result();
    }
    
    public function get_count_items($channel_id, $category_id=NULL){
        $this->db->select('COUNT(*) AS total')->from($this->tbl_items);
        if ($category_id){
            $where = array('channel_id'=>$channel_id, 'category_id'=>$category_id);
        }else{
            $where = array('channel_id'=>$channel_id);
        }
        return $this->db->where($where)->get()->row()->total;
    }
    
    public function channel_label_from_list(&$channels, $channel_id, $label_id='title'){
        foreach($channels as $channel){
            if ($channel->id==$channel_id){
                return $channel->$label_id;
            }
        }
    }
    
    public function channel_items_sync($channel_id){
        //get channel name from database
        $channel_name = $this->db->select('name')->where('id',$channel_id)->get($this->_table_name)->row()->name;
        
        switch($channel_name){
            case 'music':
                $this->syncronize_music($channel_id);
                break;
            case 'movie':
                $this->syncronize_movie($channel_id);
                break;
            case 'tv':
                $this->syncronize_tv($channel_id);
                break;
            case 'radio':
                $this->syncronize_radio($channel_id);
                break;
            case 'games':
                $this->syncronize_games($channel_id);
                break;
            case 'book':
                $this->syncronize_book($channel_id);
                break;
            case 'apps':
                $this->syncronize_apps($channel_id);
                break;
            case 'wow':
                $this->syncronize_wow($channel_id);
                break;
            case 'usky':
                $this->syncronize_usky($channel_id);
                break;
        }
    }
    
    public function syncronize_music($channel_id){
        //load Melon Lib
        $this->load->library('melon');
        
        //first sync categories / genre
        $categories = $this->melon->categories();
        
        //next only executes if categories loaded successfully
        if ($categories)
        {                
            //remove all categories with parent 0 and channel id $channel_id
            $this->db->where(array(
                'channel_id'    =>  $channel_id,
                'category_parent'   => 0
            )
            )->delete($this->tbl_category);

            //insert category with new data
            foreach($categories as $category){
                $new_data = array(
                    'channel_id'        =>  $channel_id,
                    'category_id'       =>  $category->genreId,
                    'category_name'     =>  $category->genreName,
                    'category_parent'   =>  0
                );

                $this->db->insert($this->tbl_category, $new_data);                
                
                //try to load all genres with parent id
                $genres = $this->melon->genres_from_category($category->genreId);
                if ($genres)
                {
                    //delete old categories / genre with parent id this category id
                    $this->db->where(array('channel_id'=>$channel_id,'category_parent'=>$category->genreId));
                    $this->db->delete($this->tbl_category);
                    
                    //insert new data genres
                    foreach($genres as $genre){
                        $this->db->insert(
                            $this->tbl_category,
                            array(
                                'channel_id'        =>  $channel_id,
                                'category_id'       =>  $genre->genreId,
                                'category_name'     =>  $genre->genreName,
                                'category_parent'   =>  $category->genreId
                            )    
                        );
                        
                        //try to sync only 500 albums by genre
                        $albums = $this->melon->albums_by_genre($genre->genreId, $this->sync_channel_items_num);
                        
                        if ($albums && count($albums->dataList)){
                            
                            //if loaded clear database albums / items
                            $this->db->where(
                                array(
                                    'channel_id'    =>  $channel_id,
                                    'category_id'   =>  $genre->genreId
                                )
                            )->delete($this->tbl_items);
                            
                            //insert new data into database channel items
                            foreach($albums->dataList as $album){
                                $this->db->insert(
                                    $this->tbl_items,
                                    array(
                                        'channel_id'    =>  $channel_id,
                                        'category_id'   =>  $genre->genreId,
                                        'item_id'       =>  $album->albumId,
                                        'name'          =>  $album->albumName
                                    )
                                );
                            }
                        }
                        
                    }
                }
            }
        }
        //update categories and items count in table channel
        $this->db->select('COUNT(*) AS categories_count')->where('channel_id',$channel_id);
        $categories_count = $this->db->get($this->tbl_category)->row()->categories_count;
        
        $this->db->select('COUNT(*) AS items_count')->where('channel_id',$channel_id);
        $items_count = $this->db->get($this->tbl_items)->row()->items_count;
        
        $this->db->where('id', $channel_id)->update($this->_table_name, 
                array(
                    'categories_count'=> $categories_count,
                    'items_count'     => $items_count,
                    'last_api_update' => date('Y-m-d H:i:s')
                )
        );        
    }
    
    public function syncronize_movie($channel_id){}
    public function syncronize_tv($channel_id){}
    public function syncronize_radio($channel_id){}
    public function syncronize_games($channel_id){}
    public function syncronize_book($channel_id){}
    public function syncronize_apps($channel_id){}
    public function syncronize_wow($channel_id){}
    public function syncronize_usky($channel_id){}
    
    public function upload_channel_cover($field_name, &$message, $autoresize=TRUE){
        $config['upload_path'] = SITE_PATH. config_item('channel_img_url').'thumb/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 500;
        $config['max_width']  = 1024;
        $config['max_height']  = 768;
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload($field_name)){
            $message = $this->upload->display_errors();
            return FALSE;
        }
        else{
            $data = $this->upload->data();
            
            if ($autoresize){
                if ($data['image_width']>$this->channel_cover_w || $data['image_height']>$this->channel_cover_h){
                    $this->image_resize_cover($data['full_path'], $message, FALSE);
                }
            }
            
            return $data;
        }
    }
    
    public function image_resize_cover($file_full_path, &$message, $new_image=FALSE){
        $config['image_library'] = 'gd2';
        $config['source_image'] = $file_full_path;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width']     = $this->channel_cover_w;
        $config['height']   = $this->channel_cover_h;
        if ($new_image){
            $config['new_image'] = $new_image;
        }
        
        $this->load->library('image_lib', $config); 

        if (!$this->image_lib->resize()){
            $message = $this->image_lib->display_errors();
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function save_feature_item($data, $channel_name='music'){
        //is exists
        $this->db->select('id,cover');
        $this->db->where(array('channel_id'=>$data['channel_id'], 'item_id'=>$data['item_id']));
        $qs = $this->db->get($this->tbl_feature_images)->row();
        if ($qs){
            //check wheter image replaced by new, if yes, deleted old one
            if (isset($data['cover'])){
                if ($data['cover']&&$data['cover']!=$qs->cover){
                    if (file_exists(SITE_PATH.  $this->feature_image_url . $channel_name .$qs->cover))
                        unlink(SITE_PATH.  config_item('channel_img_url').'/feature/'.$qs->cover);
                }
            }
                
            return $this->db->where('id',$qs->id)->update($this->tbl_feature_images, $data);
        }
        else{
            return $this->db->insert($this->tbl_feature_images, $data);
        }
    }
    
    public function upload_image_feature($field_name, &$message, $channel_name='music'){
        $config['upload_path'] = SITE_PATH. $this->feature_image_url . $channel_name.'/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size'] = 500;
        $config['max_width']  = 1024;
        $config['max_height']  = 768;
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        
        $upload = $this->my_upload($field_name, $config, $message);
        if (!$upload){
            return FALSE;
        }
        
        //resize
        $resize = array(
            'image_library' => 'gd2',
            'source_image'  =>  $upload['full_path'],
            'create_thumb'  =>  FALSE,
            'maintain_ratio'=>  FALSE,
            'width'         =>  787,
            'height'        =>  237,
            'new_image'     =>  FALSE
        );
        if ($upload)
        $this->image_manipulation($resize, $message, 'resize');
        
        return $upload;
    }
    
    //override parent delete function to remove image cover used
    public function delete_channel($id){
        //get cover image before deleted
        $cover = $this->db->select('cover')->where('id',$id)->get($this->_table_name)->row()->cover;
        
        //execute parent delete function
        $is_deleted = parent::delete($id);
        
        //if record deleted, delete cover image if exists
        if ($is_deleted){
            if ($cover && file_exists(SITE_PATH.  config_item('image_url').'/thumbs/'.$cover)){
                unlink(SITE_PATH.  config_item('image_url').'/thumbs/'.$cover);
            }
        }
        
        return $is_deleted;
    }
    
}

?>
