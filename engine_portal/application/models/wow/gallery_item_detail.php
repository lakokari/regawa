<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Gallery_item_detail extends MY_Model {
    protected $_table_name = 'wow_gallery_item_detail';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'date_time desc';
}

?>
