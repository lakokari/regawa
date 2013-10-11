<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Channel of Movie
 *
 * @author master
 */
require_once 'WowDefault.php';
class Channel extends WowDefault {

    protected $_channel_name = 'wow';

    function __construct() {
        parent::__construct();

        //load wow type
        $this->load->model($this->_channel_name . '/wow_event_m');
        $this->data['is_loggedin'] = $this->user_m->is_loggedin() ? 'yes' : 'no';
        $this->load->model('wow/wow_event_m');
        $this->data['wizard_events'] = $this->wow_event_m->get();

        //load wow categories
        $this->load->model('wow/category');
        $this->data['categories'] = $this->category->get();
        $this->data['wow_news'] = $this->db->query("select * from uz_channel_news where channel_name = 'wow' and type = 1 and is_active=1 ORDER BY news_datetime DESC LIMIT 0 , 2");
       
    }

    /*     * ************ NO NEED ANY MORE : MARWAN 
      public function wow_upload(){
      $this->load->library('UploadHandler');
      }
     * 
     */

    public function index() {
        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/items_field');
        $this->load->model($this->_channel_name . '/content_static');
        $this->load->model($this->_channel_name . '/category');
        $this->load->model($this->_channel_name . '/like_list');

        $this->load->model($this->_channel_name . '/banner');
		$this->load->model('userclient_m');

        $table_banner = $this->db->dbprefix($this->banner->get_tablename());
        $this->data['sliding_banner'] = $this->db->query("SELECT * FROM " . $table_banner . " WHERE event_id=0 AND location='main_wow' AND CURDATE() BETWEEN start_date AND stop_date ORDER BY id DESC LIMIT 4");

        $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
        $table_user = $this->db->dbprefix($this->user_m->get_tablename());
		$table_userclient = $this->db->dbprefix($this->userclient_m->get_tablename());
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;


        //load preview (bagian bawah) from table uz_wow_category
        $this->data['previews'] = $this->category->get();

        //load tips from table uz_wow_static
        $where = array('id' => 23);
        $tips_main = $this->content_static->get_select_where('*', $where);
        $this->data['tips_main'] = $tips_main;

        //data wizard
        //load event channel
        //$this->data['is_loggedin'] = 'yes';

        if ($this->user_m->is_loggedin()) {
            $userid = $this->session->userdata('userid');
            $this->load->model($this->_channel_name . '/items');
            $mydata_result = $this->items->get_select_where('*', array('created_by' => $userid, 'transcoded' => 1, 'approved' => 1));
            $this->data['found'] = count($mydata_result);
            if ($this->data['found'] > 0) {
                foreach ($mydata_result as $_result) {
                    if (strtotime($_result->upload_date) > strtotime('2013-08-27')) {
                        $wow_base_url = base_url('userfiles/wow') . '/';
                    } else {
                        $wow_base_url = config_item('userfiles') . 'wow/';
                    }
                    $_result->item_url = $wow_base_url . $_result->item_url;
                    $_result->item_thumbnail = $wow_base_url . 'thumbnail/' . $_result->item_thumbnail;

                    $my_results [] = $_result;
                }

                $this->data['items'] = $my_results;
            }
        }



        $event_id = 1;
        $event_id_yp = 1;
        $event_id_di = 2;
        $event_id_ts = 3;
        //limit setting
        $limit = 2;
        //get recent upload/ new release

        $tbl_wow_item = $this->items->get_tablename();

        $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

        $recent_upload_result_yp = $this->db->select('*')->where(array('event_id' => $event_id_yp, 'transcoded' => 1, 'approved' => 1))->order_by('upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $recent_upload_yp = array();
        foreach ($recent_upload_result_yp as $recent_yp) {
            if (strtotime($recent_yp->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $recent_yp->item_url = $wow_base_url . $recent_yp->item_url;
            $recent_yp->item_thumbnail = $wow_base_url . 'thumbnail/' . $recent_yp->item_thumbnail;



            $user_creator = $this->user_m->get($recent_yp->created_by);
            if ($user_creator)
                $recent_yp->created_by_name = $user_creator->name;
            else
                $recent_yp->created_by_name = 'unknown';

            $recent_upload_yp [] = $recent_yp;
        }
        $this->data['recent_upload_yp'] = $recent_upload_yp;


        $recent_upload_result_di = $this->db->select('*')->where(array('event_id' => $event_id_di, 'transcoded' => 1, 'approved' => 1))->order_by('upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $recent_upload_di = array();
        foreach ($recent_upload_result_di as $recent_di) {
            /*
            if (strtotime($recent_di->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $recent_di->item_url = $wow_base_url . $recent_di->item_url;
            $recent_di->item_thumbnail = $wow_base_url . 'thumbnail/' . $recent_di->item_thumbnail;
            */


            $user_creator = $this->user_m->get($recent_di->created_by);
            if ($user_creator)
                $recent_di->created_by_name = $user_creator->name;
            else
                $recent_di->created_by_name = 'unknown';

            $recent_upload_di [] = $recent_di;
        }
        $this->data['recent_upload_di'] = $recent_upload_di;


        $recent_upload_result_ts = $this->db->select('*')->where(array('event_id' => $event_id_ts, 'transcoded' => 1, 'approved' => 1))->order_by('upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $recent_upload_ts = array();
        foreach ($recent_upload_result_ts as $recent_ts) {
            /*
            if (strtotime($recent_ts->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $recent_ts->item_url = $wow_base_url . $recent_ts->item_url;
            $recent_ts->item_thumbnail = $wow_base_url . 'thumbnail/' . $recent_ts->item_thumbnail;
            */


            $user_creator = $this->user_m->get($recent_ts->created_by);
            if ($user_creator)
                $recent_ts->created_by_name = $user_creator->name;
            else
                $recent_ts->created_by_name = 'unknown';

            $recent_upload_ts [] = $recent_ts;
        }
        $this->data['recent_upload_ts'] = $recent_upload_ts;


        //get most favorite/toprating
        //$top_rating_result = $this->db->select('*')->where(array('transcoded' => 1, 'approved' => 1, 'event_id !=' => 1))->group_by('event_id')->order_by('item_like_count desc, upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $tbl_item = $this->db->dbprefix($this->items->get_tablename());
	$top_rating_result = $this->db->query("SELECT * FROM (SELECT * FROM (`".$tbl_item."`) WHERE `transcoded` = 1 AND `approved` = 1 AND `event_id` != 1  ORDER BY `item_like_count` desc,event_id asc, `upload_date` desc ) tmp GROUP BY event_id order by event_id desc LIMIT 2")->result();
		
	$top_rating = array();
        foreach ($top_rating_result as $item) {
            /*
            if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }*/
            //$item->item_url = $wow_base_url . $item->item_url;
            //$item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

            $user_can_like = FALSE;
            if ($this->user_m->is_loggedin()) {
                $userid = $this->session->userdata('userid');
                //check if user already gave like            
                $query = 'SELECT COUNT(*) total_like FROM ' . $table_likelist . ' WHERE user_id=' . $userid . ' AND item_id=' . $item->id;
                //$user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
                $user_liked = $this->db->query($query)->row()->total_like;
                if ($user_liked == 0) {
                    $user_can_like = TRUE;
                }
            }
            $item->user_can_like = $user_can_like;

            $user_creator = $this->db->query('SELECT us.name,uc.client_userid,uc.client_app FROM ' . $table_user . ' as us LEFT JOIN '.$table_userclient.' as uc ON us.id=uc.userid WHERE us.id=' . $item->created_by)->row();

            if ($user_creator) {
                $item->created_by_name 			= $user_creator->name;
				$item->created_by_client_userid = $user_creator->client_userid;
				$item->created_by_client_app = $user_creator->client_app;
            } else {
                $item->created_by_name = 'unknown';
				$item->created_by_client_userid = 0;
				$item->created_by_client_app = 0;
			}
            $top_rating [] = $item;
        }
        $this->data['top_rating'] = $top_rating;

        $this->data['wow_news'] = $this->db->query("select * from uz_channel_news where channel_name = 'wow' and type = 1 and is_active=1 ORDER BY news_datetime DESC");


        $datakota = $this->db->query("select uz_wow_item_fieldvalue.* from uz_wow_item_fieldvalue join uz_wow_event_field on uz_wow_event_field.id_event_field=uz_wow_item_fieldvalue.id_event_field where event_field='kota'");
        $this->data['datakota'] = $datakota->result();

        //$this->load->view('channel/wow/index_new', $this->data);
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/index';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow', $this->data);
    }

    public function jury($wow_event_id) {
        //echo $wow_event_id;
       // exit;
        $this->load->model($this->_channel_name . '/content_static');

        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;

        //$wow_event_id = $this->uri->segment(4);
        /*hardcoded image big for jury, next must changed*/
        switch ($wow_event_id) {
            case '2':
                $this->data['wow_event_img'] = 'logo-digital-idol-hd.png';
                break;
            default :
                $this->data['wow_event_img'] = 'wow-10-second-banner-new.png';
        } 
        
        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');
        $where = array('event_id' => $wow_event_id);
        $jury_wow = $this->jury->get_select_where('*', $where);
        $this->data['jury'] = $jury_wow;

        //$datajury = $this->jury->get_select_where('*', array('event_id' => $wow_event_id));
        //$this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3, 'is_active'=>1))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
		$this->data['get_event_id'] = $wow_event_id;
        /*load data playme video*/
        $this->setPlaymeDataByEvent($wow_event_id);
        
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/jury';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function project() {
        $this->load->model($this->_channel_name . '/content_static');
        $this->load->model($this->_channel_name . '/category');

        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active' => 1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;

        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
        $req_event = $this->input->get('event');
        /*load data playme video*/
        $this->setPlaymeDataByEvent(($req_event)?$req_event:1);
        $this->data['themes'] = 'camera';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/project';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function upload() {
        $this->load->model($this->_channel_name . '/content_static');
        $this->load->model($this->_channel_name . '/category');

        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active' => 1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;

        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;

        //load preview (bagian bawah) from table uz_wow_category
        $this->data['previews'] = $this->category->get();

        //load tips from table uz_wow_static
        $where = array('id' => 23);
        $tips_main = $this->content_static->get_select_where('*', $where);
        $this->data['tips_main'] = $tips_main;

        //data wizard
        //load event channel
        //$this->data['is_loggedin'] = 'yes';

        if ($this->user_m->is_loggedin()) {
            $userid = $this->session->userdata('userid');
            $this->load->model($this->_channel_name . '/items');
            $mydata_result = $this->items->get_select_where('*', array('created_by' => $userid, 'transcoded' => 1, 'approved' => 1));
            $this->data['found'] = count($mydata_result);
            if ($this->data['found'] > 0) {
                foreach ($mydata_result as $_result) {
                    if (strtotime($_result->upload_date) > strtotime('2013-08-27')) {
                        $wow_base_url = base_url('userfiles/wow') . '/';
                    } else {
                        $wow_base_url = config_item('userfiles') . 'wow/';
                    }
                    $_result->item_url = $wow_base_url . $_result->item_url;
                    $_result->item_thumbnail = $wow_base_url . 'thumbnail/' . $_result->item_thumbnail;

                    $my_results [] = $_result;
                }

                $this->data['items'] = $my_results;
            }
        }

        /*load data playme video*/
        $this->setPlaymeDataByEvent();
        $this->data['themes'] = 'take';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/upload/index';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }
    
    public function gallery($event_id = 1) {
        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/like_list');

        $this->load->model($this->_channel_name . '/news');
        $this->load->model($this->_channel_name . '/jury');

        //get category_id/event id
        $this->load->model($this->_channel_name . '/wow_event_m');
        $cat = $this->wow_event_m->get_by(array('id' => $event_id), TRUE);
        $catname = $cat->name;

        $this->data['event_id'] = $event_id;
        $this->data['event_name'] = $catname;
        $this->data['sub_event'] = "Gallery";

        $this->load->model($this->_channel_name . '/content_static');

        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active' => 1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;


        //load left menu
        $where = array('event_id' => $event_id, 'is_active' => 1);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;

        //limit setting
        $limit = 5;
        //get recent upload/ new release
        //$this->load->model($this->_channel_name.'/new_release');

        $tbl_wow_item = $this->items->get_tablename();

        $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

        $recent_upload_result = $this->db->select('*')->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1))->order_by('upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $recent_upload = array();
        foreach ($recent_upload_result as $recent) {
            if (strtotime($recent->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $recent->item_url = $wow_base_url . $recent->item_url;
            $recent->item_thumbnail = $wow_base_url . 'thumbnail/' . $recent->item_thumbnail;

            //determine if user can like
            $user_can_like = FALSE;
            if ($this->user_m->is_loggedin()) {
                $userid = $this->session->userdata('userid');
                //check if user already gie like                
                $user_liked = $this->like_list->get_count(array('user_id' => $userid, 'item_id' => $recent->id));
                if ($user_liked == 0) {
                    $user_can_like = TRUE;
                }
            }
            $recent->user_can_like = $user_can_like;

            $user_creator = $this->user_m->get($recent->created_by);
            if ($user_creator)
                $recent->created_by_name = $user_creator->name;
            else
                $recent->created_by_name = 'unknown';

            $recent_upload [] = $recent;
        }
        $this->data['recent_upload'] = $recent_upload;
        
        /*         * **************** RECENT PLAY *************************** */
        //build query string
        $this->load->model('wow/play_history_m');

        $recent_play_result = $this->play_history_m->get_join(NULL, array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1), 0, $limit);
        $recent_play = array();
        foreach ($recent_play_result as $item) {

            if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $item->item_url = $wow_base_url . $item->item_url;
            $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

            //determine if user can like
            $user_can_like = FALSE;
            if ($this->user_m->is_loggedin()) {
                $userid = $this->session->userdata('userid');
                //check if user already gie like                
                $user_liked = $this->like_list->get_count(array('user_id' => $userid, 'item_id' => $item->id));
                if ($user_liked == 0) {
                    $user_can_like = TRUE;
                }
            }
            $item->user_can_like = $user_can_like;

            $user_creator = $this->user_m->get($item->created_by);
            if ($user_creator)
                $item->created_by_name = $user_creator->name;
            else
                $item->created_by_name = 'unknown';

            $recent_play [] = $item;
        }
        $this->data['recent_played'] = $recent_play;

        /*         * ************ END OF RECENT PLAY ************************* */

        //get most favorite/toprating
        $top_rating_result = $this->db->select('*')->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1))->order_by('item_like_count desc, upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $top_rating = array();
        foreach ($top_rating_result as $item) {
            if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $item->item_url = $wow_base_url . $item->item_url;
            $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

            //determine if user can like
            $user_can_like = FALSE;
            if ($this->user_m->is_loggedin()) {
                $userid = $this->session->userdata('userid');
                //check if user already gie like                
                $user_liked = $this->like_list->get_count(array('user_id' => $userid, 'item_id' => $item->id));
                if ($user_liked == 0) {
                    $user_can_like = TRUE;
                }
            }
            $item->user_can_like = $user_can_like;

            $user_creator = $this->user_m->get($item->created_by);
            if ($user_creator)
                $item->created_by_name = $user_creator->name;
            else
                $item->created_by_name = 'unknown';

            $top_rating [] = $item;
        }
        $this->data['top_rating'] = $top_rating;

        //get most top view
        $top_view_result = $this->db->select('*')->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1))->limit($limit)->get($tbl_wow_item)->result();
        $top_view = array();
        foreach ($top_view_result as $item) {
            if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $item->item_url = $wow_base_url . $item->item_url;
            $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

            //determine if user can like
            $user_can_like = FALSE;
            if ($this->user_m->is_loggedin()) {
                $userid = $this->session->userdata('userid');
                //check if user already gie like                
                $user_liked = $this->like_list->get_count(array('user_id' => $userid, 'item_id' => $item->id));
                if ($user_liked == 0) {
                    $user_can_like = TRUE;
                }
            }
            $item->user_can_like = $user_can_like;

            $user_creator = $this->user_m->get($item->created_by);
            if ($user_creator)
                $item->created_by_name = $user_creator->name;
            else
                $item->created_by_name = 'unknown';

            $top_view [] = $item;
        }
        $this->data['top_view'] = $top_view;

        //get all video random
        $all_video_result = $this->db->select('*')->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1))->order_by('rand(), upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
        $all_video = array();
        foreach ($all_video_result as $item) {
            if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                $wow_base_url = base_url('userfiles/wow') . '/';
            } else {
                $wow_base_url = config_item('userfiles') . 'wow/';
            }
            $item->item_url = $wow_base_url . $item->item_url;
            $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

            //determine if user can like
            $user_can_like = FALSE;
            if ($this->user_m->is_loggedin()) {
                $userid = $this->session->userdata('userid');
                //check if user already gie like                
                $user_liked = $this->like_list->get_count(array('user_id' => $userid, 'item_id' => $item->id));
                if ($user_liked == 0) {
                    $user_can_like = TRUE;
                }
            }
            $item->user_can_like = $user_can_like;

            $user_creator = $this->user_m->get($item->created_by);
            if ($user_creator)
                $item->created_by_name = $user_creator->name;
            else
                $item->created_by_name = 'unknown';

            $all_video [] = $item;
        }
        $this->data['all_video'] = $all_video;

        $datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;

        //Load basic layout
        //$this->data['subview'] = 'channel/'.$this->_channel_name.'/galery';
        //$this->load->view('channel/'.$this->_channel_name.'/gallery', $this->data);
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/gallery';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function nominee($event_id = 1, $which = 'recent', $page = 1) {
        //Load basic menu
        $criteria = $this->input->get('criteria', TRUE);
        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/like_list');

        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');

        //get category_id/event id
        $this->load->model($this->_channel_name . '/wow_event_m');
        $cat = $this->wow_event_m->get_by(array('id' => $event_id), TRUE);
        $catname = $cat->name;

        $this->data['event_id'] = $event_id;
        $this->data['event_name'] = $catname;
        $this->data['sub_event'] = "Gallery";

        $this->load->model($this->_channel_name . '/content_static');


        $datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;

        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;


        //load left menu
        $where = array('event_id' => $event_id);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;


        //Now get data which reqyested
        $limitPerPage = 12;
        $offset = $page - 1;

        //We only use model to get table name
        $table_name = $this->items->get_tablename();
        //count how many records which requested
        $totalRecords = 0;

        //Variable to store the limit of totalRecords to be shown
        $totalLimit = 100;

        $order_by = NULL;

        $pieces = explode("-", $which);
        $get_which = $pieces[0];

        if ($criteria == 'all') {
            $criteria = '';
        }
        $this->data['criteria'] = $criteria;
        switch ($get_which) {
            case 'recent':
                $this->data['which_name'] = 'Recent Uploads';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $order_by = 'upload_date desc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'favorite':
                $this->data['which_name'] = 'Most Favorites';
                $order_by = 'item_like_count desc, upload_date desc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'recentplayed':
                $this->data['which_name'] = 'Recent Played';
                $this->load->model('wow/play_history_m');
                $totalRecords = $this->play_history_m->get_count(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                break;

            case 'highest_vote' :
                $this->data['which_name'] = 'Highest Vote';
                $this->data['sort_by_vote'] = 'desc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $order_by = 'item_like_count desc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'lowest_vote' :
                $this->data['which_name'] = 'Lowest Vote';
                $this->data['sort_by_vote'] = 'asc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $order_by = 'item_like_count asc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'newest_date' :
                $this->data['which_name'] = 'Newest Upload';
                $this->data['sort_by_date'] = 'desc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $order_by = 'upload_date desc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'oldest_date' :
                $this->data['which_name'] = 'Oldest Upload';
                $this->data['sort_by_date'] = 'asc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $order_by = 'upload_date asc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'genre' :
                $this->data['which_name'] = 'by Genre : ' . $pieces[2];
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1, 'genre' => $pieces[1]));
                $this->db->like('item_name', $criteria);
                $order_by = 'upload_date desc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;
            case 'location' :
                $find = array();
                $locStr = urldecode($pieces[2]);
                $this->data['which_name'] = 'by Location : ' . $locStr;
                $sql = 'select * from uz_wow_item_fieldvalue where id_event_field = '.$pieces[1].' and fieldvalue = "'.$locStr.'"';                
                if (is_numeric($pieces[1])) { 
                    $itemByKota = $this->db->query($sql)->result_array();                    
                    foreach($itemByKota as $item) {
                        $find[] = $item['id_items'];
                    }
                    $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                }
                if (count($find)) {
                    $this->db->where_in('id', $find);
                    $order_by = 'upload_date desc';
                    $this->db->order_by($order_by)->limit($totalLimit);
                    $totalRecords = $this->db->count_all_results();
                } else {
                    $totalRecords = 0;
                }
                break;
            default:
                $this->data['which_name'] = 'All Uploads';
                $order_by = 'upload_date desc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->like('item_name', $criteria);
                $this->db->order_by($order_by);
                if (!empty($_GET['sort'])) {
                    $ord_by = $_GET['sort'];
                    $urutan = $_GET['val'];
                    $this->db->order_by($ord_by, $urutan);
                }
                $totalRecords = $this->db->count_all_results();
                break;
        }

