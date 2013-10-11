<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Games
 *
 * @author master
 */
class Detail extends U_Controller {
    
    protected $_channel_name = 'book';
    
    function __construct() {
        parent::__construct();
    }
    public function book($bookId) {
        
   
        //load model album
        $this->load->model($this->_channel_name.'/items');
        $this->load->model($this->_channel_name.'/book_preview');
        
        $book_item = $this->items->get_by(array('content_id_token'=>$bookId), TRUE);
        if ($book_item){
            $book_item->thumbnail_url = config_item('api_sync') .'book/'. $book_item->thumbnail_url;
            
            //try to get big image from another table
            $book_preview = $this->book_preview->get_offset('preview_full_url',array('content_id_token'=>$bookId),0,1,'row');
            if ($book_preview){
                $book_item->thumbnail_url = $book_preview->preview_full_url;
            }
        }
        $this->data['item'] = $book_item;
        $this->data['category'] = $book_item->category_name;
        //$this->data['category_id'] = $book_item->category_id;
        
        //load category model
        $this->load->model('book/category');
        $this->data['categories'] = $this->category->get();

        $this->data['subview'] = 'channel/'.$this->_channel_name.'/detail_book';
        $this->load->view('_layout_main', $this->data);
    }

    function comment(){
        if($this->session->userdata('email')=="")
        {
            $email = $this->session->userdata('username');
        }else
        {
            $email = $this->session->userdata('email');
        }
        $id=$this->input->post('id');
        $comment=$this->input->post('comment');
        $rating=$this->input->post('rating');
        $data=array('channel_name'=>'book',
                    'item_id'=>$id,
                    'comment'=>$comment,
                    'rating'=>$rating,
    				'u_name'=>$this->session->userdata('username'),
    				'username'=>$this->session->userdata('username'),
                    'email'=>$email,
                    'datetime'=>date('Y-m-d H:i:s'));
        $this->load->model('comment_rating_m');
        header('Content-Type: application/json');
        if($this->comment_rating_m->save($data)) $data['status']=1;
         echo json_encode($data);
    }
    function commentview(){
        $this->load->helper('cms');
        $id=$this->input->post('id');
        $page=$this->input->post('page');
        $limit=$this->input->post('limit');
        $this->load->model(array('comment_rating_m'));
        $offset = $page-1;
        $start = $offset * $limit;
        $result = $this->comment_rating_m->get_offset('*', array('channel_name'=>'book','item_id'=>$id), $start, $limit);
        $totalSize = $this->comment_rating_m->get_count(array('channel_name'=>'book','item_id'=>$id));
        
        $items = array();
        if ($result){
            foreach ($result as $item) {
                $item->comment = nl2br($item->comment);

                $items [] = $item;
            }
        }
        $data['items'] = $items; 
        $data['found'] = count($result);
        $totalPages = ceil($totalSize/$limit);
        //create js paging
        $jsClick = 'javascript:loadcomment("'.$id.'",$);';
        $data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        echo json_encode($data);
    }

}

?>
