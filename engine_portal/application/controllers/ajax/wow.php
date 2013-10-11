<?php

/**
 * Description of Wow for Ajax Call
 *
 * @author agung
 * @email agung
 */
class Wow extends Ajax {
            
    protected $_channel_name = 'wow';
    
    function __construct() {
        parent::__construct();
        
        $this->_result['found'] = 0;
        $this->load->model('user_m');   
    }

	function satu(){
		$this->_result['success'] = TRUE;
		$this->_result['message'] = 'okeh';	
	}
    //function to save wow form wizard
    function saveWowForm(){
	$event_id_need_approval = array(2); //digital idol need approval
        //sleep(10);
        $this->_result['success'] = FALSE;
        
        if ($this->user_m->is_loggedin()){
            $event_id = $this->input->post('channel', TRUE);

            //get all event field from database by event_id
            $this->load->model($this->_channel_name.'/event_field');
            $where = array('event_id'=>$event_id);
            $all_event_field = $this->event_field->get_select_where('*', $where);

            //pindah dari array input
            //$custom_field = $this->input->post('custom_field');

            //get submit data
            $judul = trim($this->input->post('judul', TRUE));
            $kategori = $this->input->post('kategori', TRUE);
            //$tags = trim($this->input->post('tags', TRUE));
            $team = $this->input->post('team', TRUE);
            $deskripsi = trim($this->input->post('deskripsi', TRUE));
            $genre = trim($this->input->post('genre', TRUE));
            $userid = $this->session->userdata('userid');
            $data_to_save = array(
                'created_by'        =>  $userid,
                'event_id'          =>  $event_id,
                'item_name'         =>  $judul,
                'item_type'         =>  'movie',
                'item_description'  =>  $deskripsi,
		'author'            =>	$this->session->userdata('username'),
                'genre'             =>  $genre,
                'team'              =>  $team,
                'tag_line'          =>  'Uzone Video',
                'created_date'      =>  date('Y-m-d'),
                'upload_date'       =>  date('Y-m-d H:i:s')
            );
            if (in_array($event_id, $event_id_need_approval)){
                $data_to_save['approved'] = 0;
            }else{
                $data_to_save['approved'] = 1; //auto approve
            }
            
            $continue = TRUE;
            
            if (isset($_FILES['video'])){
                $upload_video = $this->_upload_video('video', $event_id);
                if ($upload_video['success']){
                    $data_to_save['item_url'] = $upload_video['file_name'];
                    $thumbnail_file = substr($upload_video['file_name'], 0, strpos($upload_video['file_name'], '.'));
                    $data_to_save['item_thumbnail'] = $thumbnail_file . '.jpg';
                }else{
                    $continue = FALSE;
                    $this->_result['message'] = $upload_video['message'];
                }
            }else{
                $continue = FALSE;
                $this->_result['message'] = 'Anda belum memilih file video untuk upload';
            }
            
            
            if ($continue){
                $this->load->model('wow/items');
                $this->items->save($data_to_save);

                $last_item_id = $this->items->get_inserted_id();
                
                /*************************** CREATE NEW JOB FOR TRANSCODE **********************************/
                //INSERT video INTO uz_transcode_jobs
                $filetransname= explode(".",$upload_video['file_name']);
                $data_transcode = array(
                    'hash'              =>  sha1($upload_video['file_name']),
                    'inserted_time'     =>  time(),
                    'source_path'       =>  $upload_video['file_name'],
                    'target_name'       =>  $userid.'_'.current($filetransname),
                    'target_type'       =>  'video',
                    'status'            =>  0,
                    'transcode_time'    =>  0,
                    'wow_item_id'       =>  $last_item_id
		);
                //INSERT image INTO uz_transcode_jobs
                $data_transcode_image = array(
                    'hash'              =>  sha1($upload_video['file_name']),
                    'inserted_time'     =>  time(),
                    'source_path'       =>  $upload_video['file_name'],
                    'target_name'       =>  $userid.'_'.current($filetransname),
                    'target_type'       =>  'image',
                    'status'            =>  0,
                    'transcode_time'    =>  0,
                    'wow_item_id'       =>  $last_item_id
                );
				
                $this->load->model('wow/transcodejob');				
                $this->transcodejob->save($data_transcode);
                $this->transcodejob->save($data_transcode_image);
                
                /*********************** END TRANSCODE JOB *********************************/
				
                //tambahan save custom field
                $this->load->model($this->_channel_name.'/items_field');
                $i = 0;
                foreach ($all_event_field as $event_field):
                    //$custom_field[$i];
                    $data_field_value = array(
                        'fieldvalue'        => $this->input->post('custom_field'.$i),
                        'id_event_field'    => $event_field->id_event_field,
                        'id_items'          => $last_item_id
                    );
                    $i++;
                    $this->items_field->save($data_field_value);
                endforeach;
                //end of save custom field

                $this->_result['success'] = TRUE;
                $this->_result['message'] = 'Data berhasil disimpan';
            }
            
        }else{
            $this->_result['message'] = 'Anda harus login untuk bisa upload';
        }
        
    }
    