        //get genre from active event id
        $this->data['get_genre'] = $this->db->query("select * from uz_wow_genre where id_category = $event_id");
        ;
        //get menu kota
        $keyValue = $this->db->query('SELECT * FROM uz_wow_event_field where event_id = '.$event_id.' and event_field = "Kota"')->result();

        $sql = 'select * from uz_wow_item_fieldvalue where '.
                ' id_items in (select id from uz_wow_items where id in '. 
                ' (SELECT id_items FROM uz_wow_item_fieldvalue where id_event_field = '.$keyValue[0]->id_event_field.')'. 
                ' and transcoded=1 and approved=1) and id_event_field='.$keyValue[0]->id_event_field.' group by fieldvalue';
        
        $this->data['filter_kota'] = $this->db->query($sql)->result();
        //exit($totalRecords);
        if ($totalRecords > 0) {
            $this->load->helper('cms');
            //set up paging
            $totalPages = ceil($totalRecords / $limitPerPage);
            $start = $offset * $limitPerPage;

            if ($which != 'recentplayed') {
                if ($get_which == 'genre') {
                    $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1, 'genre' => $pieces[1]));
                } else if ($get_which == 'location') {
                    /*set data filter by kota*/
                    $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));                    
                    $this->db->where_in('id', $find);
                } else {
                    //Load the items
                    $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                }
                $this->db->like('item_name', $criteria);
                $items_result = $this->db->order_by($order_by)->offset($start)->limit($limitPerPage)->get()->result();
            } else {
                $items_result = $this->play_history_m->get_join(NULL, array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1), $start, $limitPerPage);
            }


            $this->data['found'] = $totalRecords;
            $this->data['size'] = count($items_result);
            $this->data['start'] = $start;
            $this->data['page'] = $page;

            $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

            //iterate items to make paging
            $items = array();

            //get table like_list name
            $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
            $table_user = $this->db->dbprefix($this->user_m->get_tablename());

            foreach ($items_result as $item) {
                if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                    $wow_base_url = base_url('userfiles/wow') . '/';
                } else {
                    $wow_base_url = config_item('userfiles') . 'wow/';
                }
                $item->item_url = $wow_base_url . $item->item_url;
                $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()) {
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like            
                    $query = 'SELECT COUNT(*) total_like FROM ' . $table_likelist . ' WHERE user_id=' . $userid . ' AND item_id=' . $item->id;
                    //$user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
                    $user_liked = $this->db->query($query)->row()->total_like;
                    if ($user_liked == 0) {
                        $user_can_like = TRUE;
                    }
                }
                $item->user_can_like = $user_can_like;

                //$user_creator = $this->user_m->get($item->created_by);
                $user_creator = $this->db->query('SELECT name FROM ' . $table_user . ' WHERE id=' . $item->created_by)->row();
                if ($user_creator)
                    $item->created_by_name = $user_creator->name;
                else
                    $item->created_by_name = 'unknown';

                $items [] = $item;
            }

			/*load data playme video*/
            $this->setPlaymeDataByEvent($event_id);

            $this->data['items'] = $items;
            //exit(var_dump($this->data));
            //create js paging
            $jsClick = site_url('wow/channel/nominee') . '/' . $event_id . '/' . $which . '/$';
            $this->data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }else {
            $this->data['items'] = array();
            $this->data['pagination'] = '';
        }

        //$this->load->view('channel/'.$this->_channel_name.'/gallery_all', $this->data);
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/nominee';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function galleryall($event_id = 1, $which = 'recent', $page = 1) {
        //Load basic menu
        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/like_list');

        //get category_id/event id
        $this->load->model($this->_channel_name . '/wow_event_m');
        $cat = $this->wow_event_m->get_by(array('id' => $event_id), TRUE);
        $catname = $cat->name;

        $this->data['event_name'] = $catname;
        $this->data['sub_event'] = "Gallery";

        $this->load->model($this->_channel_name . '/content_static');

        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;


        //load left menu
        $where = array('event_id' => $event_id);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;


        //Now get data which reqyested
        $limitPerPage = 5;
        $offset = $page - 1;

        //We only use model to get table name
        $table_name = $this->items->get_tablename();
        //count how many records which requested
        $totalRecords = 0;

        //Variable to store the limit of totalRecords to be shown
        $totalLimit = 100;

        $order_by = NULL;
        switch ($which) {
            case 'recent':
                $this->data['which_name'] = 'Recent Uploads';
                $order_by = 'upload_date desc';
                $this->db->from($table_name)->where(array(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1)));
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'favorite':
                $this->data['which_name'] = 'Most Favorites';
                $order_by = 'item_like_count desc, upload_date desc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;
            case 'recentplayed':
                $this->data['which_name'] = 'Recent Played';
                $this->load->model('wow/play_history_m');
                $totalRecords = $this->play_history_m->get_count(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                break;

            default:
                $this->data['which_name'] = 'All Uploads';
                $order_by = 'upload_date desc';
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $this->db->order_by($order_by);
                $totalRecords = $this->db->count_all_results();
                break;
        }


        //exit($totalRecords);
        if ($totalRecords > 0) {
            $this->load->helper('cms');
            //set up paging
            $totalPages = ceil($totalRecords / $limitPerPage);
            $start = $offset * $limitPerPage;

            if ($which != 'recentplayed') {
                //Load the items
                $this->db->from($table_name)->where(array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1));
                $items_result = $this->db->order_by($order_by)->offset($start)->limit($limitPerPage)->get()->result();
            } else {
                $items_result = $this->play_history_m->get_join(NULL, array('event_id' => $event_id, 'transcoded' => 1, 'approved' => 1), $start, $limitPerPage);
            }


            $this->data['found'] = $totalRecords;
            $this->data['size'] = count($items_result);
            $this->data['start'] = $start;
            $this->data['page'] = $page;

            $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

            //iterate items to make paging
            $items = array();

            //get table like_list name
            $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
            $table_user = $this->db->dbprefix($this->user_m->get_tablename());

            foreach ($items_result as $item) {
                if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                    $wow_base_url = base_url('userfiles/wow') . '/';
                } else {
                    $wow_base_url = config_item('userfiles') . 'wow/';
                }
                $item->item_url = $wow_base_url . $item->item_url;
                $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()) {
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like            
                    $query = 'SELECT COUNT(*) total_like FROM ' . $table_likelist . ' WHERE user_id=' . $userid . ' AND item_id=' . $item->id;
                    //$user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
                    $user_liked = $this->db->query($query)->row()->total_like;
                    if ($user_liked == 0) {
                        $user_can_like = TRUE;
                    }
                }
                $item->user_can_like = $user_can_like;

                //$user_creator = $this->user_m->get($item->created_by);
                $user_creator = $this->db->query('SELECT name FROM ' . $table_user . ' WHERE id=' . $item->created_by)->row();
                if ($user_creator)
                    $item->created_by_name = $user_creator->name;
                else
                    $item->created_by_name = 'unknown';

                $items [] = $item;
            }



            $this->data['items'] = $items;
            //exit(var_dump($this->data));
            //create js paging
            $jsClick = site_url('wow/channel/galleryall') . '/' . $event_id . '/' . $which . '/$';
            $this->data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }else {
            $this->data['items'] = array();
            $this->data['pagination'] = '';
        }

        $this->load->view('channel/' . $this->_channel_name . '/gallery_all', $this->data);
    }

    public function event($event_category = 'general') {

        $category = $this->wow_event_m->get_by(array('slug' => $event_category), TRUE);
        $this->data['category'] = $category;
        $this->data['category_active_name'] = ucfirst($category->name);
        $this->data['image_big'] = $category->image_big;

        $categories = $this->wow_event_m->get();
        $this->data['categories'] = $categories;

        //load model
        $this->load->model($this->_channel_name . '/content_static');
        $this->data['static_menu'] = $this->content_static->get_by(array('event_id' => $category->id));

        //Load basic layout
        $this->data['subview'] = 'channel/' . $this->_channel_name . '/event/index';
        $this->load->view('_layout_main', $this->data);
    }

    public function detail($id = NULL) {

        if (!$id) {
            redirect('wow/channel');
        }

        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/like_list');
        $this->load->model($this->_channel_name . '/play_history_m');

        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');

        $this->load->model($this->_channel_name . '/like_list');
        //get detail of this item
        $wow_item = $this->items->get($id);
        if (!$wow_item)
            redirect('wow/channel');

        $wow_item->view_count = $wow_item->view_count + 1;
        //update view count
        $this->items->save(array('view_count' => ($wow_item->view_count)), $wow_item->id);

        //Insert in played history
        $this->play_history_m->save(array('play_unixtime' => time(), 'item_id' => $id));

        //get detail item create by
        $user_data = $this->user_m->get($wow_item->created_by);
        if ($user_data)
            $wow_item->created_by_name = $user_data->name;
        else
            $wow_item->created_by_name = 'unknown';
        
        /*
        //get valid url for item video / thumbnail
        //if (strtotime($wow_item->upload_date) > strtotime('2013-08-27')) {
           // $wow_base_url = base_url('userfiles/wow') . '/';
        //} else {
            //$wow_base_url = config_item('userfiles') . 'wow/';
        //}*/
        $wow_item->item_url = config_item('userfiles') . 'wow/' . $wow_item->item_url;
        $wow_item->item_thumbnail = config_item('userfiles') . 'wow/' . 'thumbnail/' . $wow_item->item_thumbnail;

        $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
        $table_user = $this->db->dbprefix($this->user_m->get_tablename());

        $user_can_like = FALSE;
        if ($this->user_m->is_loggedin()) {
            $userid = $this->session->userdata('userid');

            $query = 'SELECT COUNT(*) total_like FROM ' . $table_likelist . ' WHERE user_id=' . $userid . ' AND item_id=' . $wow_item->id;

            $user_liked = $this->db->query($query)->row()->total_like;
            if ($user_liked == 0) {
                $user_can_like = TRUE;
            }
        }

        $wow_item->user_can_like = $user_can_like;
        $this->data['wow_item'] = $wow_item;

        // to get rank data video
        $rank_collect = $this->db->query("select *, @curRank := @curRank + 1 as rank
        from uz_wow_items p, (select @curRank := 0) r
        where event_id = " . $wow_item->event_id . " and approved = 1 and transcoded=1
        order by item_like_count desc;");

        $get_rank = array();
        $total_rank = 1;
        foreach ($rank_collect->result() as $rank) {
            if ($rank->id == $wow_item->id) {
                $get_rank [] = $rank;
            }
            $total_rank++;
        }

        $this->data['rank_video'] = $get_rank;
        $this->data['total_rank_video'] = $total_rank - 1;
		
		//get related item from genre
        $items_related = $this->db->query("select * from uz_wow_items where id != ".$wow_item->id." and genre = " . $wow_item->genre . " limit 8");
        
        $array_related = array();
        foreach ($items_related->result() as $related_item) {
            /*
                if (strtotime($related_item->upload_date) > strtotime('2013-08-27')) {
                    $wow_base_url = base_url('userfiles/wow') . '/';
                } else {
                    $wow_base_url = config_item('userfiles') . 'wow/';
                }
                $related_item->item_url = $wow_base_url . $related_item->item_url;
                $related_item->item_thumbnail = $wow_base_url . 'thumbnail/' . $related_item->item_thumbnail;
             */
                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()) {
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like            
                    $query = 'SELECT COUNT(*) total_like FROM ' . $table_likelist . ' WHERE user_id=' . $userid . ' AND item_id=' . $related_item->id;
                    //$user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
                    $user_liked = $this->db->query($query)->row()->total_like;
                    if ($user_liked == 0) {
                        $user_can_like = TRUE;
                    }
                }
                $related_item->user_can_like = $user_can_like;

                //$user_creator = $this->user_m->get($item->created_by);
                $user_creator = $this->db->query('SELECT name FROM ' . $table_user . ' WHERE id=' . $related_item->created_by)->row();
                if ($user_creator)
                    $related_item->created_by_name = $user_creator->name;
                else
                    $related_item->created_by_name = 'unknown';

                $array_related [] = $related_item;
            }
        
        $this->data['related_item'] = $array_related;
		
        $this->data['event_id'] = $wow_item->event_id;


        //get event from item detail
        $event_id = $wow_item->event_id;
        //get category_id/event id
        $this->load->model($this->_channel_name . '/wow_event_m');
        $event_item = $this->wow_event_m->get_by(array('id' => $event_id), TRUE);

        $this->data['event_id'] = $event_id;
        $this->data['event_name'] = $event_item->name;
        $this->data['sub_event'] = "Gallery";

        $datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;

        //get recent upload for the selected items event / category
        $tbl_wow_item = $this->items->get_tablename();

        $this->data['can_like_dislike'] = $this->user_m->is_loggedin();




        $this->load->model($this->_channel_name . '/content_static');

        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id , 'is_active'=>1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;


        //load left menu
        $where = array('event_id' => $event_id);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;

        //load cast & crew
        $this->data['custom_field'] = $this->db->query('SELECT * FROM `uz_wow_item_fieldvalue` a join uz_wow_event_field b on a.id_event_field=b.id_event_field where a.id_items = ' . $id.' and event_id = '.$event_id)->result();
        /*load data playme video*/
        $this->setPlaymeDataByEvent($event_id);
		//file view for meta tag head fb
		$this->data['page_header'] = 'meta_nominee_detail';        
        //Load basic layout
        //$this->load->view('channel/'.$this->_channel_name.'/gallery_detail', $this->data);
                
        //cek status pernah di report apa belum 
        $this->data['status_mark'] = $this->db->query("select * from uz_wow_markspam where id_item = ".$id." and reporter = '".$this->session->userdata('username')."'");
        
        $this->data['themes'] = 'camera';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/nominee_detail';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function mygallery($page = 1) {
        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/like_list');
        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');
        $this->load->model($this->_channel_name . '/content_static');

        //cek if user is loggedin
        if (!$this->user_m->is_loggedin()) {
            //redirect to homepage if not loggedin
            redirect('wow/channel');
        }
        $userid = $this->session->userdata('userid');

        if (!$page)
            $page = 1;
        $this->data['pagenum'] = $page;

        $criteria = $this->input->get('criteria', TRUE);
        if (!$criteria || $criteria == 'all') {
            $criteria = FALSE;
            $add_query = '';
        } else {
            $add_query = "  AND (item_name LIKE '%$criteria%' OR item_description LIKE '%$criteria%' OR tag_line LIKE '%$criteria%' )";
        }
        $this->data['criteria'] = $criteria;

        /*         * ******** sorting ********************** */
        $order_by_word = $this->input->get('orderby', TRUE);
        if (!$order_by_word)
            $order_by_word = 'date';

        if ($order_by_word == 'date')
            $order_by = 'upload_date';
        elseif ($order_by_word == 'vote')
            $order_by = 'item_like_count';
        else
            $order_by = 'upload_date';

        //give back the word not actual field name
        $this->data['orderby'] = $order_by_word;

        $order_type = $this->input->get('ordertype', TRUE);
        if (!$order_type)
            $order_type = 'desc';
        $this->data['ordertype'] = $order_type;

        //We only use model to get table name
        $table_name = $this->db->dbprefix($this->items->get_tablename());

        //set up paging
        $sql = 'SELECT COUNT(*) as total_records FROM ' . $table_name . ' WHERE created_by=' . $userid . ' AND transcoded=1   AND is_deleted = 0 ';
        if ($criteria) {
            $sql.= $add_query;
        }
        $query = $this->db->query($sql)->row();

        $totalRecords = $query->total_records;
        $this->data['found'] = $totalRecords;
        //initial number of records in this active page
        $this->data['size'] = 0;
        //Now get requested data 
        $limitPerPage = 8;
        $offset = $page - 1;

        if ($totalRecords > 0) {
            $this->load->helper('cms');
            //set up paging
            $totalPages = ceil($totalRecords / $limitPerPage);
            $start = $offset * $limitPerPage;
            $this->data['start'] = $start;

            $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

            $sql = 'SELECT * FROM ' . $table_name . ' WHERE created_by=' . $userid . ' AND transcoded=1   AND is_deleted = 0 ';
            ;
            if ($criteria) {
                $sql.= $add_query;
            }
            //set order and limit
            $sql .= ' ORDER BY ' . $order_by . ' ' . $order_type;
            $sql .= ' LIMIT ' . $start . ',' . $limitPerPage;
            $items_result = $this->db->query($sql)->result();
            //exit(var_dump($items_result));
            $this->data['size'] = count($items_result);

            //get table like_list name
            $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
            $table_user = $this->db->dbprefix($this->user_m->get_tablename());

            //iterate items to make paging
            $items = array();

            foreach ($items_result as $item) {

                if (strtotime($item->upload_date) > strtotime('2013-08-27')) {
                    //$wow_base_url = 'http://devel.uzone.co.id/userfiles/wow/';
					$wow_base_url = base_url('userfiles/wow') . '/';
                } else {
                    $wow_base_url = config_item('userfiles') . 'wow/';
                }

                //$wow_base_url = config_item('userfiles') .'wow/';

                $item->item_url = $wow_base_url . $item->item_url;
                $item->item_thumbnail = $wow_base_url . 'thumbnail/' . $item->item_thumbnail;

                //determine if user can like
                $user_can_like = FALSE;
                if ($this->user_m->is_loggedin()) {
                    $userid = $this->session->userdata('userid');
                    //check if user already gave like            
                    $query = 'SELECT COUNT(*) total_like FROM ' . $table_likelist . ' WHERE user_id=' . $userid . ' AND item_id=' . $item->id;
                    //$user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
                    $user_liked = $this->db->query($query)->row()->total_like;
                    if ($user_liked == 0) {
                        $user_can_like = TRUE;
                    }
                }
                $item->user_can_like = $user_can_like;
                //delete button show only 1 day
                $item->show_delete_button = (floor(abs(strtotime($item->upload_date)-time())/86400)) > 1?false:true;
                //$user_creator = $this->user_m->get($item->created_by);
                $user_creator = $this->db->query('SELECT name FROM ' . $table_user . ' WHERE id=' . $item->created_by)->row();
                if ($user_creator)
                    $item->created_by_name = $user_creator->name;
                else
                    $item->created_by_name = 'unknown';

                $items [] = $item;
            }



            $this->data['items'] = $items;
            //exit(var_dump($this->data));
            //create js paging
            $page_url = site_url('wow/channel/mygallery') . '/$';

            if ($order_by || $criteria) {
                $query_param = array();
                if ($criteria) {
                    $query_param ['criteria'] = $criteria;
                }
                if ($order_by) {
                    $query_param ['orderby'] = $order_by;
                }
                if ($order_type) {
                    $query_param ['ordertype'] = $order_type;
                }

                $page_url .= '?' . http_build_query($query_param);
            }

            $this->data['pagination'] = smart_paging_js($totalPages, $page, $page_url, 7, '$');
        } else {
            $this->data['items'] = array();
            $this->data['pagination'] = '';
            $this->data['base_page'] = NULL;
        }



        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event) {
            $where = array('event_id' => $event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            $i++;
        }


        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3, 'is_active'=>1))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;

        $dataPlayme = $this->getDataPlayme();
        $this->data['playme_video'] = $dataPlayme; 

        //$this->load->view('channel/'.$this->_channel_name.'/gallery_all', $this->data);
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/mygallery';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function roadshow($event_id = 1, $which = 'recent', $page = 1) {


        $this->load->model($this->_channel_name . '/content_static');
        $this->load->model($this->_channel_name . '/news');
        $this->load->model($this->_channel_name . '/jury');
        // $event_id = $this->uri->segment(4);
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        $this->data['event_id'] = $event_id;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;

        $where = array('event_id' => $event_id);
        $left_menu = $this->content_static->get_select_where('*', $where);
        $this->data['left_menu'] = $left_menu;

        $this->load->model('wow/gallery_category');
        $where = array('event_id' => $event_id, 'is_active' => 1);
        $this->data['gallery_categories'] = $this->gallery_category->get_select_where('*', $where);
        //Now get data which reqyested
        $limitPerPage = 12;
        $offset = $page - 1;

        //We only use model to get table name
        $table_name = $this->news->get_tablename();
        //count how many records which requested
        $totalRecords = 0;

        //Variable to store the limit of totalRecords to be shown
        $totalLimit = 100;

        $order_by = NULL;

        $pieces = explode("-", $which);
        $get_which = $pieces[0];

        switch ($get_which) {
            case 'recent':
                $this->data['which_name'] = 'Recent Uploads';
                $this->db->from($table_name)->where(array('item_id' => $event_id, 'channel_name' => 'wow', 'type' => 2));
                $order_by = 'news_datetime desc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'newest_date' :
                $this->data['which_name'] = 'Newest Roadshow';
                $this->data['sort_by_date'] = 'desc';
                $this->db->from($table_name)->where(array('item_id' => $event_id, 'channel_name' => 'wow', 'type' => 2));
                $order_by = 'news_datetime desc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;

            case 'oldest_date' :
                $this->data['which_name'] = 'Oldest Roadshow';
                $this->data['sort_by_date'] = 'asc';
                $this->db->from($table_name)->where(array('item_id' => $event_id, 'channel_name' => 'wow', 'type' => 2));
                $order_by = 'news_datetime asc';
                $this->db->order_by($order_by)->limit($totalLimit);
                $totalRecords = $this->db->count_all_results();
                break;
        }


        //exit($totalRecords);
        if ($totalRecords > 0) {
            $this->load->helper('cms');
            //set up paging
            $totalPages = ceil($totalRecords / $limitPerPage);
            $start = $offset * $limitPerPage;
            //Load the items
            if ($which != 'recentplayed') {
                if ($get_which == 'recent') {
                    $this->db->from($table_name)->where(array('item_id' => $event_id, 'channel_name' => 'wow', 'type' => 2));
                } else {
                    //Load the items
                    $this->db->from($table_name)->where(array('item_id' => $event_id, 'channel_name' => 'wow', 'type' => 2));
                }
                $items_result = $this->db->order_by($order_by)->offset($start)->limit($limitPerPage)->get()->result();
            } else {
                $items_result = $this->play_history_m->get_join(NULL, $event_id, $start, $limitPerPage);
            }


            $this->data['found'] = $totalRecords;
            $this->data['size'] = count($items_result);
            $this->data['start'] = $start;
            $this->data['page'] = $page;

            //iterate items to make paging
            $items = array();
            $this->load->model('user_m');
            foreach ($items_result as $item) {

                //$user_creator = $this->user_m->get($item->created_by);
                $user = $this->user_m->get_select_where('u_name', array('id' => $item->news_by), TRUE);
                if ($user)
                    $this->data['user_name'] = $user->u_name;
                else
                    $this->data['user_name'] = 'unknown';

                $items [] = $item;
            }



            $this->data['items'] = $items;
            //exit(var_dump($this->data));
            //create js paging
            $jsClick = site_url('wow/channel/roadshow') . '/' . $event_id . '/' . $which . '/$';
            $this->data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');
        }else {
            $this->data['items'] = array();
            $this->data['pagination'] = '';
        }

        // $where = array('item_id'=> $wow_event_id);
        // $news_wow = $this->news->get_select_where('*', $where);
        // $this->data['news'] = $news_wow;
        //get category_id/event id
        $this->load->model($this->_channel_name . '/wow_event_m');
        $cat = $this->wow_event_m->get_by(array('id' => $event_id), TRUE);
        $catname = $cat->name;
        $this->data['event_name'] = $catname;

        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
		
		
        $this->data['themes'] = 'movie';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/roadshow';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function detail_roadshow($id = NULL) {

        if (!$id) {
            redirect('wow/channel');
        }

        $this->load->model($this->_channel_name . '/items');
        $this->load->model($this->_channel_name . '/like_list');

        $this->load->model($this->_channel_name . '/jury');

        //get detail of this item
        $wow_item = $this->items->get($id);

        $this->load->model($this->_channel_name . '/content_static');

        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;


        $this->load->model($this->_channel_name . '/news');
        $wow_event_id = $this->uri->segment(4);
        $where = array('id' => $wow_event_id);
        $news_wow = $this->news->get_select_where('*', $where, TRUE);
        $this->data['wow_item'] = $news_wow;

        $this->load->model('user_m');
        $user = $this->user_m->get_select_where('u_name', array('id' => $news_wow->news_by), TRUE);
        if ($user)
            $this->data['user_name'] = $user->u_name;
        else
            $this->data['user_name'] = 'unknown';

        //load cast & crew
        $this->data['custom_field'] = $this->db->query('SELECT * FROM `uz_wow_item_fieldvalue` a join uz_wow_event_field b on a.id_event_field=b.id_event_field where a.id_items = ' . $id)->result();

        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3, 'is_active'=>1))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
        //Load basic layout
        //$this->load->view('channel/'.$this->_channel_name.'/gallery_detail', $this->data);
        $this->data['themes'] = 'camera';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/roadshow_detail';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }

    public function video_footer($id) {
        $this->load->model($this->_channel_name . '/news');

        $datavideo = $this->news->get($id, TRUE);
        $this->data['data_video'] = $datavideo;

        $dataPlayme = $this->getDataPlayme($id);
        $this->data['data_playme'] = $dataPlayme;        
        $this->load->view('channel/' . $this->_channel_name . '/components/video_footer', $this->data);
    }

    public function video($id) {
        $this->load->model($this->_channel_name . '/news');

        $datavideo = $this->news->get($id, TRUE);
        $this->data['data_video'] = $datavideo;

        $this->load->view('channel/' . $this->_channel_name . '/components/video', $this->data);
    }

    public function comingsoon() {
        $this->initMenuWOW();

        $dataPlayme = $this->getDataPlayme();
        $this->data['playme_video'] = $dataPlayme; 
        $this->data['themes'] = 'take';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/coming-soon';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }
    /*
      public function nominee($event_id=1, $which='recent', $page=1){
      //Load basic menu
      $criteria = $this->input->get('criteria', TRUE);
      $this->load->model($this->_channel_name.'/items');
      $this->load->model($this->_channel_name.'/like_list');

      $this->load->model($this->_channel_name.'/jury');
      $this->load->model($this->_channel_name.'/news');

      //get category_id/event id
      $this->load->model($this->_channel_name.'/wow_event_m');
      $cat = $this->wow_event_m->get_by(array('id'=>$event_id), TRUE);
      $catname = $cat->name;

      $this->data['event_id'] = $event_id;
      $this->data['event_name'] = $catname;
      $this->data['sub_event'] = "Nominee";

      $this->load->model($this->_channel_name.'/content_static');


      $datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
      $this->data['list_jury'] = $datajury;

      $tbl_news = $this->news->get_tablename();
      $datanews = $this->db->select('*')->where(array('channel_name'=>'wow'))->order_by('id desc')->limit(1)->get($tbl_news)->result();
      $this->data['data_news'] = $datanews;

      //get all event
      $today = date("Y-m-d H:i:s");
      $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
      $event_active = $this->wow_event_m->get_select_where('*', $where);
      $this->data['event_active'] = $event_active;

      $i = 1;
      foreach($event_active as $event):
      $where = array('event_id'=>$event->id);
      $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
      //$dropdown = $this->content_static->get_select_where('*', $where);
      $i++;
      endforeach;


      //load left menu
      $where = array('event_id' => $event_id);
      $left_menu = $this->content_static->get_select_where('*', $where);
      $this->data['left_menu'] = $left_menu;


      //Now get data which reqyested
      $limitPerPage = 12;
      $offset = $page - 1;

      //We only use model to get table name
      $table_name = $this->items->get_tablename();
      //count how many records which requested
      $totalRecords = 0;

      //Variable to store the limit of totalRecords to be shown
      $totalLimit = 100;

      $order_by = NULL;

      $pieces = explode("-", $which);
      $get_which = $pieces[0];

      if ($criteria=='all'){
      $criteria = '';
      }
      $this->data['criteria'] = $criteria;
      switch($get_which){
      case 'recent':
      $this->data['which_name'] = 'Recent Uploads';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $order_by = 'upload_date desc';
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      case 'favorite':
      $this->data['which_name'] = 'Most Favorites';
      $order_by = 'item_like_count desc, upload_date desc';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      case 'recentplayed':
      $this->data['which_name'] = 'Recent Played';
      $this->load->model('wow/play_history_m');
      $totalRecords = $this->play_history_m->get_count(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      break;

      case 'highest_vote' :
      $this->data['which_name'] = 'Highest Vote';
      $this->data['sort_by_vote'] = 'desc';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $order_by = 'item_like_count desc';
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      case 'lowest_vote' :
      $this->data['which_name'] = 'Lowest Vote';
      $this->data['sort_by_vote'] = 'asc';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $order_by = 'item_like_count asc';
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      case 'newest_date' :
      $this->data['which_name'] = 'Newest Upload';
      $this->data['sort_by_date'] = 'desc';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $order_by = 'upload_date desc';
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      case 'oldest_date' :
      $this->data['which_name'] = 'Oldest Upload';
      $this->data['sort_by_date'] = 'asc';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $order_by = 'upload_date asc';
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      case 'genre' :
      $this->data['which_name'] = 'by Genre : '.$pieces[2];
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1,'genre' => $pieces[1], 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $order_by = 'upload_date desc';
      $this->db->order_by($order_by)->limit($totalLimit);
      $totalRecords = $this->db->count_all_results();
      break;

      default:
      $this->data['which_name'] = 'All Uploads';
      $order_by = 'upload_date desc';
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      $this->db->like('item_name', $criteria);
      $this->db->order_by($order_by);
      if(!empty($_GET['sort'])) {
      $ord_by = $_GET['sort'];
      $urutan = $_GET['val'];
      $this->db->order_by($ord_by,$urutan);
      }
      $totalRecords = $this->db->count_all_results();
      break;
      }

      //get genre from active event id
      $this->data['get_genre'] = $this->db->query("select * from uz_wow_genre where id_category = $event_id");;

      //exit($totalRecords);
      if ($totalRecords>0){
      $this->load->helper('cms');
      //set up paging
      $totalPages = ceil($totalRecords / $limitPerPage);
      $start = $offset * $limitPerPage;

      if ($which!='recentplayed'){
      if($get_which == 'genre') {
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'genre' => $pieces[1], 'nominee' => 1));
      } else {
      //Load the items
      $this->db->from($table_name)->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1));
      }
      $this->db->like('item_name', $criteria);
      $items_result = $this->db->order_by($order_by)->offset($start)->limit($limitPerPage)->get()->result();
      }else{
      $items_result = $this->play_history_m->get_join(NULL, array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1, 'nominee' => 1), $start, $limitPerPage);
      }


      $this->data['found'] = $totalRecords;
      $this->data['size'] = count($items_result);
      $this->data['start'] = $start;
      $this->data['page'] = $page;

      $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

      //iterate items to make paging
      $items = array();

      //get table like_list name
      $table_likelist = $this->db->dbprefix($this->like_list->get_tablename());
      $table_user = $this->db->dbprefix($this->user_m->get_tablename());

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
      $query = 'SELECT COUNT(*) total_like FROM '.$table_likelist.' WHERE user_id='.$userid.' AND item_id='.$item->id;
      //$user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$item->id));
      $user_liked = $this->db->query($query)->row()->total_like;
      if ($user_liked == 0){
      $user_can_like = TRUE;
      }
      }
      $item->user_can_like = $user_can_like;

      //$user_creator = $this->user_m->get($item->created_by);
      $user_creator = $this->db->query('SELECT name FROM '.$table_user.' WHERE id='.$item->created_by)->row();
      if ($user_creator)
      $item->created_by_name = $user_creator->name;
      else
      $item->created_by_name = 'unknown';

      $items [] = $item;
      }



      $this->data['items'] = $items;
      //exit(var_dump($this->data));
      //create js paging
      $jsClick = site_url('wow/channel/nominee').'/'.$event_id.'/'.$which.'/$';
      $this->data['pagination'] = smart_paging_js($totalPages, $page, $jsClick, 7, '$');

      }else{
      $this->data['items'] = array();
      $this->data['pagination'] = '';
      }

      //$this->load->view('channel/'.$this->_channel_name.'/gallery_all', $this->data);
      $this->data['themes'] = 'movie';
      $this->data['page'] = 'channel/' . $this->_channel_name . '/page/nominee';
      $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
      }

      public function nominee_detail($id=NULL){

      if (!$id){
      redirect('wow/channel');
      }

      $this->load->model($this->_channel_name.'/items');
      $this->load->model($this->_channel_name.'/like_list');
      $this->load->model($this->_channel_name.'/play_history_m');

      $this->load->model($this->_channel_name.'/jury');
      $this->load->model($this->_channel_name.'/news');

      //get detail of this item
      $wow_item = $this->items->get($id);
      if (!$wow_item)
      redirect ('wow/channel');

      $wow_item->view_count = $wow_item->view_count + 1;
      //update view count
      $this->items->save(array('view_count'=>($wow_item->view_count)), $wow_item->id);

      //Insert in played history
      $this->play_history_m->save(array('play_unixtime'=>time(), 'item_id'=>$id));

      //get detail item create by
      $user_data = $this->user_m->get($wow_item->created_by);
      if ($user_data)
      $wow_item->created_by_name = $user_data->name;
      else
      $wow_item->created_by_name = 'unknown';

      //get valid url for item video / thumbnail
      if (strtotime($wow_item->upload_date) > strtotime('2013-08-27')){
      $wow_base_url = base_url('userfiles/wow').'/';
      }else{
      $wow_base_url = config_item('userfiles') .'wow/';
      }
      $wow_item->item_url = $wow_base_url  . $wow_item->item_url;
      $wow_item->item_thumbnail = $wow_base_url .'thumbnail/'. $wow_item->item_thumbnail;

      $this->data['wow_item'] = $wow_item;

      // to get rank data video
      $rank_collect = $this->db->query("select *, @curRank := @curRank + 1 as rank
      from uz_wow_items p, (select @curRank := 0) r
      where event_id = ".$wow_item->event_id."
      order by item_like_count desc;");

      $get_rank = array();
      $total_rank = 1;
      foreach ($rank_collect->result() as $rank) {
      if($rank->id == $wow_item->id ){
      $get_rank [] = $rank;
      }
      $total_rank++;
      }

      $this->data['rank_video'] = $get_rank;
      $this->data['total_rank_video'] = $total_rank-1;

      $this->data['event_id'] = $wow_item->event_id;


      //get event from item detail
      $event_id = $wow_item->event_id;
      //get category_id/event id
      $this->load->model($this->_channel_name.'/wow_event_m');
      $event_item = $this->wow_event_m->get_by(array('id'=>$event_id), TRUE);

      $this->data['event_id'] = $event_id;
      $this->data['event_name'] = $event_item->name;;
      $this->data['sub_event'] = "Gallery";

      $datajury = $this->jury->get_select_where('*', array('event_id' => $event_id));
      $this->data['list_jury'] = $datajury;

      $tbl_news = $this->news->get_tablename();
      $datanews = $this->db->select('*')->where(array('channel_name'=>'wow'))->order_by('id desc')->limit(1)->get($tbl_news)->result();
      $this->data['data_news'] = $datanews;

      //get recent upload for the selected items event / category
      $tbl_wow_item = $this->items->get_tablename();

      $this->data['can_like_dislike'] = $this->user_m->is_loggedin();

      $limit = 5;
      $recent_upload_result = $this->db->select('*')->where(array('event_id'=>$event_id,'transcoded'=>1,'approved'=>1))->order_by('upload_date desc')->limit($limit)->get($tbl_wow_item)->result();
      $recent_upload = array();
      foreach($recent_upload_result as $recent){
      if (strtotime($recent->upload_date) > strtotime('2013-08-27')){
      $wow_base_url = base_url('userfiles/wow').'/';
      }else{
      $wow_base_url = config_item('userfiles') .'wow/';
      }
      $recent->item_url = $wow_base_url  . $recent->item_url;
      $recent->item_thumbnail = $wow_base_url .'thumbnail/'. $recent->item_thumbnail;

      //determine if user can like
      $user_can_like = FALSE;
      if ($this->user_m->is_loggedin()){
      $userid = $this->session->userdata('userid');
      //check if user already gie like
      $user_liked = $this->like_list->get_count(array('user_id'=>$userid, 'item_id'=>$recent->id));
      if ($user_liked == 0){
      $user_can_like = TRUE;
      }
      }
      $recent->user_can_like = $user_can_like;

      $recent_upload [] = $recent;
      }
      $this->data['recent_upload'] = $recent_upload;



      $this->load->model($this->_channel_name.'/content_static');

      //get all event
      $today = date("Y-m-d H:i:s");
      $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
      $event_active = $this->wow_event_m->get_select_where('*', $where);
      $this->data['event_active'] = $event_active;

      $i = 1;
      foreach($event_active as $event):
      $where = array('event_id'=>$event->id);
      $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
      //$dropdown = $this->content_static->get_select_where('*', $where);
      $i++;
      endforeach;


      //load left menu
      $where = array('event_id' => $event_id);
      $left_menu = $this->content_static->get_select_where('*', $where);
      $this->data['left_menu'] = $left_menu;

      //load cast & crew
      $this->data['custom_field'] = $this->db->query('SELECT * FROM `uz_wow_item_fieldvalue` a join uz_wow_event_field b on a.id_event_field=b.id_event_field where a.id_items = '.$id)->result();

      //Load basic layout
      //$this->load->view('channel/'.$this->_channel_name.'/gallery_detail', $this->data);
      $this->data['themes'] = 'camera';
      $this->data['page'] = 'channel/' . $this->_channel_name . '/page/nominee_detail';
      $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
      }
     */
	 
	 	public function contact(){
        
        $this->load->model($this->_channel_name.'/content_static');
        $this->load->model($this->_channel_name.'/wow_event_m');		
		$this->load->model($this->_channel_name.'/jury');
		$this->load->model($this->_channel_name.'/news');
		$this->load->model($this->_channel_name.'/contact_form');
		$this->load->helper(array('captcha'));			
		$this->load->library('form_validation');
		
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirmCaptcha','confirm security code','required|callback_check_captcha');
			
        $today = date("Y-m-d H:i:s");
        $where = array('status'=>1, 'start_date <= '=>$today ,'stop_date >='=>$today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;
        
        $i = 1;
        foreach($event_active as $event):
            $where = array('event_id'=>$event->id);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;
       
		
        $datajury = $this->jury->get_offset('*',null,0,2);	
		$this->data['list_jury'] = $datajury;
		
		$tbl_news = $this->news->get_tablename();
		$datanews = $this->db->select('*')->where(array('channel_name'=>'wow','type'=>3))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;
		

        $this->data['themes'] = 'guitar';
        
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('content', 'Content', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirmCaptcha','confirm security code','required|callback_check_captcha');

		if($this->form_validation->run() == FALSE) {
				$vals = array(
				'img_path'	 => './captcha/',
				'img_url'	 => base_url().'captcha/',
				'img_width'	 => '180',
				'img_height' => '60',
				'expiration' => 3600
				);
				
				$cap = create_captcha($vals);
				$this->data['captcha'] = $cap;
				$this->session->set_userdata('captchaWord',$cap['word']);
				$this->data['page'] = 'channel/' . $this->_channel_name . '/page/contact';
					
		} else {
			
			
			$data = array(
			'name'    		=> $this->input->post('name'),
			'email'     	=> $this->input->post('email'),
			'phone'     	=> $this->input->post('phone'),
			'content'     	=> $this->input->post('content'),
			'create_date'	=> date('Y-m-d h:i:s')
			);
			$this->contact_form->save($data);


			$this->data['page'] = 'channel/' . $this->_channel_name . '/page/contact-sukses';
		}
		
        $this->load->view('channel/'.$this->_channel_name .'/layout_wow_black', $this->data);
	}
	
	public function check_captcha($confirmCaptcha){
        if ($this->_check_captcha($confirmCaptcha) == 0)
        {
            $this->form_validation->set_message('check_captcha','Kode security harus diisi dengan benar');
            return false;
        }
        return true;
    }
    protected function _check_captcha($confirmCaptcha){
        $captchaWord = $this->session->userdata('captchaWord');
        
        $this->session->unset_userdata('captchaWord');
        if(strcasecmp($captchaWord, $confirmCaptcha) == 0){
            return true;
        }
        return false;
    }
    
    public function schedule($id = 3) {
        $this->load->model($this->_channel_name . '/content_static');
        $this->load->model($this->_channel_name . '/category');

        $this->load->model($this->_channel_name . '/jury');
        $this->load->model($this->_channel_name . '/news');
        $this->load->library('schedule');
        
        /*data schedule*/
        $this->schedule->setStartDate('2013-09-01') ;
        $this->schedule->setEndDate('2014-12-01') ;
        $dataTmp = array();
        if ($id == 3) {
            $dataTmp = array(
                array('title' => 'Upload video', 'start_date' => '2013-9-25', 'end_date' => '2013-11-30', 'jml_col' => 9, 'id'=> 0),
                array('title' => 'Voting', 'start_date' => '2013-9-25', 'end_date' => '2013-12-10', 'jml_col' => 11, 'id'=> 0),
                array('title' => 'Pengumuman 10 finalis', 'start_date' => '2013-12-13', 'end_date' => '2013-12-13', 'jml_col' => 1, 'id'=> 3),
                //array('title' => 'Penjurian dan voting babak final', 'start_date' => '2013-11-12', 'end_date' => '2013-12-19', 'jml_col' =>4, 'id'=> 2),
                array('title' => 'Screening & Pengumuman pemenang', 'start_date' => '2013-12-19', 'end_date' => '2013-12-19', 'jml_col' => 1, 'id'=> 3),
            );
        }
        $this->schedule->setData($dataTmp);        
        
        //get all event
        $today = date("Y-m-d H:i:s");
        $where = array('status' => 1, 'start_date <= ' => $today, 'stop_date >=' => $today);
        $event_active = $this->wow_event_m->get_select_where('*', $where);
        $this->data['event_active'] = $event_active;

        $i = 1;
        foreach ($event_active as $event):
            $where = array('event_id' => $event->id, 'is_active' => 1);
            $this->data['dropdown'][$i] = $this->content_static->get_select_where('*', $where);
            //$dropdown = $this->content_static->get_select_where('*', $where);
            $i++;
        endforeach;

        $datajury = $this->jury->get_select_where('*', array('event_id' => 1));
        $this->data['list_jury'] = $datajury;

        $tbl_news = $this->news->get_tablename();
        $datanews = $this->db->select('*')->where(array('channel_name' => 'wow', 'type' => 3, 'is_active' => 1))->order_by('news_datetime desc')->limit(1)->get($tbl_news)->result();
        $this->data['data_news'] = $datanews;

        //load preview (bagian bawah) from table uz_wow_category
        $this->data['previews'] = $this->category->get();

        //load tips from table uz_wow_static
        $where = array('id' => 23);
        $tips_main = $this->content_static->get_select_where('*', $where);
        $this->data['tips_main'] = $tips_main;

        //data wizard
        //load event channel
        //$this->data['is_loggedin'] = 'yes';

        if ($this->user_m->is_loggedin()) {
            $userid = $this->session->userdata('userid');
            $this->load->model($this->_channel_name . '/items');
            $mydata_result = $this->items->get_select_where('*', array('created_by' => $userid, 'transcoded' => 1, 'approved' => 1));
            $this->data['found'] = count($mydata_result);
            if ($this->data['found'] > 0) {
                foreach ($mydata_result as $_result) {
                    if (strtotime($_result->upload_date) > strtotime('2013-08-27')) {
                        $wow_base_url = base_url('userfiles/wow') . '/';
                    } else {
                        $wow_base_url = config_item('userfiles') . 'wow/';
                    }
                    $_result->item_url = $wow_base_url . $_result->item_url;
                    $_result->item_thumbnail = $wow_base_url . 'thumbnail/' . $_result->item_thumbnail;

                    $my_results [] = $_result;
                }

                $this->data['items'] = $my_results;
            }
        }
        /*load data playme video*/
        $this->setPlaymeDataByEvent($id);		

        $this->data['themes'] = 'take';
        $this->data['page'] = 'channel/' . $this->_channel_name . '/page/schedule';
        $this->load->view('channel/' . $this->_channel_name . '/layout_wow_black', $this->data);
    }
}
