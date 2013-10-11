<?php

/**
 * Description of music
 *
 * @author master
 */
class News extends U_CMS_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('news_m');
        $this->data['active_menu'] = 'news';
    }
    
    public function index($channel, $page=0, $limit=10){
        //load model music category
        
        
        $this->data['page_title'] = ucwords($channel).' News';
        
        //start creating data list
        $offset = $page * $limit;
        $total_records = $this->news_m->get_like_count(array('field'=>'channel_name','value'=>$channel));
        $total_pages = ceil($total_records / $limit);
        
        $this->data['page_offset'] = $offset;
        $this->data['page_url'] = site_url('cms/channel/index/'.$channel.'/%i');
        $this->data['page_total'] =$total_pages;
        
        $this->data['data'] = $this->news_m->get_offset('*',array('channel_name'=>$channel),$offset,$limit);
        
        
        $this->data['subview'] = 'cms/channels/newslist';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function edit($channel=null, $news_id=NULL){
        
        // Set form
        $rules = $this->news_m->rules;
        $this->form_validation->set_rules($rules);
        
        //Process Form
        if ($this->form_validation->run() == TRUE) {
            // We can login and redirect
            $data_post = $this->news_m->array_from_post(array('item_id','news_title','channel_name','news_datetime','news_text','news_by'));
            
            if ($this->news_m->save($data_post, $news_id) == TRUE) {
                redirect('cms/news/index/'.$channel);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data channel');
            }
		
        }
        
        $this->data['page_title'] = ucwords($channel).' News Edit';
        
        if ($news_id){
            $this->data['channel'] = $this->news_m->get($news_id);
			$items=$this->news_m->getitems($channel);
			for($i=0;$i<count($items['data']);$i++){
				$this->data['items'][$items['data'][$i]['id']]=$items['data'][$i][$items['field']];
			}
		}else{
            $this->data['channel'] = $this->news_m->get_new();
			$items=$this->news_m->getitems($channel);
			for($i=0;$i<count($items['data']);$i++){
				$this->data['items'][$items['data'][$i]['id']]=$items['data'][$i][$items['field']];
			}
		}
        
        //Load view
        $this->data['active_menu'] = $channel;
        $this->data['subview'] = 'cms/channels/news_edit';
        $this->load->view('cms/_layout_main', $this->data);
    }
    
    public function delete($news_id=NULL, $channel=null){
        if ($news_id)
            $this->news_m->delete($news_id);
            
        redirect('cms/news/index/'.$channel);
    }
}

?>