    function cancelUpload(){
        $key = ini_get("session.upload_progress.prefix") . 'wow';
        
        $_SESSION[$key]["cancel_upload"] = TRUE;
        
        $this->session->set_userdata('cancel_upload', TRUE);
    }
    
    protected function _upload_video($field_name, $event_id){
        $this->load->model('wow/wow_event_m');
        $event = $this->wow_event_m->get($event_id, TRUE);
        
        //default movie type
        $allowed_type = 'mp4,ogv,webm';
        if ($event && $event->allowed_movie_type!=''){
            $allowed_type = strtolower($event->allowed_movie_type);
        }
        
        //default max_size
        $max_size = 1024 * 1024 * 1; //Max in MB
        if ($event && $event->max_movie_size>0){
            $max_size = $max_size * $event->max_movie_size;
        }
        
        $target_folder = '/data/userfiles/wow/source';
        //$target_folder = '/data/tmp';
        
        $result = array(
            'success'   =>  FALSE
        );
        $fileupload = $_FILES[$field_name];
        
        //check for any errors
        if ($fileupload['error'] != UPLOAD_ERR_OK){
            $result['message'] = 'Upload video error';
            return $result;
        }
        
        $result['original_name'] = $fileupload['name'];
        $result['file_extension'] = strtolower(end(explode('.', $result['original_name'])));
        
        //check for type
        if (!in_array($result['file_extension'], explode(',',$allowed_type))){
            $result['message'] = 'Tipe file video tidak dibolehkan. Hanya tipe ['.$allowed_type.'] yang diijinkan';
            return $result;
        }
        
        //check for size
        $result['file_size'] = $fileupload['size'];
        if ($result['file_size'] > $max_size){
            $result['message'] = 'Ukuran file video melebihi dari batas yang ditentukan (max: '.ceil($max_size/1024/1024).'MB)';
            return $result;
        }
        
        //SET Folder and filename
        $result['target_folder'] = $target_folder;
        $result['file_name'] = 'WOW_MOVIE_'. $this->session->userdata('userid').time().'.'.$result['file_extension'];
        $result['file_name_full'] = $result['target_folder'] .'/' . $result['file_name'];
        
        //cek if folder exists, if not create
        if (!file_exists( $target_folder)){
            @mkdir( $target_folder, 0777, TRUE);
        }
        
        //try to move uploaded file
        if (!@move_uploaded_file($fileupload['tmp_name'], $result['file_name_full'])){
            $result['message'] = 'Gagal menyimpan file upload video';
            return $result;
        }
        $result['success'] = TRUE;
        $result['message'] = 'File berhasil diupload';
                    
        return $result;
    }
    
    protected function _upload_thumbnail($field_name){
        $allowed_type = array('jpg');
        $max_size = 1024 * 1024 * 5; //Max in MB      
		//$static_path = '/home/uzone/public_html/img/userfiles/';
        $target_folder = '/data/userfiles/wow/thumbnail';
        
        $thumb_width = 300;
        $thumb_height = 250;
        
        
        $result = array(
            'success'   =>  FALSE
        );
        $fileupload = $_FILES[$field_name];
        
        //check for any errors
        if ($fileupload['error'] != UPLOAD_ERR_OK){
            $result['message'] = 'Upload error';
            return $result;
        }
        
        $result['original_name'] = $fileupload['name'];
        $result['file_extension'] = strtolower(end(explode('.', $result['original_name'])));
        
        //check for type
        if (!in_array($result['file_extension'], $allowed_type)){
            $result['message'] = 'Tipe file thumbnail tidak dibolehkan. Hanya tipe ['.implode(' | ', $allowed_type).'] yang diijinkan';
            return $result;
        }
        
        //check for size
        $result['file_size'] = $fileupload['size'];
        if ($result['file_size'] > $max_size){
            $result['message'] = 'Ukuran file thumbnail melebihi dari batas yang ditentukan (max: '.ceil($max_size/1024/1024).'MB)';
            return $result;
        }
        
        //SET Folder and filename
        $result['target_folder'] = $target_folder;
        $result['file_name'] = 'WOW_MOVIE_'. $this->session->userdata('userid').time().'.'.$result['file_extension'];
        $result['file_name_full'] = $result['target_folder'] . '/'. $result['file_name'];
        
        //cek if folder exists, if not create
        if (!file_exists($target_folder)){
            mkdir($target_folder, 0777, TRUE);
        }
        
        //try to move uploaded file
        if (!move_uploaded_file($fileupload['tmp_name'], $result['file_name_full'])){
            $result['message'] = 'Gagal menyimpan file thumbnail upload';
            return $result;
        }else{
            //do we need resize ?
            $this->_resize_image($result['file_name_full'], $thumb_width, $thumb_height);
        }
        $result['success'] = TRUE;
        $result['message'] = 'File berhasil diupload';
                    
        return $result;
    }
    
