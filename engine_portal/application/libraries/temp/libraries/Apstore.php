<?php

/**
 * Description of ApStore
 *
 * @author master
 */
class ApStore {
    
    protected $curl = NULL;
    
    protected $api_app_id = 'uzone';     //Telkom Store API APPID (required)
    protected $api_password = 't3lk0m13';    //Telkom Store API Password (required)
    protected $api_url = 'http://www.telkomstore.com/api/uzone/'; 
    protected $speedy_api_url = 'http://store.telkomspeedy.com/api/uzone/'; 
    
    protected $_cookie_file = 'cookiesApStore.log';
    
    public $error_message  = '';
            
    protected $acc_speedy = array(
        'app_id'        =>  'uzone',
        'password'      =>  't3lk0m13'
    );
    
    function __construct() {
        $this->curl = curl_init();
    }
    
    /**
     * function featured
     * Get featured items from Telkom Application Store
     * 
     * @return boolean FALSE if failed on success return data
     */
    public function featured() {
        $post_fields = array(
            'app_id'            => urlencode($this->api_app_id),
            'password'          => $this->api_password
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->api_url . 'featured/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    /**
     * function category
     * 
     * Get categories or items in a category from Telkom Application Store
     * 
     * @param INT $category_id default NULL
     * @param INT $offset default 0 page number
     * @param type $limit default 30 data limit
     * @return boolean FALSE if failed on success return data
     */
    public function category($category_id=NULL, $offset=0, $limit=30) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password
        );
        if ($category_id){
            $post_fields ['category_id'] = $category_id;
            $post_fields ['offset']      = $offset;
            $post_fields['limit']        = $limit;
        }
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->api_url . 'category/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    /**
     * Get items from Telkom Application Store based on order specified
     * @param type $order_by
     * @param type $offset
     * @param type $limit
     * @return boolean
     */
    public function orderBy($order_by, $offset=0, $limit=30) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password,
            'order_by'          =>  $order_by,
            'offset'            =>  $offset,
            'limit'             =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->api_url . 'orderby/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    /**
     * Get item detail from Telkom Application Store
     * @param type $item_id
     * @return boolean
     */
    public function item($item_id) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password,
            'item_id'          =>  $item_id
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->api_url . 'item/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    public function search($keywords, $offset=0, $limit=30) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password,
            'keyword'           =>  $keywords,
            'offset'            =>  $offset,
            'limit'             =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->api_url . 'search/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    //From speedy App Store
    
    public function speedy_comment($item_id, $offset=0, $limit=30) {
        $post_fields = array(
            'app_id'            => urlencode($this->api_app_id),
            'password'          => $this->api_password,
            'item_id'           =>  $item_id,
            'offset'            =>  $offset,
            'limit'             =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        //curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->speedy_api_url . 'comment/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    public function speedy_category($category_id=NULL, $offset=0, $limit=30) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password
        );
        if ($category_id){
            $post_fields ['category_id'] = $category_id;
            $post_fields ['offset']      = $offset;
            $post_fields['limit']        = $limit;
        }
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        //curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->speedy_api_url . 'category/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    public function speedy_orderBy($order_by, $offset=0, $limit=30) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password,
            'order_by'          =>  $order_by,
            'offset'            =>  $offset,
            'limit'             =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        //curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->speedy_api_url . 'orderby/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    public function speedy_item($item_id) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password,
            'item_id'          =>  $item_id
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->speedy_api_url . 'item/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
    
    public function speedy_search($keywords, $offset, $limit) {
        $post_fields = array(
            'app_id'            =>  urlencode($this->api_app_id),
            'password'          =>  $this->api_password,
            'keyword'           =>  $keywords,
            'offset'            =>  $offset,
            'limit'             =>  $limit
        );
        
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, time() . $this->_cookie_file);
        curl_setopt($this->curl, CURLOPT_URL, $this->speedy_api_url . 'search/');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        
        $data = json_decode(curl_exec($this->curl));
        
        if (isset($data->error_code)&&$data->error_code=='Failed')
        {
            $this->error_message = $data->error_info;
            return FALSE;
        }
        
        return $data;
    }
}

?>
