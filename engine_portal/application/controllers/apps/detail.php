<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Channel of Music
 *
 * @author master
 */
class Detail extends U_Controller {
    
    protected $_channel_name = 'apps';
    
    function __construct() {
        parent::__construct();
    }

    public function apps($parent_id, $appsId) {
        
        //load item model
        $this->load->model($this->_channel_name.'/items');
        $this->data['item'] = $this->items->get_select_where('*',array('package_id'=>$appsId, 'parent_id'=>$parent_id), TRUE);

        $cat_id = $this->data['item']->category_id;

        //load parentcategory model
        $this->load->model('apps/parentcategory');
        $this->data['parentcategories'] = $this->parentcategory->get();
        $cur_device =  $this->parentcategory->get($parent_id, true);
        $this->data['device_type'] = $cur_device->name;

        //load category model
        $this->load->model('apps/category');
        $this->data['categories'] = $this->category->get_by(array('category_id'=>$cat_id), TRUE);

        //load top model
        $this->load->model('apps/top');
        $this->data['top_web'] = $this->top->get_offset('*', array('parent_id'=>'1'), 0, 10);
        $this->data['top_mob'] = $this->top->get_offset('*', array('parent_id'=>'2'), 0, 10);

        $this->data['subview'] = 'channel/'.$this->_channel_name.'/appsdetail';
        $this->load->view('_layout_main', $this->data);
    }
}

?>
