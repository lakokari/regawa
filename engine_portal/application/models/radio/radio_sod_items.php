<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Radio_sod_items extends MY_Model {
    protected $_table_name = 'uz_radio_sods';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'inserted_time DESC';
}

