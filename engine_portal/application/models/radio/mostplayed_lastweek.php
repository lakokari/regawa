<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Album
 *
 * @author master
 */
class Mostplayed_lastweek extends MY_Model {
    protected $_table_name = 'uz_radio_mostly_lastweek';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'played DESC, inserted_time DESC';
}