    protected function _resize_image($source, $new_width, $new_height){
        $config = array(
            'image_library'         =>  'gd2',
            'source_image'          =>  $source,
            'create_thumb'          =>  FALSE,
            'maintain_ratio'        =>  TRUE,
            'width'                 =>  $new_width,
            'height'                =>  $new_height
        );

        $this->load->library('image_lib', $config);
        return $this->image_lib->resize();
    }
    /********************** end of WOW WIZARD *********************/
    
    /***************** Increase like button ************************/
    function increaseLike(){
        $wow_id = $this->input->post('id', TRUE);
        
        $this->_result['success'] = 0;
        
        if ($this->user_m->is_loggedin()){
            $user_id_like = $this->session->userdata('userid');
            //Load model wow item
            $this->load->model(array('wow/items','wow/like_list'));
            
            //check if this user has already like
            $user_already_like = $this->like_list->get_by(array('user_id'=>$user_id_like,'item_id'=>$wow_id), TRUE);
            
            if (!$user_already_like){
                //usr belum like, lanjut proses
                //insert new user like
                $this->like_list->save(array('user_id'=>$user_id_like, 'item_id'=>$wow_id, 'like_date'=>date('Y-m-d H:i:s')));
                
                
                //update total count like
                $current_like_result = $this->items->get_select_where('item_like_count', array('id'=>$wow_id), TRUE);
                if ($current_like_result)
                    $current_like = $current_like_result->item_like_count + 1;
                else
                    $current_like = 1;
                //save update data
                $this->items->save(array('item_like_count'=>$current_like), $wow_id);
                $this->_result['success'] = 1;
                $this->_result['current_like_count'] = $current_like;
            }
            
        }
    }
    
    function unLike(){
        $wow_id = $this->input->post('id', TRUE);
        
        $this->_result['success'] = 0;
        
        if ($this->user_m->is_loggedin()){
            $user_id_like = $this->session->userdata('userid');
            //Load model wow item
            $this->load->model(array('wow/items','wow/like_list'));
            
            
            //check if this user has already like
            $user_already_like = $this->like_list->get_by(array('user_id'=>$user_id_like,'item_id'=>$wow_id), TRUE);
            
            if ($user_already_like){
                //usr belum like, lanjut proses
                //insert new user like
                $this->like_list->delete($user_already_like->id);
                
                //update total count like
                $current_like_result = $this->items->get_select_where('item_like_count', array('id'=>$wow_id), TRUE);
                if ($current_like_result)
                    $current_like = $current_like_result->item_like_count - 1;
                else
                    $current_like = 0;
                //save update data
                $this->items->save(array('item_like_count'=>$current_like), $wow_id);
                $this->_result['success'] = 1;
                $this->_result['current_like_count'] = $current_like;
            }
            
        }
    }
	
    function increaseViewCount(){
		$wow_id = $this->input->post('id', TRUE);
		
		$this->load->model('wow/items');
		
		//update total count like
		$current_view_count_result = $this->items->get_select_where('view_count', array('id'=>$wow_id), TRUE);
		if ($current_view_count_result)
			$current_count = $current_view_count_result->view_count + 1;
		else
			$current_count = 1;
		
		//save update data
		$this->items->save(array('view_count'=>$current_count), $wow_id);
	}
        
