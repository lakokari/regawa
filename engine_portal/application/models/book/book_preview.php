<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Items
 *
 * @author master
 */
class Book_preview extends MY_Model {
    protected $_table_name = 'uz_book_preview';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'content_id_token, inserted_time DESC';
    
}
