<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Music
 *
 * @author master
 */
class Channel extends U_Controller {

    protected $_channel_name = 'music';

    function __construct() {
        parent::__construct();

        $this->data['channel_name'] = $this->_channel_name;
    }

    public function index() {
        //load category model
        $this->load->model($this->_channel_name . '/category');
        $this->data['categories'] = $this->category->get();

        $this->data['subview'] = 'channel/' . $this->_channel_name . '/index';
        $this->load->view('_layout_main', $this->data);
    }
    
    public function deleteplaylist() {
        $urut = $this->input->post('urut');
        unset($this->session->userdata['playlist']['id'][$urut]);
        unset($this->session->userdata['playlist']['songInfo'][$urut]);
        $this->session->sess_write();
    }

    function musicview() { /* 05/08/2013 by Alex */
        $id = $this->input->post('id');
        $this->load->model($this->_channel_name . '/song');
        $viewcount = $this->song->get_by(array('id' => $id), TRUE);
        $viewcount = $viewcount->view_count + 1;
        $data = array('view_count' => $viewcount);
        $this->song->save($data, $id);
    }

}

?>