    function loadGaleryItems(){
        $event_id = $this->input->post('event_id', TRUE);
        $which = $this->input->post('which', TRUE); if (!$which) $which = 'all';
        $page = intval($this->input->post('page', TRUE)); if (!$page) $page = 1;
        $limitPerPage = intval($this->input->post('limitPerPage', TRUE)); if (!$limitPerPage) $limitPerPage = 15;
        
        $offset = $page - 1;
        
        //Load wow items record
        $this->load->model('wow/items');
        //We only use model to get table name
        $table_name = $this->items->get_tablename();
        //count how many records which requested
        $totalRecords = 0;
        //set up CI Active record
        $this->db->from($table_name)->where('category_id', $event_id);
        
        //Variable to store the limit of totalRecords to be shown
        $totalLimit = 100;
        
        $order_by = NULL;
        switch($which){
            case 'recent': 
                $order_by = 'upload_date desc';
                
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results(); 
                break;
            
            case 'favorite':
                $order_by = 'item_like_count desc, upload_date desc';
                
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results(); 
                break;
            
            default:
                $order_by = 'upload_date desc';
                $this->db->order_by($order_by);
                $totalRecords = $this->db->count_all_results(); 
                break;
        }
        
        if ($totalRecords>0){
            //set up paging
            $totalPages = ceil($totalRecords / $limitPerPage);        
            $start = $offset * $limitPerPage;

            //Load the items
            $this->db->from($table_name)->where('category_id', $event_id);
            $items_result = $this->db->order_by($order_by)->offset($start)->limit($limitPerPage)->get()->result();
            
            $this->_result['found'] = $totalRecords;
            $this->_result['size'] = count($items_result);
            $this->_result['start'] = $start;
            $this->_result['page'] = $page;
            
            //For like dislike button
            $this->load->model($this->_channel_name.'/like_list');
            $this->_result['can_like_dislike'] = $this->user_m->is_loggedin();
            
            //iterate items to make paging
            $items = array();
            
            foreach($items_result as $item){
                if (strtotime($item->upload_date) > strtotime('2013-08-27')){
                    $wow_base_url = base_url('userfiles/wow').'/';
		}else{
                    $wow_base_url = config_item('userfiles') .'wow/';
		}
                $item->item_url = $wow_base_url  . $item->item_url;
                $item->item_thumbnail = $wow_base_url .'thumbnail/'. $item->item_thumbnail;
            
                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()){
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like                
                    $user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
                    if ($user_liked == 0){
                        $user_can_like = TRUE;
                    }
                }
                $item->user_can_like = $user_can_like;
            
                $items [] = $item;
            }
            
            
            $this->_result['items'] = $items;
            //create js paging
            $jsClick = 'javascript:showAllGallery('.$event_id.',"'.$which.'",$);';
            $this->_result['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }
        
    }
	
    function load_event_thumb(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        //$this->load->model('apps/top');
        $this->load->model($this->_channel_name.'/wow_event_m');
        $this->_result['items'] = $this->wow_event_m->get_offset('*', NULL, $start, $limit);
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function wow_save_comment(){
        $item_id = $this->input->post('item_id');
        $rating = $this->input->post('rating');
        $comment = $this->input->post('comment');
        $user_email = $this->session->userdata('email');
        $user_name = $this->session->userdata('username');
        
        if ($rating>10) 
            $rating = 10;
        else if($rating<0)
            $rating = 0;
        
        //set default return status
        $this->_result['status'] = 0;
        
        if ($item_id){
            //load model
            $this->load->model('comment_rating_m');
            $data_post = array(
                'channel_name'  =>  'wow',
                'item_id'       =>  $item_id,
                'comment'       =>  $comment,
                'rating'        =>  $rating,
                'email'         =>  $user_email,
                'username'      =>  $user_name,
                'datetime'      =>  date('Y-m-d H:i:s'),
                'u_name'        =>  $user_name
            );
            
            if ($this->comment_rating_m->save($data_post)){
                $this->_result['status'] = 1;
            }
            
        }
    }
    
    function get_top_view(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $category_id = $this->input->post('category_id');
        
        $this->load->model('wow/topview');
        $where = array('category_id'=>$category_id, 'approved'=>'1');
        $this->_result['items'] = $this->topview->get_offset('*', $where, $start, $limit);
        
        $this->_result['found'] = count($this->_result['items']);
    }

    function get_top_rating(){
        $offset = $this->input->post('offset'); if (!$offset) $offset = 0;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        $start = $offset * $limit;

        $category_id = $this->input->post('category_id');
        
        $this->load->model('wow/toprating');
        $where = array('category_id'=>$category_id, 'approved'=>'1');
        $this->_result['items'] = $this->toprating->get_offset('*', $where, $start, $limit);
        
        $this->_result['found'] = count($this->_result['items']);
    }
    
    function get_rating_list(){
        $wow_id = $this->input->post('wow_id');
        $page = $this->input->post('page'); if (!$page) $page =1;
        $limit = $this->input->post('limit'); if (!$limit) $limit = 20;
        
        $offset = $page-1;
        $start = $offset * $limit;
        
        //load model comment and rating
        $this->load->model('comment_rating_m');
        
        //get total record for rating in this wow item
        $where = array('channel_name'=>  $this->_channel_name, 'item_id'=>$wow_id);
        
        $totalSize = $this->comment_rating_m->get_count($where);
        $this->_result['found'] = $totalSize;
        
        if ($totalSize){
            $totalPages = ceil($totalSize / $limit);
            $this->_result['totalPages'] = $totalPages;
            
            //load items
            $items = $this->comment_rating_m->get_offset('*', $where, $start, $limit);
            $this->_result['items'] = $items;
            $this->_result['size'] = count($items);
        }
    }
}

/*
 * file location: /engine/application/controllers/ajax/book.php
 */
